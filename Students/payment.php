
<?php

$pageTitle = "Pay Bill";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'payment.php', 'label' => 'Payment'],

];

$content .= "
<div class='card pd-20 pd-sm-40 mg-t-50'>
<h6 class='card-body-title'>Payment Form</h6>
<p class='mg-b-20 mg-sm-b-30'>Pay your due from here</p>

<div class='row'>
    <div class='col-lg-12 '>
        <div class='input-group'>
            <span class='input-group-addon'><i class='fa fa-credit-card  tx-16 lh-0 op-6'></i></span>
            <input type='text' class='form-control' id='amountInput' placeholder='Amount'>
            <button class='btn btn-primary'  id='payButton' name='pay' >Pay Now</button>
    </div>
    </div><!-- col-4 --> 
</div><!--row-4-->
</div>
";

$script = "
$('#payButton').on('click', function() {
    var amount = $('#amountInput').val();

    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: {
            action: 'pay',
            amount: amount
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response && response.GatewayPageURL) {
                // Redirect the user to GatewayPageURL
                // window.open(response.GatewayPageURL);
                window.location.href = response.GatewayPageURL;
            } else if (response && response.success) {
                console.log('Success:', response.success);
            } else {
                // Handle other scenarios or show an error message
                console.error('Error:', response.error || 'Unknown error');
            }
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});
";


include '../templates/base.php';
