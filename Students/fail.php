
<?php

$pageTitle = "Payment failed";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'payment.php', 'label' => 'Payment'],

];
$tran_id = $_POST['tran_id'];
$amount =  $_POST['amount'];

$content .= "
<div class='card pd-20 pd-sm-40 mg-t-50'>
<h6 class='card-body-title'>Payment Failed</h6>
<div class='row'>
    <div class='col-lg-12 '>
    <div class='alert alert-danger alert-bordered pd-y-20' role='alert'>
    <div class='d-flex align-items-center justify-content-start'>
      <i class='icon ion-ios-close alert-icon tx-52 tx-danger mg-r-20'></i>
      <div>
        <h5 class='mg-b-2 tx-danger'>Oh snap! Failed to process the payment.</h5>
        <p class='mg-b-0 tx-gray'>Please Try again later...</p>
      </div>
    </div><!-- d-flex -->
  </div><!-- alert -->
    </div><!-- col-4 --> 
</div><!--row-4-->
</div>
";

$script = "
$.ajax({
    type: 'POST',
    url: 'process.php',
    data: {
        action: 'fail-pay',
        tran_id: '$tran_id',
        amount: '$amount',
    },
    dataType: 'json',
    success: function(response) {
        console.log(response);
        if (response.success) {
            showAlert('success', response.success);
        } else {
            showAlert('error', response.error);
        }
    },
    error: function(error) {
        console.error('Error:', error);
    }
});

";


include '../templates/base.php';
