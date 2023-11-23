<?php

$pageTitle = "Admin Dashboard";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
];
$content = '<div class="card pd-20 pd-sm-40">
<h6 class="card-body-title">View Users</h6>
<div class="table-wrapper">
  <table id="datatable1" class="table display responsive nowrap">
    <thead>
      <tr>
        <th class="wd-15p">First name</th>
        <th class="wd-15p">Last name</th>
        <th class="wd-20p">Position</th>
        <th class="wd-15p">Start date</th>
        <th class="wd-10p">Salary</th>
        <th class="wd-25p">E-mail</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Tiger</td>
        <td>Nixon</td>
        <td>System Architect</td>
        <td>2011/04/25</td>
        <td>$320,800</td>
        <td>t.nixon@datatables.net</td>
      </tr>
      <tr>
        <td>Garrett</td>
        <td>Winters</td>
        <td>Accountant</td>
        <td>2011/07/25</td>
        <td>$170,750</td>
        <td>g.winters@datatables.net</td>
      </tr>
    </tbody>
  </table>
</div><!-- table-wrapper -->
</div><!-- card -->
';

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
