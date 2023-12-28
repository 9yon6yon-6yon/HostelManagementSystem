<?php


$pageTitle = "Admin Profile";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'profile.php', 'label' => 'Profile'],
]; 

$content = "
<section class='section profile'>
    <div class='row'>
        <div class='col-xl-4'>
            <div class='card'>
                <div class='card-body profile-card pt-4 d-flex flex-column align-items-center'>
                    <img id='user-profile-pic' alt='Profile' width='30%'>
                    <h2 id='user-name'></h2>
                </div>
            </div>
        </div>
        <div class='col-xl-8'>
            <div class='card'>
                <div class='card-body pt-3'>
                    <!-- Bordered Tabs -->
                    <ul class='nav nav-tabs nav-tabs-bordered'>
                        <li class='nav-item'>
                            <button class='nav-link active' data-bs-toggle='tab'
                                data-bs-target='#profile-overview'>Overview</button>
                        </li>
                        <li class='nav-item'>
                            <button class='nav-link' data-bs-toggle='tab' data-bs-target='#profile-edit'>Edit
                                Profile</button>
                        </li>
                        <li class='nav-item'>
                            <button class='nav-link' data-bs-toggle='tab'
                                data-bs-target='#profile-change-password'>Change Password</button>
                        </li>
                    </ul>
                    <div class='tab-content pt-2'>
                        <div class='tab-pane fade show active profile-overview' id='profile-overview'>
                            <h5 class='card-title'>About</h5>
                            <p class='small fst-italic' id='user-about'></p>

                            <h5 class='card-title'>Profile Details</h5>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Name</div>
                                <div class='col-lg-9 col-md-8' id='user-name-copy'></div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Role</div>
                                <div class='col-lg-9 col-md-8' id='user-role'></div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Address</div>
                                <div class='col-lg-9 col-md-8' id='user-address'></div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Phone</div>
                                <div class='col-lg-9 col-md-8' id='user-phone'></div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Email</div>
                                <div class='col-lg-9 col-md-8' id='user-mail'></div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-3 col-md-4 label'>Status</div>
                                <div class='col-lg-9 col-md-8' id='user-verified'></div>
                            </div>
                        </div>

                        <div class='tab-pane fade profile-edit pt-3' id='profile-edit'>
                        <form id='profile-edit-form'>
                            <div class='row mb-3'>
                                <label for='profileImage' class='col-md-4 col-lg-3 col-form-label'>Profile Image</label>
                                <div class='col-md-8 col-lg-9'>
                                    <img id='user-profile-pic-2' src='../assets/images/hero.jpg' alt='Profile' width='30%'>
                                    <div class='pt-2'>
                                        <a href='#' class='btn btn-primary btn-sm' title='Upload new profile image'><i class='fa fa-upload'></i></a>
                                        <a href='#' class='btn btn-danger btn-sm' title='Remove my profile image'><i class='fa fa-trash'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='fullName' class='col-md-4 col-lg-3 col-form-label'>Full Name</label>
                                <div class='col-md-8 col-lg-9'>
                                    <input name='fullName' type='text' class='form-control' id='fullName'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='about' class='col-md-4 col-lg-3 col-form-label'>About</label>
                                <div class='col-md-8 col-lg-9'>
                                    <textarea name='about' class='form-control' id='user-about_me' style='height: 100px'></textarea>
                                </div>
                            </div>
                    
                            <!-- Additional Fields -->
                            <div class='row mb-3'>
                                <label for='Role' class='col-md-4 col-lg-3 col-form-label'>Role</label>
                                <div class='col-md-8 col-lg-9'>
                                    <input name='role' type='text' class='form-control' id='Role' disabled>
                                </div>
                            </div>
                            <div class='row mb-3'>
                            <label for='Address' class='col-md-4 col-lg-3 col-form-label'>Address</label>
                            <div class='col-md-8 col-lg-9'>
                                <input name='address' type='text' class='form-control' id='Address'>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <label for='Phone' class='col-md-4 col-lg-3 col-form-label'>Phone</label>
                            <div class='col-md-8 col-lg-9'>
                                <input name='phone' type='text' class='form-control' id='Phone'>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <label for='Gender' class='col-md-4 col-lg-3 col-form-label'>Gender</label>
                            <div class='col-md-8 col-lg-9'>
                                <select name='gender' class='form-control' id='Gender'>
                                    <option value='Male'>Male</option>
                                    <option value='Female'>Female</option>
                                    <option value='Other'>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <label for='DateOfBirth' class='col-md-4 col-lg-3 col-form-label'>Date of Birth</label>
                            <div class='col-md-8 col-lg-9'>
                                <input name='dateOfBirth' type='date' class='form-control' id='DateOfBirth'>
                            </div>
                        </div>
                           
                    
                            <div class='text-center'>
                                <button type='submit' class='btn btn-primary'>Save Changes</button>
                            </div>
                        </form><!-- End Profile Edit Form -->
                    </div>
                    
                        <div class='tab-pane fade pt-3' id='profile-change-password'>
                            <!-- Change Password Form -->
                            <form id='change-password-form'>
                                <div class='row mb-3'>
                                    <label for='currentPassword' class='col-md-4 col-lg-3 col-form-label'>Current
                                        Password</label>
                                    <div class='col-md-8 col-lg-9'>
                                        <input name='password' type='password' class='form-control'
                                            id='currentPassword'>
                                    </div>
                                </div>

                                <div class='row mb-3'>
                                    <label for='newPassword' class='col-md-4 col-lg-3 col-form-label'>New
                                        Password</label>
                                    <div class='col-md-8 col-lg-9'>
                                        <input name='newpassword' type='password' class='form-control'
                                            id='newPassword'>
                                    </div>
                                </div>

                                <div class='row mb-3'>
                                    <label for='renewPassword' class='col-md-4 col-lg-3 col-form-label'>Re-enter New
                                        Password</label>
                                    <div class='col-md-8 col-lg-9'>
                                        <input name='renewpassword' type='password' class='form-control'
                                            id='renewPassword'>
                                    </div>
                                </div>

                                <div class='text-center'>
                                    <button type='submit' class='btn btn-primary'>Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
