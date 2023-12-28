<?php
require('DatabaseHandler.php');
require('../Authentication/AuthHandler.php');
$pageTitle = "Applications";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'applications.php', 'label' => 'Applications'],

];
$databaseHandler = new DatabaseHandler();
$authHandler = new AuthHandler();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $application = $databaseHandler->getApplication($id);

    $appliedByName = $authHandler->getUserName($application['applied_by']);
    $approvedByName = $authHandler->getUserName($application['approved_by']);

    $formattedDate = date("M d, Y g:ia", strtotime($application['date']));
    $tableRow = '';

    $tableRow .= "
            <div class='card-header card-header-default bg-info justify-content-between'>
                <h6 class='mg-b-0 tx-14 tx-white tx-normal'>Application ID: {$application['application_id']}</h6>
            </div><!-- card-header --> 
            <div class='card-body bg-gray-200'>
        
            <p>Application Type: {$application['application_type']}</p>
            <p>Status: {$application['status']}</p>
            <p>Applied By: {$appliedByName}</p>
            <p>Approved By: {$approvedByName}</p>
            <p class='card-subtitle tx-normal mg-b-15'>Applied at: {$formattedDate}</p> 
            <p class='mg-b-0'>{$application['description']}</p>
         
    ";
    $pages =  [
        ['url' => 'dashboard.php', 'label' => 'Dashboard'],
        ['url' => 'applications.php', 'label' => 'Applications'],
        ['url' => "applications.php?id={$application['application_id']}", 'label' => "Application ID: {$application['application_id']}"]
    ];
    $content = "
        <div class='card pd-20 pd-sm-40'>
            <div class='card-body'>
                $tableRow
            </div>
            <div class='card-footer bg-gray-300 d-flex justify-content-between'>
            <a href='#' class='btn btn-primary btn-approve' data-application-id='{$application['application_id']}'>Approve</a>
            <a href='#' class='btn btn-danger btn-reject' data-application-id='{$application['application_id']}'>Reject</a>
        </div>
        </div>
    ";
}

$applications_all = $databaseHandler->getApplications();
$tableRows = '';
foreach ($applications_all as $application) {
    $formattedDate = date("M d, Y g:ia", strtotime($application['date']));
    $shortDescription = substr($application['description'], 0, 50);
    $tableRows .= "<tr>
        <td class='wd-5p tx-center'>{$application['application_id']}</td>
        <td>
            <a href=\"applications.php?id={$application['application_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$shortDescription}</a>
            <div class='hidden-details' style='display:none;'>{$application['description']}</div>
        </td>
        <td class='wd-10p tx-center'>{$application['application_type']}</td>
        <td class='wd-10p tx-center'>{$application['status']}</td>
        <td class='wd-10p tx-center'>{$application['applied_by']}</td>
        <td class='tx-center'>{$formattedDate}</td>
    </tr>";
}

$content .= "
<div class='card pd-20 pd-sm-40 mg-t-50'>
    <h6 class='card-body-title'>Applications</h6>
    <div class='table-wrapper'>
        <table id='datatable1' class='table display responsive nowrap'>
            <thead>
                <tr>
                    <th class='wd-5p'>ID</th>
                    <th class='wd-30p'>Description</th>
                    <th class='wd-10p tx-center'>Type</th>
                    <th class='wd-10p tx-center'>Status</th>
                    <th class='wd-10p tx-center'>Applied By</th>
                    <th class='wd-15p tx-center'>Date</th>
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
    function handleAction(action, applicationID) {
        $.ajax({
            type: 'GET',
            url: 'process.php',
            data: { action: action, applicationID: applicationID },
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);
                    
                    setTimeout(function () {
                        window.location.href = 'applications.php';
                    }, 3000); // 3000 milliseconds = 3 seconds
                } else if (response.error) {
                    showAlert('error', response.error);
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    // Event listener for Approve button click
    $('body').on('click', '.btn-approve', function (e) {
        e.preventDefault();
        var applicationID = $(this).data('application-id');
        handleAction('approve_request', applicationID);
    });

    // Event listener for Reject button click
    $('body').on('click', '.btn-reject', function (e) {
        e.preventDefault();
        var applicationID = $(this).data('application-id');
        handleAction('reject_request', applicationID);
    });

});";


include '../templates/base.php';
