<?php

namespace Modules\Application\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Application\Emails\VerifyEmails;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\AdmissionDocument;
use Modules\Application\Entities\Applicant;
use Illuminate\Support\Facades\Hash;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Application\Entities\Guardian;
use Modules\Application\Entities\Notification;
use Modules\Application\Entities\Sponsor;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\WorkExperience;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Intake;
use Session;
use Auth;
use Illuminate\Support\Facades\Mail;
use Modules\COD\Entities\CODLog;
use Modules\Dean\Entities\DeanLog;
use Modules\Finance\Entities\FinanceLog;
use Image;
use Route;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function login()
    {
        return view('application::auth.signin');
    }

    public function register()
    {
        return view('application::auth.signup');
    }

    public function reloadCaptcha(){

        return response()->json(['captcha'=> captcha_img()]);
    }

    public function signup(Request $request){

        $validated = $request->validate([
            'email' => 'required|email|unique:applicants',
            'mobile' => 'required|unique:applicants',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

            $app = new Applicant;
            $app->mobile = $request->mobile;
            $app->username = $request->email;
            $app->email = $request->email;
            $app->password = Hash::make($request->password);
            $app->student_type = 1;
            $app->save();

            VerifyEmail::create([
                'applicant_id' => $app->id,
                'verification_code' => Str::random(100),
            ]);

            Mail::to($app->email)->send(new VerifyEmails($app));

            return redirect(route('root'))->with(['info' => 'Account verification email was sent to verify your account']);
    }

    public function phoneverify(){
        return view('application::auth.phoneverification');
    }

    public function phonereverification(Request $request){

        $validated = $request->validate([
            'verification_code' => 'required',
            'phone_number' => 'required'
        ]);

                $unverified = VerifyUser::where('verification_code', $request->verification_code)->first();

                if (!$unverified){

                    return redirect()->back()->with('error', 'Wrong code! Please request for a new code');
                }

                $applicant = $unverified->verifyUser;

            if (!$applicant->phone_verification){
                $applicant->phone_verification = 1;
                $applicant->save();

                VerifyUser::where('verification_code', $request->verification_code)->delete();

                return redirect()->route('application.applicant')->with('success', 'Phone number verified successfully');

            }else{
                abort(403);
            }

        return redirect()->back()->with('error', 'Phone number failed verification');
    }

    public function getNewCode(){

        VerifyUser::where('applicant_id', Auth::user()->id)->delete();

        $verification_code = rand(1, 999999);

        $number = Auth::user()->mobile;

        VerifyUser::create([
            'applicant_id' => Auth::user()->id,
            'verification_code' => $verification_code,
        ]);

        $apiKey   = '39d6ee3bed35128162d45e5b0e68275116de838ee0d657546de71758a82a2c01';
        $username = 'cicsystems';
        $sender   = '';

        $receiver = '+254'. \Illuminate\Support\Facades\Auth::user()->mobile;

        $message = 'Welcome to TUM course application system. Your verification code is '. $verification_code.'.Do not share your verification code with anyone.';


        $gateway  = new AfricasTalking($username, $apiKey);

        $gateway->sms()->send([
            'to'      => $receiver,
            'message' => $message,
            'from'    => $sender,
            'enqueue' => true
        ]);

        return redirect()->back()->with(['info' => 'Enter the code send to your phone', 'code' => $verification_code]);

    }

    public function emailVerification($verification_code){

        $unverified = VerifyEmail::where('verification_code', $verification_code)->first();

       if (isset($unverified)){

                    $applicant = $unverified->userEmail;

                    if (!$applicant->email_verified_at){
                        $applicant->email_verified_at = Carbon::now();
                        $applicant->save();

                        VerifyEmail::where('verification_code', $verification_code)->delete();

                        return redirect(route('root'))->with('success', 'Your email has been verified');
                    }else{

                        return redirect(route('root'))->with('warning', 'The code does not exist');

                    }

                }else{
                    return redirect(route('root'))->with('info', 'Email already verified');
                }
    }

    public function checkverification(){

        return view('application::auth.landing');
    }

    public function dashboard(){

        $intakes = Intake::where('status', 1)->get();

        if (count($intakes) == 0){

            $courses = [];

        }else {

            $intake = Intake::where('status', 1)->get();

            foreach ($intake as $id) {
                $course = AvailableCourse::where('intake_id', $id->id)->get();

                foreach ($course as $item) {
                    $available_courses [] = Courses::where('id', $item->course_id)->count();

                    $courses = $available_courses;
                }

            }
        }

        $apps  = Application::where('applicant_id', Auth::user()->id)->get();

                if (count($apps) == 0){

                    $notification = [];
                }else{

                    foreach ($apps as $app_id){
                        $notification = Notification::where('application_id', $app_id->id)->where('status', '>', 0)->get();

                    }
                }

        $mycourses = Application::where('applicant_id', Auth::user()->id)->count();

        if (Auth::check()) {
//
                if (Auth::user()->email_verified_at == null){
                    Auth::logout();
                        return redirect(route('root'))->with('warning', 'Please verify your email first');
                                }
                    if (Auth::user()->user_status == 0) {
                        return redirect()->route('application.details')->with(['info' => 'Please update your profile']);

                    } else {

                        return view('application::applicant.home')->with(['success' => 'Welcome', 'courses' => $courses, 'mycourses' => $mycourses, 'notification' => $notification]);

                    }

                    redirect()->route('application.login')->with('error', 'Please try again');

        }

    }


    public function reverify(){
        return view('application::auth.reverifyphone');
    }

    public function openDetails(){
        return view('application::applicant.updatePage')->with('info', 'Update your profile to continue');
    }

    public function makeupdate(Request $request){

        if (Auth::user()->student_type == 2){

            $request->validate([
                'sname' => 'required|alpha',
                'fname' => 'required|alpha',
                'mname' => 'string|nullable',
                'dob'=> 'required:date_format:Y-M-D|before:2006-05-16',
                'disabled' => 'required',
                'disability' => 'string|nullable',
                'address' => 'required|numeric',
                'postalcode' => 'required|numeric',
                'nationality' => 'required|string',
                'county' => 'required|string',
                'subcounty' => 'required|string',
                'town' => 'required|string',
                'title' => 'required|string',
                'status' => 'required|string',
                'id_number' => 'required|alpha_num|min:7|unique:applicants',
                'email' => 'required',
                'mobile' => 'required|regex:/(0)[0-9]{9}/|min:10|max:10|'
            ]);

            $user = Applicant::where('id', Auth::user()->id)->first();
            $user->sname = trim(strtoupper($request->sname));
            $user->fname = trim(strtoupper($request->fname));
            $user->mname = trim(strtoupper($request->mname));
            $user->gender = trim(strtoupper(Auth::user()->gender));
            $user->index_number = trim(Auth::user()->index_number);
            $user->id_number = trim($request->id_number);
            $user->alt_mobile = trim($request->alt_number);
            $user->mobile = trim($request->mobile);
            $user->email = trim(strtolower($request->email));
            $user->alt_email = trim(strtolower($request->alt_email));
            $user->dob = trim($request->dob);
            $user->disabled = trim($request->disabled);
            $user->disability = trim(strtoupper($request->disability));
            $user->title = trim(strtoupper($request->title));
            $user->nationality = trim(strtoupper($request->nationality));
            $user->county = trim(strtoupper($request->county));
            $user->sub_county = trim(strtoupper($request->subcounty));
            $user->town = trim(strtoupper($request->town));
            $user->address = trim($request->address);
            $user->postal_code = trim($request->postalcode);
            $user->user_status = trim(1);
            $user->title = trim(strtoupper($request->title));
            $user->marital_status = trim($request->status);
            $user->save();

        }else{

            $request->validate([
                'sname' => 'required|alpha',
                'fname' => 'required|alpha',
                'mname' => 'string|nullable',
                'dob'=> 'required:date_format:Y-M-D|before:2006-05-16',
                'gender' => 'required|string',
                'disabled' => 'required',
                'disability' => 'string|nullable',
                'index_number' => 'required|string|unique:applicants',
                'alt_number' => 'required|regex:/(0)[0-9]{9}/|min:10|max:10',
                'address' => 'required|numeric',
                'postalcode' => 'required|numeric',
                'nationality' => 'required|string',
                'county' => 'required|string',
                'subcounty' => 'required|string',
                'town' => 'required|string',
                'title' => 'required|string',
                'status' => 'required|string',
                'id_number' => 'required|alpha_num|min:7|unique:applicants'
            ]);

            $user = Applicant::where('id', Auth::user()->id)->first();
            $user->sname = trim(strtoupper($request->sname));
            $user->fname = trim(strtoupper($request->fname));
            $user->mname = trim(strtoupper($request->mname));
            $user->gender = trim($request->gender);
            $user->index_number = trim($request->index_number);
            $user->id_number = trim($request->id_number);
            $user->alt_mobile = trim($request->alt_number);
            $user->alt_email = trim(strtolower($request->alt_email));
            $user->dob = trim($request->dob);
            $user->disabled = trim($request->disabled);
            $user->disability = trim(strtoupper($request->disability));
            $user->title = trim(strtoupper($request->title));
            $user->nationality = trim(strtoupper($request->nationality));
            $user->county = trim(strtoupper($request->county));
            $user->sub_county = trim(strtoupper($request->subcounty));
            $user->town = trim(strtoupper($request->town));
            $user->address = trim($request->address);
            $user->postal_code = trim($request->postalcode);
            $user->user_status = trim(1);
            $user->title = trim(strtoupper($request->title));
            $user->marital_status = trim($request->status);
            $user->save();

        }

        return redirect()->route('application.applicant')->with('success', 'You have successfully updated your profile');

    }

    public function logout(){
        Session::flush();
        Auth::logout();
        Auth::guard('user')->logout();

        return redirect( route('root'))->with('info', 'You have logged out');
    }

    public function details(){
        $user = Auth::user();

        return view('application::applicant.updatePage')->with('user', $user);
    }

    public function myCourses(){
        $mycourses = Application::where('applicant_id', Auth::user()->id)->get();
        return view('application::applicant.mycourses')->with('courses', $mycourses);
    }

    public function allCourses(){

        $active = Intake::where('status', 1)->get();

        if (count($active) == 0){

            $courses = $active;

            return view('application::applicant.courses', compact('courses'));

        }else{

            foreach ($active as $intake){

                $courses[] = AvailableCourse::where('intake_id', $intake->id)->get();

            }

            return view('application::applicant.courses', compact('courses', 'active'));

        }
    }

    public function applyNow($id){

        $hashedId = Crypt::decrypt($id);

        $education = Education::where('applicant_id', Auth::user()->id)->get();
        $work = WorkExperience::where('applicant_id', Auth::user()->id)->get();
        $course = AvailableCourse::find($hashedId);
        $mycourse = Application::where('applicant_id', Auth::user()->id)->where('course_id', $course->course_id)->where('intake_id', $course->intake_id)->first();
        $parent = Guardian::where('applicant_id', Auth::user()->id)->get();
        $sponsor = Sponsor::where('applicant_id', Auth::user()->id)->get();

        return view('application::applicant.application')
            ->with(['course' => $course, 'education' => $education, 'work' => $work, 'mycourse' => $mycourse, 'sponsor' => $sponsor, 'parent' => $parent]);
    }

    public function applicationEdit($id){

        $hashedId = Crypt::decrypt($id);

        $course = Application::find($hashedId);

        $id = AvailableCourse::where('course_id', $course->course_id)->where('intake_id', $course->intake_id)->pluck('id')->first();

//        return $ids;
            return redirect()->route('application.apply', Crypt::encrypt($id))->with(['success' => 'You can now update your application']);

    }

    public function submitApp(Request $request){

        $request->validate([
            'subject1' => 'required|string',
            'subject2' => 'string|required',
            'subject3' => 'string|required',
            'subject4' => 'string|required',
            'campus' => 'required'
            ]);

//        return $request->all();

        if (Application::where('applicant_id', Auth::user()->id)->where('course_id', $request->course_id)->first()){

            Application::where('applicant_id', Auth::user()->id)->where('course_id', $request->course_id)->update([


                'subject_1' => $request->subject1." ".$request->grade1,
                'subject_2' => $request->subject2." ".$request->grade2,
                'subject_3' => $request->subject3." ".$request->grade3,
                'subject_4' => $request->subject4." ".$request->grade4,
                'campus_id' => $request->campus
            ]);
        }else {

            $application = new Application;
            $application->applicant_id = Auth::user()->id;
            $application->student_type = 1;
            $application->intake_id = $request->intake;
            $application->course_id = $request->course_id;
            $application->department_id = $request->dept;
            $application->school_id = $request->school;
            $application->subject_1 = $request->subject1." ".$request->grade1;
            $application->subject_2 = $request->subject2." ".$request->grade2;
            $application->subject_3 = $request->subject3." ".$request->grade3;
            $application->subject_4 = $request->subject4." ".$request->grade4;
            $application->campus_id = $request->campus;
            $application->save();
        }

        return redirect()->back()->with('success', 'You course application details have been update successfully');

    }

    public function appPayment(Request $request){
            $request->validate([
            'receipt' => 'string|required|unique:applications',
            'receipt_file' => 'required|mimes:pdf|required|max:2048'
                ]);

        if ($request->hasFile('receipt_file')){
            $file = $request->receipt_file;
            $fileName = 'receipt'.time().'.'.$file->getClientOriginalExtension();
            $request->receipt_file->move('receipts', $fileName);
        }

            Application::where('applicant_id', Auth::user()->id)
                ->where('course_id', $request->course_id)->update(['receipt' => $request->receipt, 'receipt_file' => $fileName ]);

        return redirect()->back()->with('success', 'You course payment details have been update successfully');
    }

    public function addParent(Request $request){

        $request->validate([
                'parentname' => 'string|required',
                'parentmobile' => 'string|required|regex:/(0)[0-9]{9}/|min:10|max:10',
                'parentcounty' => 'string|required',
                'parenttown' => 'string|required',
                'sponsorname' => 'string|required',
                'sponsormobile' => 'string|required|regex:/(0)[0-9]{9}/|min:10|max:10',
                'sponsorcounty' => 'string|required',
                'sponsortown' => 'string|required',
            ]);

                $parent = new Guardian;
                $parent->applicant_id = Auth::user()->id;
                $parent->guardian_name = $request->parentname;
                $parent->guardian_mobile = $request->parentmobile;
                $parent->guardian_county = $request->parentcounty;
                $parent->guardian_town = $request->parenttown;
                $parent->save();

                $sponsor = new Sponsor;
                $sponsor->applicant_id = Auth::user()->id;
                $sponsor->sponsor_name = $request->sponsorname;
                $sponsor->sponsor_mobile = $request->sponsormobile;
                $sponsor->sponsor_county = $request->sponsorcounty;
                $sponsor->sponsor_town = $request->sponsortown;
                $sponsor->save();

        return redirect()->back()->with('success', 'You course application details have been update successfully');
    }

    public function addWork(Request $request){

        $request->validate([
            'org1' => 'string|required',
            'org1post' => 'string|required',
            'org1startdate' => 'string|required',
            'org1enddate' => 'string|required',
        ]);

        $work = new WorkExperience;
        $work->applicant_id = Auth::user()->id;
        $work->organization = $request->org1;
        $work->post = $request->org1post;
        $work->start_date = $request->org1startdate;
        $work->exit_date = $request->org1enddate;
        $work->save();

        return redirect()->back()->with('success', 'You work experience details have been update successfully');
    }

    public function secSch(Request $request){
            $request->validate([
                'secondaryqualification' => 'string|required',
                'secstartdate' => 'string|required',
                'secenddate' => 'string|required',
                'seccert' => 'required|mimes:pdf|required|max:2048',
            ]);

            $education = new Education;
            $education->applicant_id = Auth::user()->id;
            $education->institution = $request->secondary;
            $education->qualification = $request->secondaryqualification;
            $education->start_date = $request->secstartdate;
            $education->exit_date = $request->secenddate;
            $education->level = $request->level;

            if ($request->hasFile('seccert')){
                $file = $request->seccert;
                $fileName = 'seccert'.time().'.'.$file->getClientOriginalExtension();
                $request->seccert->move('certs', $fileName);
                $education->certificate = $fileName;
            }

            $education->save();

        return redirect()->back()->with('success', 'You work experience details have been update successfully');
    }

    public function terSch(Request $request){
            $request->validate([
                'tertiary' => 'string|required',
                'teriaryqualification' => 'string|required',
                'terstartdate' => 'string|required',
                'level' => 'string|required',
                'terenddate' => 'string|required',
                'tercert' => 'required|mimes:pdf|required|max:2048',
            ]);

//            return $request->all();

            $education = new Education;
            $education->applicant_id = Auth::user()->id;
            $education->institution = $request->tertiary;
            $education->qualification = $request->teriaryqualification;
            $education->start_date = $request->terstartdate;
            $education->exit_date = $request->terenddate;
            $education->level = $request->level;

            if ($request->hasFile('tercert')){
                $file = $request->tercert;
                $fileName = 'tercert'.time().'.'.$file->getClientOriginalExtension();
                $request->tercert->move('certs', $fileName);
                $education->certificate = $fileName;
            }
            $education->save();

        return redirect()->back()->with('success', 'You education history added successfully');

    }

    public function finish(Request $request){
        $request->validate([
            'declare' => 'required'
        ]);

        Application::where('applicant_id', Auth::user()->id)->where('id', $request->course_id)->update(['declaration' => 1, 'finance_status' => 0, 'status' => 0]);

        return redirect()->back()->with('success', 'Your application was submitted successfully');

    }

    public function viewCourse($id){

        $hashedId = Crypt::decrypt($id);

        $course = AvailableCourse::find($hashedId);

        return view('application::applicant.viewcourse')->with('course', $course);
    }

    public function applicationProgress($id){

        $hashedId = Crypt::decrypt($id);

        $course = Application::find($hashedId);

        $finance = FinanceLog::where('application_id', $hashedId)->orderBy('created_at', 'desc')->get();
        $cod = CODLog::where('application_id', $hashedId)->orderBy('created_at', 'desc')->get();
        $dean = DeanLog::where('application_id', $hashedId)->orderBy('created_at', 'desc')->get();

        $logs = $cod->concat($finance)->concat($dean)->sortByDesc('created_at');

        return view('application::applicant.progress')->with(['logs' => $logs, 'course' => $course]);
    }
    public function myProfile(){
        $apps = Application::where('applicant_id', Auth::user()->id)->get();
        return view('application::applicant.profilepage')->with('apps', $apps);
    }

    public function downloadLetter($id){

        $hashedId = Crypt::decrypt($id);

        $letter = Application::find($hashedId);

        return response()->download(storage_path($letter->adm_letter));
    }

    public function uploadDocuments($id){

        $hashedId = Crypt::decrypt($id);

        $admission = Application::find($hashedId);

        return view('application::applicant.admission')->with(['admission' => $admission]);
    }

    public function academicDoc(Request $request){

        $request->validate([
            'academicDoc' => 'required|mimes:pdf',
            'academicDocId' => 'required',
        ]);

        if (AdmissionDocument::where('application_id', $request->academicDocId)->exists()){

            $name = AdmissionDocument::where('application_id', $request->academicDocId)->first()->admDocuments->reg_number;

            if ($request->hasFile('academicDoc')){
                $file = $request->academicDoc;
                $fileName = str_replace('/', '', $name).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->academicDoc->move('Admissions/Certificates', $fileName);

                AdmissionDocument::where('application_id', $request->academicDocId)->update(['certificates' => $fileName]);

            }

        }else{

            $id = $request->academicDocId;

            $name = Application::find($id);

            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->academicDocId;
            if ($request->hasFile('academicDoc')){
                $file = $request->academicDoc;
                $fileName = str_replace('/', '', $name->reg_number).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->academicDoc->move('Admissions/Certificates', $fileName);
                $academicCerts->certificates = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Academic documents uploaded successfully');

    }

    public function bankReceipt(Request $request){

        $request->validate([
            'bankReceipt' => 'required|mimes:pdf|max:40000',
            'bankReceiptId' => 'required',
        ]);

        if (AdmissionDocument::where('application_id', $request->bankReceiptId)->exists()){

            $name = AdmissionDocument::where('application_id', $request->bankReceiptId)->first()->admDocuments->reg_number;

            if ($request->hasFile('bankReceipt')){
                $file = $request->bankReceipt;
                $fileName = str_replace('/', '', $name).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->bankReceipt->move('Admissions/BankReceipt', $fileName);

                AdmissionDocument::where('application_id', $request->bankReceiptId)->update(['bank_receipt' => $fileName]);

            }

        }else{

            $id = $request->bankReceiptId;

            $hashedId = Crypt::decrypt($id);

            $name = Application::find($hashedId);

            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->bankReceiptId;
            if ($request->hasFile('bankReceipt')){
                $file = $request->bankReceipt;
                $fileName = str_replace('/', '', $name->reg_number).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->bankReceipt->move('Admissions/BankReceipt', $fileName);
                $academicCerts->bank_receipt = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Bank receipt uploaded successfully');

    }

    public function medicalForm(Request $request){

        $request->validate([
            'medicalForm' => 'required|mimes:pdf|max:40000',
            'medicalFormId' => 'required',
        ]);

        if (AdmissionDocument::where('application_id', $request->medicalFormId)->exists()){

            $name = AdmissionDocument::where('application_id', $request->medicalFormId)->first()->admDocuments->reg_number;

            if ($request->hasFile('medicalForm')){
                $file = $request->medicalForm;
                $fileName = str_replace('/', '', $name).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->medicalForm->move('Admissions/MedicalForms', $fileName);

                AdmissionDocument::where('application_id', $request->medicalFormId)->update(['medical_form' => $fileName]);

            }

        }else{

            $id = $request->medicalFormId;

            $hashedId = Crypt::decrypt($id);

            $name = Application::find($hashedId);

            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->medicalFormId;
            if ($request->hasFile('medicalForm')){
                $file = $request->medicalForm;
                $fileName = str_replace('/', '', $name->reg_number).'-'.time().'.'.$file->getClientOriginalExtension();
                $request->medicalForm->move('Admissions/MedicalForms', $fileName);
                $academicCerts->medical_form = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Bank receipt uploaded successfully');

    }

    public function passportPhoto(Request $request){

        $request->validate([
            'passPort' => 'required|image|mimes:jpeg,png,jpg|max:40000',
            'passPortId' => 'required',
        ]);


        if (AdmissionDocument::where('application_id', $request->passPortId)->exists()){

            $name = AdmissionDocument::where('application_id', $request->passPortId)->first()->admDocuments->reg_number;

            if ($request->hasFile('passPort')){
                $file = $request->passPort;
                $fileName = str_replace('/', '', $name).'-'.time().'.'.$file->getClientOriginalExtension();

                $thumbnailFolder = storage_path('/thumbnails');

                $passport = Image::make($file->path());

                $passport->resize(100, 100, function ($contraint){
                    $contraint->aspectRatio();
                })->save($thumbnailFolder.'/'.$fileName);

                $file->move('Admissions/PassPorts', $fileName);

                AdmissionDocument::where('application_id', $request->passPortId)->update(['passport_photo' => $fileName]);

            }

        }else{

            $id = $request->passPortId;

            $hashedId = Crypt::decrypt($id);

            $name = Application::find($hashedId);

            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->passPortId;
            if ($request->hasFile('passPort')){
                $file = $request->passPort;
                $fileName = str_replace('/', '', $name->reg_number).'-'.time().'.'.$file->getClientOriginalExtension();
                $thumbnailFolder = storage_path('/thumbnails');

                $passport = Image::make($file->path());

                $passport->resize(100, 100, function ($contraint){
                    $contraint->aspectRatio();
                })->save($thumbnailFolder.'/'.$fileName);

                $file->move('Admissions/PassPorts', $fileName);

                $academicCerts->passport_photo = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Passport Photo uploaded successfully');

    }

    public function submitDocuments($id){

        $hashedId = Crypt::decrypt($id);

        AdmissionDocument::where('application_id', $hashedId)->update(['status' => 1]);
        AdmissionApproval::create(['application_id' => $hashedId, 'cod_status' => 0]);

        return redirect()->back()->with('success', 'Your documents submitted for admission process');
    }

    public function inbox(){

        $apps  = Application::where('applicant_id', Auth::user()->id)->get();

        if (count($apps) == 0){

            $notification = [];

        }else{

            foreach ($apps as $app_id){

                $notification = Notification::where('application_id', $app_id->id)->where('status', '>', 0)->latest()->get();

            }
        }

        return view('application::applicant.inbox')->with(['notification' => $notification]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('application::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('application::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('application::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

}