";


$script = "

$(document).ready(function () {
    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: { action: 'load-user' },
        dataType: 'json',
        success: function (response) {
            if (response) {
                $('#user-name').text(response.name);
                $('#user-name-copy').text(response.name);
                $('#fullName').val(response.name);
                $('#user-profile-pic').attr('src', response.profile_pic_path);
                $('#user-profile-pic-2').attr('src', response.profile_pic_path);
                $('#user-phone').text(response.phone_number);
                $('#user-address').text(response.address);
                $('#user-mail').text(response.mail);
                $('#user-role').text(response.role);
                $('#Role').val(response.role);
                $('#user-verified').text((response.verified ? 'Verified' : 'Not Verified'));
                $('#user-date_of_birth').text(response.date_of_birth);
                $('#user-gender').text(response.gender);
                $('#user-nationality').text(response.nationality);
                $('#user-emergency_contact_name').text(response.emergency_contact_name);
                $('#user-emergency_contact_phone').text(response.emergency_contact_phone);
                $('#user-medical_conditions').text(response.medical_conditions);
                $('#user-hobbies').text(response.hobbies);
                $('#user-about_me').text(response.about_me);
                $('#Address').val(response.address);
                $('#Phone').val(response.phone_number);
            
                $('#Gender').val(response.gender); 
                $('#DateOfBirth').val(response.date_of_birth); 
            } else {
                showAlert('error', 'No user data found.');
            }
        },

    });

    $('.nav-link').click(function () {
        $('.tab-pane').removeClass('show active');
        var targetId = $(this).data('bs-target');
        $(targetId).addClass('show active');
    });

});
$('#profile-edit-form').submit(function (event) {
    event.preventDefault();

    // Get form data
    var formData = {
        action: 'edit-profile',
        fullName: $('#fullName').val(),
        about: $('#about').val(),
        // Add other form fields as needed
    };

    // Send an AJAX request for the first form
    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                showAlert('success', response.success);
            } else if (response.error) {
                showAlert('error', response.error);
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

// Event listener for the second form (change-password)
$('#change-password-form').submit(function (event) {
    event.preventDefault();

    // Get form data
    var formData = {
        action: 'change-password',
        currentPassword: $('#currentPassword').val(),
        newPassword: $('#newPassword').val(),
        renewPassword: $('#renewPassword').val()
    };
    if (!formData.currentPassword || !formData.newPassword || !formData.renewPassword) {
        showAlert('warning', 'Please fill in all required fields.');
        return;
    }

    if (formData.newPassword !== formData.renewPassword) {
        showAlert('warning', 'Password and confirm password do not match.');
        return;
    };

    // Send an AJAX request for the second form
    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                showAlert('success', response.success);
            } else if (response.error) {
                showAlert('error', response.error);
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });

});


";
include('../templates/base.php');
