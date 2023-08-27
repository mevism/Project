<?php

namespace Modules\Epayment\Http\Controllers;

use App\Http\Apis\AppApis;
use App\Service\CustomIds;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Application\Entities\VerifyUser;
use Modules\Epayment\Entities\Epayment;

class EpaymentController extends Controller{
    protected $appApi;

    public function __construct(AppApis $appApi){
        $this->appApi = $appApi;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        return view('epayment::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function register(Request $request){
        $student = DB::connection('sqlsrv1')->table('tblSTUDENTS')->where('RegStud_Email',  $request->student_email)->where('RegStud_No_PK', $request->student_number)->first();
        return view('epayment::register')->with('student',  $student);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){
        $request->validate([
            'student_number' => 'required|string',
            'student_email' => 'required|string',
            'student_name' => 'required|string',
            'phone_number' => 'required|string|min:9|max:13',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|string',
        ]);

        if ($request->student_number == $request->password){

            return redirect()->back()->with('error', 'Student number should not match the password');

        }else{
            $studentID = new CustomIds();
            Epayment::create([
                'student_id' => $studentID->generateId(),
                'username' => $request->student_number,
                'student_email' => $request->student_email,
                'student_name' => $request->student_name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
        }

        return  redirect()->route('root')->with('success', 'Student Account Created successfully');
    }

    public function estudent(){
        return view('epayment::verifyPhone');
    }

    public function verifications(Request $request){
        if (auth()->guard('epayments')->user()->verification == $request->verification_code){
            return redirect()->route('epayment.student')->with('success', 'Login successful');
        }else{
            return redirect()->back()->with('error', 'Verification code entered is invalid');
        }
    }

    public function getnewCode(){
        $verification_code = rand(1, 999999);
        Epayment::where('student_id', auth()->guard('epayments')->user()->student_id)->update(['verification' => $verification_code]);
        $phoneNumber =  auth()->guard('epayments')->user()->phone_number;
        $message = 'Welcome to Ecitizen Payment Platform. Your verification code is '. $verification_code;
        $this->appApi->sendSMS($phoneNumber, $message);

        return redirect()->back()->with('success', 'New verification code was sent to you');
    }

    public function dashboard(){
        return view('epayment::dashboard.index');
    }

    public function paymentRequest(){
        $studentNumber = str_replace('/', '', auth()->guard('epayments')->user()->username);
        $balance = $this->appApi->StudentStatement($studentNumber);
        $fee = $balance['dataPayload']['data']['StatementSummary']['fee_balances'];
        return view('epayment::dashboard.requestPayment')->with('fee', $fee);
    }

    public function makeRequest(Request $request){
        $request->validate([
           'amount' => 'required|numeric',
           'type' => 'required|string',
        ]);
        $bill = 'INV'.time();
        $payload = [
            'apiClientID' => '101',
            'serviceID' => 'TUM4242',
            'billDesc' => $request->type,
            'currency' => 'KSH',
            'billRefNumber' => $bill,
            'clientMSISDN' => auth()->guard('epayments')->user()->phone_number,
            'clientName' => auth()->guard('epayments')->user()->student_name,
            'clientIDNumber' => auth()->guard('epayments')->user()->username,
            'clientEmail' => auth()->guard('epayments')->user()->student_email,
            'callBackURLONSuccess' => 'urls',
            'amountExpected' => $request->total_amount,
            'notificationURL' => 'url',
        ];
        return $payload;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('epayment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('epayment::edit');
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
}
