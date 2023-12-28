<?php
require_once('../Admin/DatabaseHandler.php');
$pageTitle = "Student Dashboard";

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
    </tr>";
}
$content = "
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-sm-6 col-xl-4\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"icon ion-compose mg-r-10\"></i>Book
                    Seat</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card bg-purple tx-white pd-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-lato tx-center mg-b-15\"><i class=\"fa fa-recycle mg-r-10\"></i>Renew Seat</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"fa fa-ban mg-r-10\"></i>Cancel Seat
                </h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
</div><!-- row -->
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-sm-6 col-xl-4\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"icon ion-clipboard mg-r-10
                        \"></i>Booking History</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card bg-purple tx-white pd-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-lato tx-center mg-b-15\"><i class=\"fa fa-refresh mg-r-10\"></i>Renew History</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"fa fa-reply mg-r-10\"></i>Cancel
                    History</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->

</div><!-- row -->
<div class=\"row row-sm mg-t-20\">
    <div class=\"col-sm-6 col-xl-4\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"fa fa-credit-card mg-r-10\"></i>Pay Online
                </h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card bg-purple tx-white pd-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-white-8 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-lato tx-center mg-b-15\"><i class=\"fa fa-clock-o mg-r-10\"></i>Payment History</h2>
            </div><!-- card -->
        </a>
    </div><!-- col-3 -->
    <div class=\"col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0\">
        <a href=\"application.php\" class=\"card-link\">
            <div class=\"card pd-20 pd-sm-25\">
                <div class=\"d-flex align-items-center justify-content-between mg-b-10\">
                    <h6 class=\"card-body-title tx-12 tx-spacing-1\">icon</h6>
                </div><!-- d-flex -->
                <h2 class=\"tx-purple tx-lato tx-center mg-b-15\"><i class=\"fa fa-home mg-r-10\"></i>Room Details
                </h2>
            </div><!-- card -->
        </a>
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
                    </tr>
                </thead>
                <tbody>
                    $tableRows    
                </tbody>
            </table>
            <div class=\"card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200\">
                <a href=\"notices.php\"><i class=\"fa fa-angle-down mg-r-5\"></i>View All Notices</a>
            </div><!-- card-footer -->
        </div><!-- card -->
    </div><!-- col-6 -->
</div><!-- row -->
";


$script = "";


include '../templates/base.php';