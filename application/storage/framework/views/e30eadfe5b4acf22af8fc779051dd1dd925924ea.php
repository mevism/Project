<style>
    .email-body{
        margin: 0 auto !important;
        word-spacing: 9px;
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
    <h5>Dear <?php echo e($applicant->fname); ?> <?php echo e($applicant->mname); ?> <?php echo e($applicant->sname); ?>,</h5>
    
    <p>
       
        Thank you for your application at Technical University of Mombasa. <br> We really appreciate your interest
         in joining our institution and we want to thank you for the time and energy you invested in applying 
         for our vacancy opening.
        We received a large number of applications, and after carefully reviewing all of them, unfortunately, 
        we have to inform you that this time we won’t be able to invite you to the next phase of our admission
         process. Though your qualifications are impressive, we have decided to move forward with a candidate 
         whose experiences better meet our needs for this particular vacancy. However, we really do appreciate
          your interest in our institution. We hope you’ll keep us in mind and apply again in the future should
           you see a vacancy opening for which you qualify.If you have any questions or need additional 
           information, please don’t hesitate to contact us through our website <a href="https://www.tum.ac.ke/">
            tum.ac.ke</a> We wish you every personal and academic success in your future endeavors. Once again, 
            thank you for your interest in working with us.
      
 
    </p><br>
    <div>
        <p>
            <b>
                Kind regards,<br></b><br>

                Zablon Gitau <br><br>

               Admissions Department <br><br>

             Technical University of Mombasa
            
        </p>
    </div>
</div>
</div>


<?php /**PATH C:\xampp\htdocs\sims\application\Modules/Courses\Resources/views/offer/rejectedMail.blade.php ENDPATH**/ ?>