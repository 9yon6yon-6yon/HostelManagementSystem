
<?php

$pageTitle = "Pay Bill";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'payment.php', 'label' => 'Payment'],

];

$content .= "
<button id='payBillButton' class='btn btn-primary'>Pay Bill</button>

";

$script = "$(function(){
  
    $('#payBillButton').click(function() {
        // Make an AJAX request to process.php for paying the bill
        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: { action: 'pay-bill' }, // You may need to include additional data
            dataType: 'json',
            success: function(response) {
                // Handle the response from the server after paying the bill
                if (response.success) {
                    showAlert('success', response.success);
                } else {
                    showAlert('error', response.error);
                }
            },
            error: function() {
                alert('An error occurred while processing the request.');
            }
        });
    });
  });";


include '../templates/base.php';
