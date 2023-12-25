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
        <td>{$formattedDate}</td>
        <td>
            <a href=\"notice.php?id={$notice['notice_id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$notice['title']}</a>
        </td>
        <td class=\"pd-y-5 tx-right\">{$notice['visibility']}</td>

      
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
    <div class=\"col-sm-6 col-xl-3\">
        <a href=\"viewusers.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">No. of Users</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\">$total_users</h2>
             
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3\">
        <a href=\"applications.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">No. of Pending Applications</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\">$applicationpending</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3\">
        <a href=\"viewusers.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">No. of Users</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\">$total_users</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3\">
        <a href=\"viewusers.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">No. of Users</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\">$total_users</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
</div><!-- row -->
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-sm-6 col-xl-3\">
        <div class=\"card pd-20 pd-sm-25\">
            <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                <h6 class=\"card-body-title tx-12 tx-spacing-1\">List</h6>
                <a href=\"viewusers.php\" class=\"tx-gray-600 hover-info\"><i class=\"icon ion-more\"></i></a>
            </div><!-- d-flex -->
            <h2 class=\"tx-purple tx-lato tx-center mg-b-15\">Show All User</h2>
        </div><!-- card -->
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0\">
        <div class=\"card bg-purple tx-white pd-25\">
            <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">Sales Revenue</h6>
                <a href=\"\" class=\"tx-white-8 hover-white\"><i class=\"icon ion-more\"></i></a>
            </div><!-- d-flex -->
            <h2 class=\"tx-lato tx-center mg-b-15\">$34,330</h2>
            <p class=\"mg-b-0 tx-12 op-8\">+ 6.2% compared last month</p>
        </div><!-- card -->
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0\">
        <div class=\"card pd-20 pd-sm-25\">
            <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                <h6 class=\"card-body-title tx-12 tx-spacing-1\">Sales Revenue</h6>
                <a href=\"\" class=\"tx-gray-600 hover-info\"><i class=\"icon ion-more\"></i></a>
            </div><!-- d-flex -->
            <h2 class=\"tx-teal tx-lato tx-center mg-b-15\">$34,330</h2>
            <p class=\"mg-b-0 tx-12\"><span class=\"tx-danger\">- 3.4%</span> compared last month</p>
        </div><!-- card -->
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0\">
        <div class=\"card bg-teal tx-white pd-25\">
            <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">Sales Revenue</h6>
                <a href=\"\" class=\"tx-white-8 hover-white\"><i class=\"icon ion-more\"></i></a>
            </div><!-- d-flex -->
            <h2 class=\"tx-lato tx-center mg-b-15\">$34,330</h2>
            <p class=\"mg-b-0 tx-12 op-8\">+ 6.2% compared last month</p>
        </div><!-- card -->
    </div><!-- col-3 -->
</div><!-- row -->

