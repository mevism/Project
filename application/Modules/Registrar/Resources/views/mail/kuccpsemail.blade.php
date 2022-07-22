<style>
    .email-body{
        margin: 0 auto !important;
        word-spacing: 7px;
    }
    .email-container{
        height: auto !important;
        width: 50% !important;
        margin: 10% auto !important;
        border: solid goldenrod 2px !important;
        border-radius: 1% !important;
        padding: 20px !important;
    }

    .text{
        width: 40% !important;
        margin: auto !important;
    }

</style>

<div class="email-body">
<div class="email-container">
    <h5>Dear {{ $kuccpsApplicant->fname }} {{ $kuccpsApplicant->mname }} {{ $kuccpsApplicant->sname }}, </h5>
    <p>
        Congratulations for being approved as successfull applicant of <b> Technical Univerisity of Mombasa</b>. Please visit the <a href="{{ route('root') }}"> TUM Course Application Portal </a> to download your admission documents. For any queries reach use via our email tumsupport@tum.ac.ke
    </p>
    <div>
        <p>
            <b>
                Yours sincerely,<br></b><br>

                Zablon Gitau <br><br>

               Admissions Department <br><br>

             Technical University of Mombasa
            
        </p>
    </div>
</div>
</div>

{{--{{ route('application.emailverification', $applicant->VerifyEmail->verification_code) }}--}}
