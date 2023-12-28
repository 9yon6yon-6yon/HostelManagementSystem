<?php
require('DatabaseHandler.php');
$pageTitle = "Admin Dashboard";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
];
$databaseHandler = new DatabaseHandler();
$notices = $databaseHandler->getNotices();
$tabeRows = '';
foreach ($notices as $notice) {
    $formattedDate = date("M d, Y g:ia", strtotime($notice['date']));

    $tableRows .= "<tr>
        <td class='wd-15p'>{$formattedDate}</td>
        <td class='wd-15p'>
            <a href=\"notice.php?id={$notice['notice_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$notice['title']}</a>
        </td>
        <td class='wd-15p tx-right'>{$notice['visibility']}</td>

      
    </tr>";
}

$rolesData = $databaseHandler->getRolesCountWithTotalUsers();
$roles = $rolesData['roles'];
$count = $rolesData['count'];
$total_users = $rolesData['totalUsers'];
$applicationData = $databaseHandler->getApplicationTypesCount();
$applicationTypes = $applicationData['applicationTypes'];
$applicationCount = $applicationData['count'];
$applicationpending = $applicationData['totalcount'];

$content = "
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-sm-6 col-xl-4\">
        <a href=\"viewusers.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">Total number of users</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"icon ion-person-stalker mg-r-10\"></i>{$total_users}</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0\">
        <a href=\"applications.php\" class=\"card-link\">
            <div class=\"card bg-purple tx-white pd-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">Number of application pending</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-lato tx-center mg-b-15\"><i class=\"icon ion-clipboard mg-r-10\"></i>{$applicationpending}</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0\">
        <a href=\"announce.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">Make an announcement</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"fa fa-microphone mg-r-10\"></i>Announce
                </h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
</div><!-- row -->
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-lg-12 mg-t-20 mg-lg-t-0\">
        <div class=\"card\">
            <div class=\"card-header pd-20 bg-transparent bd-b bd-gray-200\">
                <h6 class=\"card-title tx-uppercase tx-12 mg-b-0\">Notices</h6>
            </div><!-- card-header -->
            <table class=\"table table-white table-responsive mg-t-20 mg-lg-t-0 tx-12\">
                <thead>
                    <tr class=\"tx-10\">
                        <th class=\"wd-15p pd-y-15\">Date</th>
                        <th class=\"wd-15p pd-y-15\">Title</th>
                        <th class=\"wd-15p pd-y-10 tx-right\">Visibility</th>
                    </tr>
                </thead>
                <tbody>
                    $tableRows    
                </tbody>
            </table>
            <div class=\"card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200\">
                <a href=\"notice.php\"><i class=\"fa fa-angle-down mg-r-5\"></i>View All Notices</a>
            </div><!-- card-footer -->
        </div><!-- card -->
    </div><!-- col-6 -->
</div><!-- row -->
";


$script = "";


include '../templates/base.php';
