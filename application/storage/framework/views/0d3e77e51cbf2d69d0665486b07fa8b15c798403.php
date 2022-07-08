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
    <h5>Dear <?php echo e($applicant->fname); ?> <?php echo e($applicant->mname); ?> <?php echo e($applicant->sname); ?>, </h5>
    
    <p>

On behalf of everyone at Technical University of Mombasa, I am pleased to congratulate 
you on our acceptance of your application. We were very impressed by your academic history 
and achievements and feel that you would make an excellent addition to the Technical University of Mombasa
 alumni. As you know, Technical University of Mombasa is the oldest Institution in the area and we are 
 known for accepting only the best students. After careful review of your application, we are delighted to 
 say that we believe you meet our criteria for acceptance.

Please visit your portal to find the necessary enrollment letter. We appreciate your filling them out and 
returning them to us by August 15, 2022, in order to ensure your enrollment at Technical University of Mombasa
 and facilitate the acceptance process for our program. If you have any questions or problems, please feel free
  to contact us through our website <a href="https://www.tum.ac.ke/">tum.ac.ke</a> We look forward to hearing from you.

We encourage your prompt attention to the enrollment forms in order to ensure your place in Technical University
 of Mombasa’s program. We are very pleased to accept you into Technical University of Mombasa
 and hope that you find it a fulfilling and helpful experience that gets you on the road to achieving your dreams.
  We wish you all the best and thank you for choosing Technical University of Mombasa.<br>



    </p><br>
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


<?php /**PATH C:\xampp\htdocs\sims\application\Modules/Courses\Resources/views/offer/acceptedMail.blade.php ENDPATH**/ ?>