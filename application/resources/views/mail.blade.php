   <style>
        .email-body{
            margin: 0 auto !important;
        }
        .email-container{
            height: 50vh !important;
            width: 50% !important;
            margin: 10% auto !important;
            border: solid goldenrod 2px !important;
            border-radius: 1% !important;
            padding: 20px !important;
        }

        .activate{
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px !important;
            border-radius: 4px !important;
        }

        .text{
            width: 40% !important;
            margin: auto !important;
        }

    </style>

<div class="email-body">
    <div class="email-container">
        <h5>Dear Applicant</h5>
        <p>
            Welcome to Technical University of Mombasa Applicant Portal. You are getting this email because you submitted a registration request to our system. To proceed to complete the registration process you need to confirm you email to activate your applicants account. If your account is not activated within 72hours it will lead to permanent deactivation of the account.
        </p>
        <div class="text">
            <a type="button" class="activate" href="" data-toggle="click-ripple">Activate Account</a>
        </div>
        <p>
            You can also copy and paste the following url to your browser to activate your account.<br>
            <a style="overflow-wrap: break-word !important;" href="#">
                xx
            </a>
        </p>
    </div>
</div>

{{--{{ route('application.emailverification', $applicant->VerifyEmail->verification_code) }}--}}
