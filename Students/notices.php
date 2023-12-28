<?php
require('../Admin/DatabaseHandler.php');
$pageTitle = "Notice";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'notices.php', 'label' => 'Notice'],

];

$databaseHandler = new DatabaseHandler();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $notice = $databaseHandler->getNotice($id);
    $formattedDate = date("M d, Y g:ia", strtotime($notice['date']));
    $tableRow = '';
    $tableRow .= "
                <h5 class='card-body-title'>{$notice['title']}</h5>
                <p class='card-subtitle tx-normal mg-b-15'> uploaded at : {$formattedDate}</p>
               
                <p class='card-text'>{$notice['description']}</p>
                <a href='#' class='card-link'>Aurthor</a>
              
                ";
    $pages =  [
        ['url' => 'dashboard.php', 'label' => 'Dashboard'],
        ['url' => 'notices.php', 'label' => 'Notice'],
        ['url' => "notices.php?id={$notice['notice_id']}", 'label' => "{$notice['title']}"]
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
    $formattedDate = date("M d, Y g:ia", strtotime($notices['date']));
    $tableRows .= "<tr>
        <td class='wd-5p tx-center'>{$notices['notice_id']}</td>
        <td>
            <a href=\"notices.php?id={$notices['notice_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$notices['title']}</a>
        </td>
        <td class='tx-center'>{$formattedDate}</td>
    </tr>";
}
$content .= "
<div class='card pd-20 pd-sm-40'>
    <h6 class='card-body-title'>Notices</h6>
    <div class='table-wrapper'>
        <table id='datatable1' class='table display responsive nowrap'>
            <thead>
                <tr>
                    <th class='wd-5p'>ID</th>
                    <th class='wd-15p'>Title</th>
                    <th class='wd-15p tx-center'>Published at</th>

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
