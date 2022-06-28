<?php

namespace Modules\Application\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Application\Emails\VerifyEmails;
use Modules\Application\Entities\Applicant;
use Illuminate\Support\Facades\Hash;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Application\Entities\Guardian;
use Modules\Application\Entities\Sponsor;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\WorkExperience;
use Modules\Courses\Entities\AvailableCourse;
use Modules\Courses\Entities\Courses;
use Modules\Courses\Entities\Intake;
use Session;
use Auth;
use Illuminate\Support\Facades\Mail;


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
            'mobile' => 'required|regex:/(0)[0-9]{9}/|min:10|max:10',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

    //    return $request->all();


            $app = new Applicant;
            $app->mobile = $request->mobile;
            $app->username = $request->email;
            $app->email = $request->email;
            $app->password = Hash::make($request->password);
            $app->save();

            VerifyEmail::create([
                'user_id' => $app->id,
                'verification_code' => Str::random(100),
            ]);

            Mail::to($app->email)->send(new VerifyEmails($app));

            return redirect(route('root'))->with(['info' => 'Account verification email was sent to verify your account']);
    }

    public function phoneverify(){
        return view('application::auth.phoneverification');
    }

    public function phoneVerification(Request $request)
    {
        $validated = $request->validate([
            'verification_code' => 'required|alpha_num',
            'phone_number' => 'required|alpha_num'
        ]);

        $unverified = VerifyUser::where('verification_code' , $request->verification_code)->first();


        if (isset($unverified)){

            $applicant = $unverified->applicant;

            if (!$applicant->phone_verification){
                $applicant->phone_verification = 1;
                $applicant->save();

                VerifyUser::where('verification_code', $request->verification_code)->delete();

                 return redirect()->route('application.verification')->with('success', 'Phone number verified successfully');

            }else{
                return redirect(route('root'))->with('warning', 'Phone verification failed');
            }
        }else{
            return redirect()->back()->with('info', 'Phone number already verified');
        }

        return redirect()->back()->with('error', 'Phone number failed verification');
    }
    public function phonereverification(Request $request){

        $validated = $request->validate([
            'verification_code' => 'required|alpha_num',
            'phone_number' => 'required|alpha_num'
        ]);

            $applicant = Auth::user();

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

    public function emailVerification($verification_code){
        $unverified = VerifyEmail::where('verification_code', $verification_code)->first();

        if (isset($unverified)){

            $applicant = $unverified->applicant;

            if (!$applicant->email_verified_at){
                $applicant->email_verified_at = Carbon::now();
                $applicant->save();

                VerifyEmail::where('verification_code', $verification_code)->delete();

                return redirect(route('root'))->with('success', 'Your email has been verified');
            }

            return redirect(route('root'))->with('warning', 'The code does not exist');
        }else{
            return redirect(route('root'))->with('info', 'Email already verified');
        }
    }

    public function checkverification(){

        return view('application::auth.landing');
    }

    public function dashboard(){

        $courses = Intake::where('status', 1)->get();

            if (count($courses) === 0 ){
          $mycourses = Application::where('user_id', Auth::user()->id)->count();

        if (Auth::check()) {

            if (Auth::user()->email_verified_at === null){
                Auth::logout();

                return redirect(route('root'))->with('warning', 'Please verify your email first');
            }
            if (Auth::user()->user_status === 0) {
                return redirect()->route('application.details')->with(['info' => 'Please update your profile']);

            } else {

                return view('application::applicant.home')->with(['success' => 'Welcome', 'courses' => $courses, 'mycourses' => $mycourses]);

            }
            redirect()->route('application.login')->with('error', 'Please try again');
        }


            }else{
                $intake = Intake::where('status', 1)->get();

                foreach ($intake as $id){

                    $course = AvailableCourse::where('intake_id', $id->id)->get();

                    foreach ($course as $item){
                        $available_courses [] = Courses::where('id', $item->course_id)->count();

                        $courses = $available_courses;
                    }

                }

                $mycourses = Application::where('user_id', Auth::user()->id)->count();

                if (Auth::check()) {

                    if (Auth::user()->email_verified_at === null){
                        Auth::logout();

                        return redirect(route('root'))->with('warning', 'Please verify your email first');
                    }
                    if (Auth::user()->user_status === 0) {
                        return redirect()->route('application.details')->with(['info' => 'Please update your profile']);

                    } else {

                        return view('application::applicant.home')->with(['success' => 'Welcome', 'courses' => $courses, 'mycourses' => $mycourses]);

                    }
                    redirect()->route('application.login')->with('error', 'Please try again');
                }
            }

    }


    public function reverify(){
        return view('application::auth.reverifyphone');
    }

    public function openDetails(){
        return view('application::applicant.updatePage')->with('info', 'Update your profile to continue');
    }

    public function makeupdate(Request $request){

        $request->validate([
            'sname' => 'required|alpha',
            'fname' => 'required|alpha',
            'mname' => 'string|nullable',
            'dob'=> 'required:date_format:Y-M-D|before:2006-05-16',
            'gender' => 'required|string',
            'disabled' => 'required',
            'disability' => 'string|nullable',
            'index_number' => 'required|string',
            'alt_number' => 'required|regex:/(0)[0-9]{9}/|min:10|max:10',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'county' => 'required|string',
            'subcounty' => 'required|string',
            'town' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|string',
            'id_number' => 'required|alpha_num|min:7'
        ]);

//        $request->all();

        $user = Applicant::where('id', Auth::user()->id)->first();
        $user->sname = $request->sname;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->gender = $request->gender;
        $user->index_number = $request->index_number;
        $user->id_number = $request->id_number;
        $user->alt_mobile = $request->alt_number;
        $user->dob = $request->dob;
        $user->disabled = $request->disabled;
        $user->disability = $request->disability;
        $user->title = $request->title;
        $user->nationality = $request->nationality;
        $user->county = $request->county;
        $user->sub_county = $request->subcounty;
        $user->town = $request->town;
        $user->address = $request->address;
        $user->user_status = 1;
        $user->title = $request->title;
        $user->marital_status = $request->status;
        $user->save();

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
        $mycourses = Application::where('user_id', Auth::user()->id)->paginate(5);
        return view('application::applicant.mycourses')->with('courses', $mycourses);
    }

    public function allCourses(){

        $active = Intake::where('status', 1)->get();

        if (count($active) === 0){
            $active = [];

            return view('application::applicant.courses', compact('active'));

        }else{

            foreach ($active as $intake){

                $available = AvailableCourse::where('intake_id', $intake->id)->get();
                foreach ($available as $item){
                    $courses [] = Courses::where('id', '=', $item->course_id)->paginate(7);
                }
            }

            return view('application::applicant.courses', compact('courses', 'active'));

        }
    }

    public function applyNow($id){
        $schools = School::all();
        $departments = Department::all();
        $courses = Course::all();
        $course = Course::find($id);

        return view('application::applicant.application')
            ->with(['course' => $course, 'schools' => $schools, 'departments' => $departments, 'courses' => $courses]);
    }

    public function applicationEdit($id){
        $application = Application::find($id);

        $education = Education::where('user_id', Auth::user()->id)->get();
        $work = WorkExperience::where('user_id', Auth::user()->id)->get();
        $parent = Guardian::where('user_id', Auth::user()->id)->get();
        $sponsor = Sponsor::where('user_id', Auth::user()->id)->get();

            return $application."education".$education."work".$work."sponsor".$sponsor."guardian".$parent;
    }

    public function application(Request $request){
        $request->validate([
            'subject1' => 'required|string',
            'subject2' => 'string|required',
            'subject3' => 'string|required',
            'subject4' => 'string|required',
            'secondary' => 'string|required',
            'secondaryqualification' => 'string|required',
            'secstartdate' => 'string|required',
            'secenddate' => 'string|required',
            'seccert' => 'mimes:image,pdf|required|max:2048',
            'tertiary' => 'string|nullable',
            'tertiaryqualification' => 'string|nullable',
            'terstartdate' => 'string|nullable',
            'terenddate' => 'string|nullable',
            'tercert' => 'mimes:image,pdf|nullable|max:2048',
            'tertiary2' => 'string|nullable',
            'tertiary2qualification' => 'string|nullable',
            'ter2startdate' => 'string|nullable',
            'ter2enddate' => 'string|nullable',
            'ter2cert' => 'mimes:image,pdf|nullable|max:2048',
            'tertiary3' => 'string|nullable',
            'tertiary3qualification' => 'string|nullable',
            'ter3startdate' => 'string|nullable',
            'ter3enddate' => 'string|nullable',
            'ter3cert' => 'mimes:image,pdf|nullable|max:2048',
            'org1' => 'string|nullable',
            'org1post' => 'string|nullable',
            'org1startdate' => 'string|nullable',
            'org1enddate' => 'string|nullable',
            'org2' => 'string|nullable',
            'org2post' => 'string|nullable',
            'org2startdate' => 'string|nullable',
            'org2enddate' => 'string|nullable',
            'org3' => 'string|nullable',
            'org3post' => 'string|nullable',
            'org3startdate' => 'string|nullable',
            'org3enddate' => 'string|nullable',
            'parentname' => 'string|required',
            'parentmobile' => 'string|required|regex:/(0)[0-9]{9}/|min:10|max:10',
            'parentcounty' => 'string|required',
            'parenttown' => 'string|required',
            'sponsorname' => 'string|required',
            'sponsormobile' => 'string|required|regex:/(0)[0-9]{9}/|min:10|max:10',
            'sponsorcounty' => 'string|required',
            'sponsortown' => 'string|required',
            'receipt' => 'string|required|unique:applications',
            'receipt_file' => 'mimes:jpeg,jpg,png,pdf|required|max:2048'
        ]);

//        return $request->all();

        $application = new Application;
        $application->user_id = Auth::user()->id;
        $application->school = $request->school;
        $application->department = $request->department;
        $application->course = $request->course;
        $application->subject_1 = $request->subject1;
        $application->subject_2 = $request->subject2;
        $application->subject_3 = $request->subject3;
        $application->subject_4 = $request->subject4;
        $application->receipt = $request->receipt;

        if ($request->hasFile('receipt_file')){
            $file = $request->receipt_file;
            $fileName = 'receipt'.time().'.'.$file->getClientOriginalExtension();
            $request->receipt_file->move('receipts', $fileName);
        $application->receipt_file = $fileName;
        }

        $application->save();


        $education = new Education;
        $education->user_id = Auth::user()->id;
        $education->institution = $request->secondary;
        $education->qualification = $request->secondaryqualification;
        $education->start_date = $request->secstartdate;
        $education->exit_date = $request->secenddate;

        if ($request->hasFile('seccert')){
            $file = $request->seccert;
            $fileName = 'seccert'.time().'.'.$file->getClientOriginalExtension();
            $request->seccert->move('certs', $fileName);
            $education->certificate = $fileName;
        }

        $education->save();

        if ($request->filled(['tertiary', 'teriaryqualification', 'terstartdate', 'terenddate'])){

            $education = new Education;
            $education->user_id = Auth::user()->id;
            $education->institution = $request->tertiary;
            $education->qualification = $request->teriaryqualification;
            $education->start_date = $request->terstartdate;
            $education->exit_date = $request->terenddate;

            if ($request->hasFile('tercert')){
                $file = $request->tercert;
                $fileName = 'tercert'.time().'.'.$file->getClientOriginalExtension();
                $request->tercert->move('certs', $fileName);
                $education->certificate = $fileName;
            }
            $education->save();
        }

        if ($request->filled(['tertiary2', 'teriary2qualification', 'ter2startdate', 'ter2enddate'])) {

            $education = new Education;
            $education->user_id = Auth::user()->id;
            $education->institution = $request->tertiary2;
            $education->qualification = $request->teriary2qualification;
            $education->start_date = $request->ter2startdate;
            $education->exit_date = $request->ter2enddate;

            if ($request->hasFile('ter2cert')) {
                $file = $request->ter2cert;
                $fileName = 'ter2cert' . time() . '.' . $file->getClientOriginalExtension();
                $request->ter2cert->move('certs', $fileName);
                $education->certificate = $fileName;
            }
            $education->save();
        }

        if ($request->filled(['tertiary3', 'ter3iaryqualification', 'ter3startdate', 'ter3enddate'])) {

            $education = new Education;
            $education->user_id = Auth::user()->id;
            $education->institution = $request->tertiary3;
            $education->qualification = $request->ter3iaryqualification;
            $education->start_date = $request->ter3startdate;
            $education->exit_date = $request->ter3enddate;

            if ($request->hasFile('ter3cert')) {
                $file = $request->ter3cert;
                $fileName = 'ter3cert' . time() . '.' . $file->getClientOriginalExtension();
                $request->ter3cert->move('certs', $fileName);
                $education->certificate = $fileName;
            }

            $education->save();
        }

        if ($request->filled(['org1', 'org1post', 'org1startdate', 'org1enddate'])) {

            $work = new WorkExperience;

            $work->user_id = Auth::user()->id;
            $work->organization = $request->org1;
            $work->post = $request->org1post;
            $work->start_date = $request->org1startdate;
            $work->exit_date = $request->org1enddate;
            $work->save();

        }

        if ($request->filled(['org2', 'org2post', 'org2startdate', 'org2enddate'])) {

            $work = new WorkExperience;
            $work->user_id = Auth::user()->id;
            $work->organization = $request->org2;
            $work->post = $request->org2post;
            $work->start_date = $request->org2startdate;
            $work->exit_date = $request->org2enddate;
            $work->save();

        }

        if ($request->filled(['org3', 'orgpost3', 'org3startdate', 'org3enddate'])) {

            $work = new WorkExperience;
            $work->user_id = Auth::user()->id;
            $work->organization = $request->org3;
            $work->post = $request->orgpost3;
            $work->start_date = $request->org3startdate;
            $work->exit_date = $request->org3enddate;
            $work->save();
        }

        $parent = new Guardian;
        $parent->user_id = Auth::user()->id;
        $parent->guardian_name = $request->parentname;
        $parent->guardian_mobile = $request->parentmobile;
        $parent->guardian_county = $request->parentcounty;
        $parent->guardian_town = $request->parenttown;
        $parent->save();

        $sponsor = new Sponsor;
        $sponsor->user_id = Auth::user()->id;
        $sponsor->sponsor_name = $request->sponsorname;
        $sponsor->sponsor_mobile = $request->sponsormobile;
        $sponsor->sponsor_county = $request->sponsorcounty;
        $sponsor->sponsor_town = $request->sponsortown;
        $sponsor->save();

        return redirect()->route('applicant.course')->with('success', 'You submitted your application successfully');
    }

    public function viewCourse($id){
        $course = Courses::find($id);

        return view('application::applicant.viewcourse')->with('course', $course);
    }

    public function apply(Course $course){

        $schools = School::all();
        $departments = Department::all();
        $courses = Course::all();

        return view('application::applicant.application')
            ->with(['course' => $course, 'schools' => $schools, 'departments' => $departments, 'courses' => $courses]);
    }

    public function myProfile(){
        return view('application::applicant.profilepage');
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
