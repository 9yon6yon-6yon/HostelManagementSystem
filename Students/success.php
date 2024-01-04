<?php

$pageTitle = "Payment Successful";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'payment.php', 'label' => 'Payment'],

];
$tran_id = $_POST['tran_id'];
$amount =  $_POST['amount'];

$content = "
<div class='card pd-20 pd-sm-40 mg-t-50'>
<h6 class='card-body-title'>Payment Successful</h6>
<p class='mg-b-20 mg-sm-b-30'>Your payment was successfull</p>

<div class='row'>
    <div class='col-lg-12 '>
        <div class='input-group'>
          <p>Payment successful</p>
    </div>
    </div><!-- col-4 --> 
</div><!--row-4-->
</div>
";

$script = "
$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: {
            action: 'success-pay',
            tran_id: '$tran_id',
            amount: '$amount',
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response) {
                showAlert('success',response.success);
            } else {
                console.error('Error:', response.error || 'Unknown error');
            }
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });

});
";

// setTimeout(function() {
//     // Replace 'your_target_page.php' with the actual URL you want to redirect to
//     window.location.href = 'payment.php';
// }, 3000);
include '../templates/base.php';
