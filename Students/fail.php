
<?php

$pageTitle = "Payment failed";
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
          <p>Payment Failed Due to some uunavoidable circumstances</p>
    </div>
    </div><!-- col-4 --> 
</div><!--row-4-->
</div>
";

$script = "
";


include '../templates/base.php';
