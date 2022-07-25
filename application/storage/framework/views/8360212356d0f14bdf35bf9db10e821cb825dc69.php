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
       
        Thank you for your application at Technical University of Mombasa. However we are sorry to inform you that you did not meet the minimum requirements for the course applied. You can visit the <a href="<?php echo e(route('root')); ?>"> TUM Course Application Portal </a> to apply for a new course which you meet the requirements. For any queries you can contact our support at tumsupport@tum.ac.ke. 
      
 
    </p>
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


<?php /**PATH /var/www/html/Finale/application/Modules/Registrar/Resources/views/offer/rejectedMail.blade.php ENDPATH**/ ?>