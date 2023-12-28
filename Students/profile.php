<?php

$pageTitle = "Profile";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'profile.php', 'label' => 'Profile'],

];



$content ='';
$content .= '
<section class="section profile">
  <div class="row">
      <div class="col-xl-4">

          <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                  <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                  <h2>Kevin Anderson</h2>
              </div>
          </div>
      </div>
      <div class="col-xl-8">
          <div class="card">
              <div class="card-body pt-3">
                  <!-- Bordered Tabs -->
                  <ul class="nav nav-tabs nav-tabs-bordered">
                      <li class="nav-item">
                          <button class="nav-link active" data-bs-toggle="tab"
                              data-bs-target="#profile-overview">Overview</button>
                      </li>
                      <li class="nav-item">
                          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                              Profile</button>
                      </li>
                      <li class="nav-item">
                          <button class="nav-link" data-bs-toggle="tab"
                              data-bs-target="#profile-change-password">Change Password</button>
                      </li>
                  </ul>
                  <div class="tab-content pt-2">
                      <div class="tab-pane fade show active profile-overview" id="profile-overview">

                          <h5 class="card-title">About</h5>
                          <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores
                              cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure
                              rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at
                              unde.</p>
                          <h5 class="card-title">Profile Details</h5>
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label ">Name</div>
                              <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                          </div>
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label">Role</div>
                              <div class="col-lg-9 col-md-8">Web Designer</div>
                          </div>
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label">Address</div>
                              <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                          </div>
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label">Phone</div>
                              <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                          </div>
                          <div class="row">
                              <div class="col-lg-3 col-md-4 label">Email</div>
                              <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                          </div>
                      </div>

                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                          <form id="profile-edit-form">
                              <div class="row mb-3">
                                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                      Image</label>
                                  <div class="col-md-8 col-lg-9">
                                      <img src="assets/img/profile-img.jpg" alt="Profile">
                                      <div class="pt-2">
                                          <a href="#" class="btn btn-primary btn-sm"
                                              title="Upload new profile image"><i class="fa fa-upload"></i></a>
                                          <a href="#" class="btn btn-danger btn-sm"
                                              title="Remove my profile image"><i class="fa fa-trash"></i></a>
                                      </div>
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="fullName" type="text" class="form-control" id="fullName"
                                          value="Kevin Anderson">
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                  <div class="col-md-8 col-lg-9">
                                      <textarea name="about" class="form-control" id="about"
                                          style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                                  </div>
                              </div>

                              <div class="row mb-3">
                                  <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="job" type="text" class="form-control" id="Job"
                                          value="Web Designer" disabled>
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="address" type="text" class="form-control" id="Address"
                                          value="A108 Adam Street, New York, NY 535022">
                                  </div>
                              </div>

                              <div class="row mb-3">
                                  <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="phone" type="text" class="form-control" id="Phone"
                                          value="(436) 486-3538 x29071">
                                  </div>
                              </div>

                              <div class="row mb-3">
                                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="email" type="email" class="form-control" id="Email"
                                          value="k.anderson@example.com">
                                  </div>
                              </div>

                              <div class="text-center">
                                  <button type="submit" class="btn btn-primary">Save Changes</button>
                              </div>
                          </form><!-- End Profile Edit Form -->

                      </div>
                      <div class="tab-pane fade pt-3" id="profile-change-password">
                          <!-- Change Password Form -->
                          <form  id="change-password-form"> 
                              <div class="row mb-3">
                                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                      Password</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="password" type="password" class="form-control"
                                          id="currentPassword">
                                  </div>
                              </div>

                              <div class="row mb-3">
                                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                      Password</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="newpassword" type="password" class="form-control"
                                          id="newPassword">
                                  </div>
                              </div>

                              <div class="row mb-3">
                                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                      Password</label>
                                  <div class="col-md-8 col-lg-9">
                                      <input name="renewpassword" type="password" class="form-control"
                                          id="renewPassword">
                                  </div>
                              </div>

                              <div class="text-center">
                                  <button type="submit" class="btn btn-primary">Change Password</button>
                              </div>
                          </form><!-- End Change Password Form -->

                      </div>

                  </div><!-- End Bordered Tabs -->

              </div>
          </div>

      </div>
  </div>
</section>
';


$script = '
$(document).ready(function () {
  $(".nav-link").click(function () {
      $(".tab-pane").removeClass("show active");
      var targetId = $(this).data("bs-target");
      $(targetId).addClass("show active");
  });
  // Event listener for the first form (profile-edit)
  $("#profile-edit-form").submit(function (event) {
      event.preventDefault();

      // Get form data
      var formData = {
          action: "edit-profile",
          fullName: $("#fullName").val(),
          about: $("#about").val(),
          // Add other form fields as needed
      };

      // Send an AJAX request for the first form
      $.ajax({
          type: "POST",
          url: "process.php", // Replace with the actual path to your PHP script
          data: formData,
          dataType: "json",
          success: function (response) {
              // Handle the response from the server
              console.log(response);
              // You can perform further actions based on the response
          },
          error: function (error) {
              console.error("Error:", error);
          }
      });
  });

  // Event listener for the second form (change-password)
  $("#change-password-form").submit(function (event) {
      event.preventDefault();

      // Get form data
      var formData = {
          action: "change-password",
          currentPassword: $("#currentPassword").val(),
          newPassword: $("#newPassword").val(),
          renewPassword: $("#renewPassword").val()
      };

      // Send an AJAX request for the second form
      $.ajax({
          type: "POST",
          url: "process.php", // Replace with the actual path to your PHP script
          data: formData,
          dataType: "json",
          success: function (response) {
              // Handle the response from the server
              console.log(response);
              // You can perform further actions based on the response
          },
          error: function (error) {
              console.error("Error:", error);
          }
      });
      
});
';



include '../templates/base.php';
