<?php

namespace Modules\Application\Http\Controllers;
use App\Http\Apis\AppApis;
use App\Notifications\Sms;
use App\Service\CustomIds;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Image;
use Modules\Application\Emails\VerifyEmails;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\AdmissionDocument;
use Modules\Application\Entities\Applicant;
use Illuminate\Support\Facades\Hash;
use Modules\Application\Entities\ApplicantAddress;
use Modules\Application\Entities\ApplicantContact;
use Modules\Application\Entities\ApplicantDisability;
use Modules\Application\Entities\ApplicantInfo;
use Modules\Application\Entities\ApplicantLogin;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\ApplicationApproval;
use Modules\Application\Entities\ApplicationSubject;
use Modules\Application\Entities\Education;
use Modules\Application\Entities\Guardian;
use Modules\Application\Entities\Notification;
use Modules\Application\Entities\Sponsor;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\WorkExperience;
use Modules\COD\Entities\ApplicationsView;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\CourseOnOfferView;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Intake;
//use Session;
use Illuminate\Support\Facades\Mail;
use Modules\COD\Entities\CODLog;
use Modules\Dean\Entities\DeanLog;
use Modules\Finance\Entities\FinanceLog;
use Modules\Registrar\Entities\SemesterFee;

class ApplicationController extends Controller
{
    protected $appApi;
    public function __construct(AppApis $appApi){
        $this->appApi = $appApi;
    }
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
        return response()->json(['captcha' => captcha_img()]);
    }

    public function signup(Request $request){

        $request->validate([
            'email' => 'required|email|unique:applicant_contacts',
            'mobile' => 'required|unique:applicant_contacts',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        $id = new CustomIds();

        $applicantContact = new ApplicantContact;
        $applicantContact->applicant_id = $id->generateId();
        $applicantContact->mobile = str_replace(' ', '', '+254' . ($request->mobile));
        $applicantContact->email = $request->email;
        $applicantContact->save();

        $app = new ApplicantLogin;
        $app->username = $request->email;
        $app->applicant_id = $applicantContact->applicant_id;
        $app->password = Hash::make($request->password);
        $app->student_type = 1;
        $app->save();

        VerifyEmail::create([
            'applicant_id' => $app->applicant_id,
            'verification_code' => Str::random(100),
        ]);

        Mail::to($applicantContact->email)->send(new VerifyEmails($app));

        return redirect(route('root'))->with(['info' => 'Account verification email was sent to verify your account']);
    }

    public function phoneverify(){
        return view('application::auth.phoneverification');
    }

    public function phonereverification(Request $request){
        $request->validate([
            'verification_code' => 'required',
            'phone_number' => 'required'
        ]);

        $unverified = VerifyUser::where('verification_code', $request->verification_code)->first();

        if (!$unverified) {
            return redirect()->back()->with('error', 'Wrong code! Please request for a new code');
        }

        $applicant = $unverified->userVerification;

        if (!$applicant->phone_verification) {
            $applicant->phone_verification = 1;
            $applicant->save();

            VerifyUser::where('verification_code', $request->verification_code)->delete();

            return redirect()->route('application.applicant')->with('success', 'Phone number verified successfully');
        } else {
            abort(403);
        }

        return redirect()->back()->with('error', 'Phone number failed verification');
    }

    public function getNewCode(){

        VerifyUser::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->delete();

        $verification_code = rand(1, 999999);

        VerifyUser::create([
            'applicant_id' => \auth()->guard('web')->user()->applicant_id,
            'verification_code' => $verification_code,
        ]);
        $phoneNumber =  auth()->guard('web')->user()->applicantContact->mobile;
        $message = 'Welcome to TUM online course application platform. Your verification code '. $verification_code. '. Please do not share this code with anyone.';
        $this->appApi->sendSMS($phoneNumber, $message);
        return redirect()->back()->with(['info' => 'Enter the code send to your phone', 'code' => $verification_code]);
    }

    public function emailVerification($verification_code){
        $unverified = VerifyEmail::where('verification_code', $verification_code)->first();
        if (isset($unverified)) {

            $applicant = $unverified->emailVerify;

            if (!$applicant->email_verified_at) {
                $applicant->email_verified_at = Carbon::now();
                $applicant->save();

                VerifyEmail::where('verification_code', $verification_code)->delete();

                return redirect(route('root'))->with('success', 'Your email has been verified');
            } else {

                return redirect(route('root'))->with('warning', 'The code does not exist');
            }
        } else {
            return redirect(route('root'))->with('info', 'Email already verified');
        }
    }

    public function checkverification(){
        return view('application::auth.landing');
    }

    public function dashboard(){

        $courses = [];
         $intake = Intake::where('status', 1)->first();
        if ($intake != null) {
            $courses = CourseOnOfferView::where('intake_id', $intake->intake_id)
                ->latest()->get();
        }

        $apps  = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();

        if (count($apps) == 0) {

            $notification = [];
        } else {

//            foreach ($apps as $id) {
            $notification = [];
//                $notification = Notification::where('application_id', $id->id)->where('status', '>', 0)->orderBy('updated_at', 'desc')->get();
//            }
        }

        $mycourses = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->count();

        if (auth()->guard('web')->check()) {
            if (\auth()->guard('web')->user()->email_verified_at == null) {
                \auth()->guard('web')->logout();
                return redirect(route('root'))->with('warning', 'Please verify your email first');
            }
            if (\auth()->guard('web')->user()->user_status == 0) {
                return redirect()->route('application.details')->with(['info' => 'Please update your profile']);
            } else {
                return view('application::applicant.home')->with(['courses' => $courses, 'mycourses' => $mycourses, 'notification' => $notification]);
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

    public function updatePersonalInfo(Request $request){
        if (ApplicantInfo::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->exists()) {
            $request->validate([
                'sname' => 'required|alpha',
                'fname' => 'required|alpha',
                'mname' => 'string|nullable',
                'dob' => 'required:date_format:Y-M-D|before:2006-05-16',
                'disabled' => 'required',
                'idType' => 'required',
                'disability' => 'string|nullable',
                'title' => 'required|string',
                'status' => 'required|string',
                'identification' => 'required|alpha_num|min:7',
                'index_number' => 'required|string',
                'gender' => 'required|string',
            ]);
        } else {

            $request->validate([
                'sname' => 'required|alpha',
                'fname' => 'required|alpha',
                'mname' => 'string|nullable',
                'dob' => 'required:date_format:Y-M-D',
                'disabled' => 'required',
                'idType' => 'required',
                'disability' => 'string|nullable',
                'title' => 'required|string',
                'status' => 'required|string',
                'identification' => 'required|alpha_num|min:7|unique:applicant_infos',
                'index_number' => 'required|string',
                'gender' => 'required|string',
            ]);
        }

        if (ApplicantInfo::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->exists()) {
            $user = ApplicantInfo::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->first();
            $user->surname = trim(strtoupper($request->sname));
            $user->first_name = trim(strtoupper($request->fname));
            $user->middle_name = trim(strtoupper($request->mname));
            $user->gender = trim(strtoupper($request->gender));
            $user->index_number = trim($request->index_number);
            $user->identification = trim($request->identification);
            $user->type = trim($request->idType);
            $user->date_of_birth = trim($request->dob);
            $user->disabled = trim(strtoupper($request->disabled));
            $user->title = trim(strtoupper($request->title));
            $user->marital_status = trim(strtoupper($request->status));
            $user->save();

            if ($request->disabled == 'YES'){
                $userDis = new ApplicantDisability;
                $userDis->applicant_id = \auth()->guard('web')->user()->applicant_id;
                $userDis->disability =  trim(strtoupper($request->disability));
                $userDis->save();
            }
        } else {
            $applicant = new ApplicantInfo;
            $applicant->applicant_id = \auth()->guard('web')->user()->applicant_id;
            $applicant->surname = trim(strtoupper($request->sname));
            $applicant->first_name = trim(strtoupper($request->fname));
            $applicant->middle_name = trim(strtoupper($request->mname));
            $applicant->gender = trim(strtoupper($request->gender));
            $applicant->index_number = trim($request->index_number);
            $applicant->identification = trim($request->identification);
            $applicant->type = trim($request->idType);
            $applicant->date_of_birth = trim($request->dob);
            $applicant->disabled = trim(strtoupper($request->disabled));
            $applicant->title = trim(strtoupper($request->title));
            $applicant->marital_status = trim(strtoupper($request->status));
            $applicant->save();

            if ($request->disabled == 'YES'){
                $userDis = new ApplicantDisability;
                $userDis->applicant_id = \auth()->guard('web')->user()->applicant_id;
                $userDis->disability =  trim(strtoupper($request->disability));
                $userDis->save();
            }
        }

        return redirect()->back()->with('success', 'Personal information updated successfully');
    }

    public function updateContactInfo(Request $request){
        $request->validate([
            'email' => 'required',
            'mobile' => 'required|min:10|max:13|',
            'alt_email' => 'required',
            'alt_number' => 'required|min:10|max:13|'
        ]);

        ApplicantContact::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->update([
            'email' => $request->email,
            'alt_email' => $request->alt_email,
            'mobile' => $request->mobile,
            'alt_mobile' => $request->alt_number,
        ]);

        return redirect()->back()->with('success', 'Contact information updated successfully');
    }

    public function updateAddressInfo(Request $request) {

        $request->validate([
            'address' => 'required|numeric',
            'postalcode' => 'required|numeric',
            'nationality' => 'required|string',
            'county' => 'required|string',
            'subcounty' => 'required|string',
            'town' => 'required|string',
        ]);

        if (ApplicantAddress::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->exists()) {

            $applicantAddress = ApplicantAddress::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->first();
            $applicantAddress->applicant_id = \auth()->guard('web')->user()->applicant_id;
            $applicantAddress->address = trim($request->address);
            $applicantAddress->postal_code = trim($request->postalcode);
            $applicantAddress->nationality = trim(strtoupper($request->nationality));
            $applicantAddress->county = trim(strtoupper($request->county));
            $applicantAddress->sub_county = trim(strtoupper($request->subcounty));
            $applicantAddress->town = trim(strtoupper($request->town));
            $applicantAddress->save();
        } else {
            $applicantAddress = new ApplicantAddress;
            $applicantAddress->applicant_id = \auth()->guard('web')->user()->applicant_id;
            $applicantAddress->address = trim($request->address);
            $applicantAddress->postal_code = trim($request->postalcode);
            $applicantAddress->nationality = trim(strtoupper($request->nationality));
            $applicantAddress->county = trim(strtoupper($request->county));
            $applicantAddress->sub_county = trim(strtoupper($request->subcounty));
            $applicantAddress->town = trim(strtoupper($request->town));
            $applicantAddress->save();
        }

        return redirect()->back()->with('success', 'Home address information updated successfully');
    }

    public function logout(){
        Session::flush();
        Auth::guard('web')->logout();
        return redirect(route('root'))->with('info', 'You have logged out');
    }

    public function details(){

        $userId = \auth()->guard('web')->user()->applicant_id;
        $userinfo = ApplicantInfo::where('applicant_id', $userId)->first();
        $userContact = ApplicantContact::where('applicant_id', $userId)->first();
        $userAddress = ApplicantAddress::where('applicant_id', $userId)->first();
        $updatedContact = true;
        $updatedAddress = true;
        $updatedInfo = true;


        if ($userinfo == null || $userAddress == null || $userContact->alt_email == null || $userContact->alt_mobile == null) {
            $updateUser = ApplicantLogin::where('applicant_id', $userId)->first();
            $updateUser->user_status = 0;
            $updateUser->save();

            return view('application::applicant.updatePage');
        } else {

            $userInfoKeys = ['id', 'applicant_id', 'mname', 'disability', 'created_at', 'updated_at', 'deleted_at'];

            $userDataArray = is_array($userinfo) ? $userinfo : $userinfo->toArray();

            $keys = array_keys($userDataArray);
            $keysToCheck = array_diff($keys, $userInfoKeys);

            foreach ($keysToCheck as $key) {
                if (is_null($userDataArray[$key])) {
                    $updatedInfo = null;
                }
            }

            $userAddressKeys = ['id', 'applicant_id', 'created_at', 'updated_at', 'deleted_at'];

            $addressdataArray = is_array($userAddress) ? $userAddress : $userAddress->toArray();

            $keys = array_keys($addressdataArray);
            $keysToCheck = array_diff($keys, $userAddressKeys);

            foreach ($keysToCheck as $key) {
                if (is_null($addressdataArray[$key])) {
                    $updatedAddress = null;
                }
            }

            $userContactKeys = ['id', 'applicant_id', 'created_at', 'updated_at', 'deleted_at'];

            $contactDataArray = is_array($userContact) ? $userContact : $userContact->toArray();

            $keys = array_keys($contactDataArray);
            $keysToCheck = array_diff($keys, $userContactKeys);

            foreach ($keysToCheck as $key) {
                if (empty($contactDataArray[$key])) {
                    $updatedContact = null;
                }
            }

            if ($updatedInfo == null || $updatedAddress == null || $updatedContact == null) {
                $updateUser = ApplicantLogin::where('applicant_id', $userId)->first();
                $updateUser->user_status = 0;
                $updateUser->save();

                return view('application::applicant.updatePage');
            }

            $updateUser = ApplicantLogin::where('applicant_id', $userId)->first();
            $updateUser->user_status = 1;
            $updateUser->save();

            return redirect()->route('application.applicant')->with('success', 'Congrats! You can now use TUM Online Course Application Portal');
        }
    }

    public function myCourses(){
        $mycourses = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)
            ->latest()
            ->get();
        return view('application::applicant.mycourses')->with('courses', $mycourses);
    }

    public function allCourses(){
        $courses = [];
        $intake = Intake::where('status', 1)->first();
        if ($intake != null) {
            $courses = CourseOnOfferView::where('intake_id', $intake->intake_id)
                ->latest()->get();
        }
        return view('application::applicant.courses')->with(['courses' => $courses]);
    }

    public function applyNow($id){
        $subject = [];
        $education = Education::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        $work = WorkExperience::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        $course = CourseOnOfferView::where('available_id', $id)->first();
        $mycourse = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->where('course_id', $course->course_id)->where('intake_id', $course->intake_id)->where('campus_id', $course->campus_id)->first();
        $parent = Guardian::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        $sponsor = Sponsor::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        if ($mycourse != null) {
            $subject = ApplicationSubject::where('application_id', $mycourse->application_id)->first();
        }
        return view('application::applicant.application')
            ->with(['course' => $course, 'education' => $education, 'work' => $work, 'mycourse' => $mycourse, 'sponsor' => $sponsor, 'parent' => $parent, 'subject' => $subject]);
    }

    public function applicationEdit($id){
        $course = Application::where('application_id', $id)->first();
        $id = CourseOnOfferView::where('course_id', $course->course_id)
            ->where('intake_id', $course->intake_id)
            ->where('campus_id', $course->campus_id)
            ->pluck('available_id')
            ->first();

        return redirect()->route('application.apply', $id)->with(['success' => 'You can now update your application']);
    }

    public function submitApp(Request $request){
        $request->validate([
            'subject1' => 'required|string',
            'subject2' => 'string|required',
            'subject3' => 'string|required',
            'subject4' => 'string|required',
            'campus' => 'required'
        ]);

        $courseFee = Courses::where('course_id', $request->course_id)->first();
            if ($courseFee->level_id == 1 || $courseFee->level_id == 2){
                $fee = '500';
            }elseif ($courseFee->level_id == 3){
                $fee = '1000';
            }else{
                $fee = '1500';
            }
//            return $fee;
        $apps = Application::all()->count();
        $intakeApps = Application::where('intake_id', $request->intake)->get()->count();
        $customId = new CustomIds();
        $appId = $customId->generateId();
        $reference = 'APP/'.str_pad($apps, 9, '0', STR_PAD_LEFT).'/'.date('Y');
        $applicationNumber = date('y').str_pad($intakeApps, 5, '0', STR_PAD_LEFT);

        if (Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->where('course_id', $request->course_id)->first()) {
            $subject = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->where('course_id', $request->course_id)->first()->application_id;
            ApplicationSubject::where('application_id', $subject)->update([
                'subject_1' => $request->subject1 . " " . $request->grade1,
                'subject_2' => $request->subject2 . " " . $request->grade2,
                'subject_3' => $request->subject3 . " " . $request->grade3,
                'subject_4' => $request->subject4 . " " . $request->grade4,
            ]);
        } else {

            $application = new Application;
            $application->application_id = $appId;
            $application->applicant_id = \auth()->guard('web')->user()->applicant_id;
            $application->application_number = $applicationNumber;
            $application->ref_number = $reference;
            $application->student_type = 1;
            $application->intake_id = $request->intake;
            $application->course_id = $request->course_id;
            $application->campus_id = $request->campus;
            $application->application_fee = $fee;
            $application->save();

            $subject = new ApplicationSubject;
            $subject->application_id = $appId;
            $subject->subject_1 = $request->subject1 . " " . $request->grade1;
            $subject->subject_2 = $request->subject2 . " " . $request->grade2;
            $subject->subject_3 = $request->subject3 . " " . $request->grade3;
            $subject->subject_4 = $request->subject4 . " " . $request->grade4;
            $subject->save();
        }

        return redirect()->back()->with('success', 'You course application details have been update successfully');
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
        $parent->applicant_id = \auth()->guard('web')->user()->applicant_id;
        $parent->guardian_name = $request->parentname;
        $parent->guardian_mobile = $request->parentmobile;
        $parent->guardian_county = $request->parentcounty;
        $parent->guardian_town = $request->parenttown;
        $parent->save();

        $sponsor = new Sponsor;
        $sponsor->applicant_id = \auth()->guard('web')->user()->applicant_id;
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
        $work->applicant_id = \auth()->guard('web')->user()->applicant_id;
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
        $education->applicant_id = \auth()->guard('web')->user()->applicant_id;
        $education->institution = $request->secondary;
        $education->qualification = $request->secondaryqualification;
        $education->start_date = $request->secstartdate;
        $education->exit_date = $request->secenddate;
        $education->level = $request->level;

        if ($request->hasFile('seccert')) {
            $file = $request->seccert;
            $fileName = 'seccert' . time() . '.' . $file->getClientOriginalExtension();
            $request->seccert->move('certs', $fileName);
            $education->certificate = $fileName;
        }

        $education->save();

        return redirect()->back()->with('success', 'You education history has been updated successfully');
    }

    public function updateSecSch(Request $request, $id){

        $request->validate([
            'secondaryqualification' => 'string|required',
            'secstartdate' => 'string|required',
            'secenddate' => 'string|required',
            'seccert' => 'mimes:pdf|max:2048',
        ]);
        $hashedID = Crypt::decrypt($id);

        $education =  Education::find($hashedID);
        $education->applicant_id = \auth()->guard('web')->user()->applicant_id;
        $education->institution = $request->secondary;
        $education->qualification = $request->secondaryqualification;
        $education->start_date = $request->secstartdate;
        $education->exit_date = $request->secenddate;
        $education->level = $request->level;

        if ($request->hasFile('seccert')) {
            $file = $request->seccert;
            $fileName = 'seccert' . time() . '.' . $file->getClientOriginalExtension();
            $request->seccert->move('certs', $fileName);
            $education->certificate = $fileName;
        }

        $education->save();
        return redirect()->back()->with('success', 'You education history has been updated successfully');
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

        $education = new Education;
        $education->applicant_id = \auth()->guard('web')->user()->applicant_id;
        $education->institution = $request->tertiary;
        $education->qualification = $request->teriaryqualification;
        $education->start_date = $request->terstartdate;
        $education->exit_date = $request->terenddate;
        $education->level = $request->level;

        if ($request->hasFile('tercert')) {
            $file = $request->tercert;
            $fileName = 'tercert' . time() . '.' . $file->getClientOriginalExtension();
            $request->tercert->move('certs', $fileName);
            $education->certificate = $fileName;
        }
        $education->save();

        return redirect()->back()->with('success', 'You education history added successfully');
    }

    public function updateTerSch(Request $request, $id){
        $request->validate([
            'tertiary' => 'string|required',
            'teriaryqualification' => 'string|required',
            'terstartdate' => 'string|required',
            'level' => 'string|required',
            'terenddate' => 'string|required',
            'tercert' => 'mimes:pdf|max:2048',
        ]);

        $hashedID = Crypt::decrypt($id);

        $education = Education::find($hashedID);
        $education->applicant_id = \auth()->guard('web')->user()->applicant_id;
        $education->institution = $request->tertiary;
        $education->qualification = $request->teriaryqualification;
        $education->start_date = $request->terstartdate;
        $education->exit_date = $request->terenddate;
        $education->level = $request->level;

        if ($request->hasFile('tercert')) {
            $file = $request->tercert;
            $fileName = 'tercert' . time() . '.' . $file->getClientOriginalExtension();
            $request->tercert->move('certs', $fileName);
            $education->certificate = $fileName;
        }
        $education->save();

        return redirect()->back()->with('success', 'Your education history has been updated successfully');
    }

    public function finish(Request $request){
        $request->validate([
            'declare' => 'required'
        ]);

        $myApplication = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->where('course_id', $request->course_id)->where('intake_id', $request->intake_id)->first();
        $myApplication->declaration = 1;
        $myApplication->save();

        $approval = ApplicationApproval::where('application_id', $myApplication->application_id)->first();
        if ($approval == null) {
            ApplicationApproval::create(['application_id' => $myApplication->application_id]);
        }
        return redirect()->back()->with('success', 'Your application was submitted successfully');
    }

    public function viewCourse($id){
        $course = CourseOnOfferView::where('available_id', $id)->first();
        return view('application::applicant.viewcourse')->with('course', $course);
    }

    public function myProfile(){
        $apps = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        return view('application::applicant.profilepage')->with('apps', $apps);
    }

    public function downloadLetter($id){
        $application = ApplicationApproval::where('application_id', $id)->first();
        if ($application == null){
            $application = Application::where('application_id', $id)->first();
            $letter = str_replace('/', '', $application->ref_number).'.pdf';
        }else{
            $letter = $application->admission_letter;
        }
        return response()->download('AdmissionLetters/AdmissionLetters/' . $letter);
    }

    public function uploadDocuments($id){
        $admission = Application::where('application_id', $id)->first();
        return view('application::applicant.admission')->with(['admission' => $admission]);
    }

    public function academicDoc(Request $request){
        $request->validate([
            'academicDoc' => 'required|mimes:pdf|max:1000',
            'academicDocId' => 'required',
        ]);
        if (AdmissionDocument::where('application_id', $request->academicDocId)->exists()) {
            $name = ApplicationsView::where('application_id', $request->academicDocId)->first();
            if ($request->hasFile('academicDoc')) {
                $file = $request->academicDoc;
                $fileName = str_replace('/','', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->academicDoc->move('Admissions/Certificates', $fileName);

                AdmissionDocument::where('application_id', $request->academicDocId)->update(['certificates' => $fileName]);
            }
        } else {
            $name = ApplicationsView::where('application_id', $request->academicDocId)->first();
            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->academicDocId;
            if ($request->hasFile('academicDoc')) {
                $file = $request->academicDoc;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->academicDoc->move('Admissions/Certificates', $fileName);
                $academicCerts->certificates = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Academic documents uploaded successfully');
    }

    public function bankReceipt(Request $request){
        $request->validate([
            'bankReceipt' => 'required|mimes:pdf|max:1000',
            'bankReceiptId' => 'required',
        ]);
        if (AdmissionDocument::where('application_id', $request->bankReceiptId)->exists()) {
            $name = ApplicationsView::where('application_id', $request->bankReceiptId)->first();
            if ($request->hasFile('bankReceipt')) {
                $file = $request->bankReceipt;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->bankReceipt->move('Admissions/BankReceipt', $fileName);
                AdmissionDocument::where('application_id', $request->bankReceiptId)->update(['bank_receipt' => $fileName]);
            }
        } else {
            $name = ApplicationsView::where('application_id', $request->bankReceiptId)->first();
            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->bankReceiptId;
            if ($request->hasFile('bankReceipt')) {
                $file = $request->bankReceipt;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->bankReceipt->move('Admissions/BankReceipt', $fileName);
                $academicCerts->bank_receipt = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Bank receipt uploaded successfully');
    }

    public function medicalForm(Request $request){
        $request->validate([
            'medicalForm' => 'required|mimes:pdf|max:1000',
            'medicalFormId' => 'required',
        ]);
        if (AdmissionDocument::where('application_id', $request->medicalFormId)->exists()) {
            $name = ApplicationsView::where('application_id', $request->medicalFormId)->first();
            if ($request->hasFile('medicalForm')) {
                $file = $request->medicalForm;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->medicalForm->move('Admissions/MedicalForms', $fileName);
                AdmissionDocument::where('application_id', $request->medicalFormId)->update(['medical_form' => $fileName]);
            }
        } else {
            $name = ApplicationsView::where('application_id', $request->medicalFormId)->first();
            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->medicalFormId;
            if ($request->hasFile('medicalForm')) {
                $file = $request->medicalForm;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $request->medicalForm->move('Admissions/MedicalForms', $fileName);
                $academicCerts->medical_form = $fileName;
            }
            $academicCerts->save();
        }
        return redirect()->back()->with('success', 'Bank receipt uploaded successfully');
    }

    public function passportPhoto(Request $request){
        $request->validate([
            'passPort' => 'required|image|mimes:jpeg,png,jpg|max:2000',
            'passPortId' => 'required',
        ]);

        if (AdmissionDocument::where('application_id', $request->passPortId)->exists()) {
            $name = ApplicationsView::where('application_id', $request->passPortId)->first();
            if ($request->hasFile('passPort')) {
                $file = $request->passPort;
                $fileName = str_replace('/','', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $thumbnailFolder = 'Thumbnails';
                $passport = Image::make($file->path());
                $passport->resize(100, 100, function ($contraint) {
                    $contraint->aspectRatio();
                })->save($thumbnailFolder . '/' . $fileName);
                $file->move('Admissions/PassPorts', $fileName);
                AdmissionDocument::where('application_id', $request->passPortId)->update(['passport_photo' => $fileName]);
            }
        } else {
            $name = Application::where('application_id', $request->passPortId)->first();
            $academicCerts = new AdmissionDocument;
            $academicCerts->application_id = $request->passPortId;
            if ($request->hasFile('passPort')) {
                $file = $request->passPort;
                $fileName = str_replace('/', '', $name->student_number) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $thumbnailFolder = 'Thumbnails';
                $passport = Image::make($file->path());
                $passport->resize(100, 100, function ($contraint) {
                    $contraint->aspectRatio();
                })->save($thumbnailFolder . '/' . $fileName);

                $file->move('Admissions/PassPorts', $fileName);

                $academicCerts->passport_photo = $fileName;
            }
            $academicCerts->save();
        }

        return redirect()->back()->with('success', 'Passport Photo uploaded successfully');
    }

    public function submitDocuments($id){
        AdmissionApproval::create(['application_id' => $id, 'cod_status' => 0]);
        AdmissionDocument::where('application_id', $id)->update(['status' => 1]);
        $admission = ApplicationsView::where('application_id', $id)->first();
        $course = Courses::where('course_id', $admission->course_id)->first();
            if ($admission->student_type == 1){
                $group = 'SSP';
            }elseif ($admission->student_type == 2){
                $group = 'KUCCPS';
            }else{
                $group = 'SSP';
            }
            $student = [
                'student_number' => $admission->student_number,
                'full_name' => $admission->first_name.' '.$admission->middle_name.' '.$admission->surname,
                'class_code' => $admission->entry_class,
                'group_code' => $group,
                'course_code' => $course->course_code
            ];

        $this->appApi->createStudent($student);

        $class = Classes::where('name', $admission->entry_class)->first();
            $pattern = ClassPattern::where('class_code', $admission->entry_class)->pluck('semester')->toArray();
            $fees = SemesterFee::where('course_code', $course->course_code)
                ->where('version', $class->fee_version)
                ->where('attendance_id', $admission->student_type)
                ->where('semester', min($pattern))
                ->get();

            foreach ($fees as $fee){
                $particular [] = [
                    'votehead_id' => $fee->vote_id,
                    'votehead_name' => $fee->semVotehead->vote_name,
                    'quantity'  => '1',
                    'unit_price' => $fee->amount
                ];
            }

        $invoice = [
            'batch_description' => 'New Semester Invoices',
            'Invoices' => [
                ['student_number' => $admission->student_number,
                'invoice_description' => "NEW STUDENT INVOICE",
                'InvoiceItems' => $particular,
                    ]
            ]
        ];
        $this->appApi->invoiceStudent($invoice);

        return redirect()->back()->with('success', 'Your documents submitted for admission process');
    }

    public function inbox(){

        $apps  = Application::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();

        if (count($apps) == 0) {

            $notification = [];
        } else {

            foreach ($apps as $id) {

                $notification = Notification::where('application_id', $id->id)->where('status', '>', 0)->latest()->get();
            }
        }

        return view('application::applicant.inbox')->with(['notification' => $notification]);
    }

    public function myAdmission(){
        $myadmission = ApplicationsView::where('applicant_id', \auth()->guard('web')->user()->applicant_id)->get();
        return view('application::applicant.myadmissions')->with('courses', $myadmission);
    }
}
