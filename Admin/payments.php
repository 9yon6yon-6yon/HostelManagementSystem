<?php
require('DatabaseHandler.php');
require('../Authentication/AuthHandler.php');
$pageTitle = "Payments";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'payments.php', 'label' => 'Payments'],

];

$databaseHandler = new DatabaseHandler();
$authHandler = new AuthHandler();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $payment = $databaseHandler->getPaymentInfo($id);

    $formattedDate = date("M d, Y g:ia", strtotime($payment['date']));
    $tableRow = '';
    $tableRow .= "
                <h5 class='card-body-title'>{$payment['user_name']}</h5> <p>Email address : {$payment['user_email']}</p>
                <p class='card-subtitle tx-normal mg-b-15'> uploaded at : {$formattedDate}</p>
                <p class='card-text'>Payment amount: {$payment['amount']}</p>
                <p class='card-text'>payment status: {$payment['status']}</p>
                <p class='card-text'>{$payment['description']}</p>
                ";
    $pages =  [
        ['url' => 'dashboard.php', 'label' => 'Dashboard'],
        ['url' => 'payments.php', 'label' => 'payments'],
        ['url' => "payments.php?id={$payment['payment_id']}", 'label' => "{$payment['user_name']}"]
    ];
    $content = "
    <div class='card pd-20 pd-sm-40'>
        <div class='row'>
            <div class='col-md'>
                <div class='card bg-gray-200'>
                    <div class='card-body'>
                   $tableRow
                    </div>
                </div><!-- card -->
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- main card -->";
}
$payments_all = $databaseHandler->getpayments();
$tableRows = '';
foreach ($payments_all as $payments) {
    $formattedDate = date("g:ia M d, Y", strtotime($payments['date']));
    $disableRequestButton = ($payments['status'] !== 'due') ? 'disabled' : ''; // Disable if status is not 'due'

    $tableRows .= "<tr>
        <td class='wp-10p tx-center' data-sort='{$payments['date']}'>{$formattedDate}</td>
        <td class='wp-15p'>
            <a href=\"payments.php?id={$payments['payment_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$payments['user_name']}</a>
        </td>
        <td class='wd-10p tx-center'>{$payments['status']}</td>
         <td class='wd-10p tx-center'>
            <button class='btn btn-success approve-payment' data-payment-id='{$payments['payment_id']}'>Approve</button>
            <button class='btn btn-warning request-payment' data-payment-id='{$payments['payment_id']}' {$disableRequestButton}>Request</button>
        </td>
        
    </tr>";
}
$content .= "
<div class='card pd-20 pd-sm-40'>
    <h6 class='card-body-title'>payments</h6>
    <div class='table-wrapper'>
        <table id='datatable1' class='table display responsive nowrap'>
            <thead>
                <tr> 
                    <th class='wd-10p tx-center'>Due Date</th>
                    <th class='wd-15p'>User Name</th>
                    <th class='wd-10p tx-center'>Status</th>
                    <th class='wd-10p tx-center'>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                $tableRows
            </tbody>
        </table>
    </div><!-- table-wrapper -->
</div><!-- card -->
";

$script = "$(function(){
    'use strict';

    $('#datatable1').DataTable({
      responsive: true,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    $('#datatable2').DataTable({
      bLengthChange: false,
      searching: false,
      responsive: true
    });

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#datatable1').on('click', '.request-payment', function() {
        if ($(this).prop('disabled')) {
            showAlert('warning', 'Cannot request payment for this status.');
            return;
        }

        var paymentId = $(this).data('payment-id');
        requestPayment(paymentId);
    });
    $('#datatable1').on('click', '.approve-payment', function() {
        var paymentId = $(this).data('payment-id');
        approvePayment(paymentId);
    });

    // Function to handle payment request
    function requestPayment(paymentId) {
        var formData = {
            action: 'requestPayment',
            paymentId: paymentId
        };

        // Perform AJAX request to process.php for payment request
        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.success);
                } else if (response.error) {
                    showAlert('error', response.error);
                }
            },
            error: function(error) {
                console.error(error);
                showAlert('error', 'An error occurred while processing your request.');
            }
        });
    }
    function approvePayment(paymentId) {
        var formData = {
            action: 'approvePayment',
            paymentId: paymentId
        };

        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.success);
                } else if (response.error) {
                    showAlert('error', response.error);
                }
            },
            error: function(error) {
                console.error(error);
                showAlert('error', 'An error occurred while processing your request.');
            }
        });
    }

  });";


include '../templates/base.php';