<div class=\"row row-sm mg-t-20\">
    <div class=\"col-lg-6\">
        <div class=\"card\">
            <div class=\"card-header bg-transparent pd-20 bd-b bd-gray-200\">
                <h6 class=\"card-title tx-uppercase tx-12 mg-b-0\">User Transaction History</h6>
            </div><!-- card-header -->
            <table class=\"table table-white table-responsive mg-b-0 tx-12\">
                <thead>
                    <tr class=\"tx-10\">
                        <th class=\"wd-10p pd-y-5\">&nbsp;</th>
                        <th class=\"pd-y-5\">User</th>
                        <th class=\"pd-y-5\">Type</th>
                        <th class=\"pd-y-5\">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"pd-l-20\">
                            <img src=\"../img/img1.jpg\" class=\"wd-36 rounded-circle\" alt=\"Image\">
                        </td>
                        <td>
                            <a href=\"\" class=\"tx-inverse tx-14 tx-medium d-block\">Mark K. Peters</a>
                            <span class=\"tx-11 d-block\">TRANSID: 1234567890</span>
                        </td>
                        <td class=\"tx-12\">
                            <span class=\"square-8 bg-success mg-r-5 rounded-circle\"></span> Email verified
                        </td>
                        <td>Just Now</td>
                    </tr>
                    <tr>
                        <td class=\"pd-l-20\">
                            <img src=\"../img/img2.jpg\" class=\"wd-36 rounded-circle\" alt=\"Image\">
                        </td>
                        <td>
                            <a href=\"\" class=\"tx-inverse tx-14 tx-medium d-block\">Karmen F. Brown</a>
                            <span class=\"tx-11 d-block\">TRANSID: 1234567890</span>
                        </td>
                        <td class=\"tx-12\">
                            <span class=\"square-8 bg-warning mg-r-5 rounded-circle\"></span> Pending verification
                        </td>
                        <td>Apr 21, 2017 8:34am</td>
                    </tr>
                    <tr>
                        <td class=\"pd-l-20\">
                            <img src=\"../img/img3.jpg\" class=\"wd-36 rounded-circle\" alt=\"Image\">
                        </td>
                        <td>
                            <a href=\"\" class=\"tx-inverse tx-14 tx-medium d-block\">Gorgonio Magalpok</a>
                            <span class=\"tx-11 d-block\">TRANSID: 1234567890</span>
                        </td>
                        <td class=\"tx-12\">
                            <span class=\"square-8 bg-success mg-r-5 rounded-circle\"></span> Purchased success
                        </td>
                        <td>Apr 10, 2017 4:40pm</td>
                    </tr>
                    <tr>
                        <td class=\"pd-l-20\">
                            <img src=\"../img/img5.jpg\" class=\"wd-36 rounded-circle\" alt=\"Image\">
                        </td>
                        <td>
                            <a href=\"\" class=\"tx-inverse tx-14 tx-medium d-block\">Ariel T. Hall</a>
                            <span class=\"tx-11 d-block\">TRANSID: 1234567890</span>
                        </td>
                        <td class=\"tx-12\">
                            <span class=\"square-8 bg-warning mg-r-5 rounded-circle\"></span> Payment on hold
                        </td>
                        <td>Apr 02, 2017 6:45pm</td>
                    </tr>
                    <tr>
                        <td class=\"pd-l-20\">
                            <img src=\"../img/img4.jpg\" class=\"wd-36 rounded-circle\" alt=\"Image\">
                        </td>
                        <td>
                            <a href=\"\" class=\"tx-inverse tx-14 tx-medium d-block\">John L. Goulette</a>
                            <span class=\"tx-11 d-block\">TRANSID: 1234567890</span>
                        </td>
                        <td class=\"tx-12\">
                            <span class=\"square-8 bg-pink mg-r-5 rounded-circle\"></span> Account deactivated
                        </td>
                        <td>Mar 30, 2017 10:30am</td>
                    </tr>
                </tbody>
            </table>
            <div class=\"card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200\">
                <a href=\"\"><i class=\"fa fa-angle-down mg-r-5\"></i>View All Transaction History</a>
            </div><!-- card-footer -->
        </div><!-- card -->
    </div><!-- col-6 -->
    <div class=\"col-lg-6 mg-t-20 mg-lg-t-0\">
        <div class=\"card\">
            <div class=\"card-header pd-20 bg-transparent bd-b bd-gray-200\">
                <h6 class=\"card-title tx-uppercase tx-12 mg-b-0\">Notices</h6>
            </div><!-- card-header -->
            <table class=\"table table-white table-responsive mg-b-0 tx-12\">
                <thead>
                    <tr class=\"tx-10\">
                        <th class=\"pd-y-5\">Date</th>
                        <th class=\"pd-y-5\">Title</th>
                        <th class=\"pd-y-5 tx-right\">Visibility</th>
                    </tr>
                </thead>
                <tbody>
                    $tableRows    
                </tbody>
            </table>
            <div class=\"card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200\">
                <a href=\"\"><i class=\"fa fa-angle-down mg-r-5\"></i>View All Notices</a>
            </div><!-- card-footer -->
        </div><!-- card -->
    </div><!-- col-6 -->
</div><!-- row -->
";


$script = "";


include '../templates/base.php';
