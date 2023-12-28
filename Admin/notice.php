<?php
require('DatabaseHandler.php');
require('../Authentication/AuthHandler.php');
$pageTitle = "Notice";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'notice.php', 'label' => 'Notice'],

];

$databaseHandler = new DatabaseHandler();
$authHandler = new AuthHandler();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $notice = $databaseHandler->getNotice($id);
    $uploadedby = $authHandler->getUserName($notice['updated_by']);

    $formattedDate = date("M d, Y g:ia", strtotime($notice['date']));
    $tableRow = '';
    $tableRow .= "
                <h5 class='card-body-title'>{$notice['title']}</h5> <p>visiable to : {$notice['visibility']}</p>
                <p class='card-subtitle tx-normal mg-b-15'> uploaded at : {$formattedDate}</p>
                <p class='card-text'>Notice Uploaded By: {$uploadedby}</p>
                <p class='card-text'>{$notice['description']}</p>
                ";
    $pages =  [
        ['url' => 'dashboard.php', 'label' => 'Dashboard'],
        ['url' => 'notice.php', 'label' => 'Notice'],
        ['url' => "notice.php?id={$notice['notice_id']}", 'label' => "{$notice['title']}"]
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
$notices_all = $databaseHandler->getNotices();
$tableRows = '';
foreach ($notices_all as $notices) {
    $formattedDate = date("g:ia M d, Y", strtotime($notices['date']));
    $tableRows .= "<tr>
        <td class='wp-10p tx-center' data-sort='{$notices['date']}'>{$formattedDate}</td>
        <td class='wp-15p'>
            <a href=\"notice.php?id={$notices['notice_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$notices['title']}</a>
        </td>
        <td class='wd-10p tx-center'>{$notices['visibility']}</td>
        
    </tr>";
}
$content .= "
<div class='card pd-20 pd-sm-40'>
    <h6 class='card-body-title'>Notices</h6>
    <div class='table-wrapper'>
        <table id='datatable1' class='table display responsive nowrap'>
            <thead>
                <tr> 
                    <th class='wd-10p tx-center'>Published at</th>
                    <th class='wd-15p'>Title</th>
                    <th class='wd-10p tx-center''>Visiable</th>
                   

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

  });";


include '../templates/base.php';
