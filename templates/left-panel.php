 <!-- ########## START: LEFT PANEL ########## -->
 <div class="sl-logo"><a href="#"><i class="icon ion-android-star-outline"></i> City Hall</a></div>
 <div class="sl-sideleft">
   <div class="input-group input-group-search">
     <input type="search" name="search" class="form-control" placeholder="Search">
     <span class="input-group-btn">
       <button class="btn"><i class="fa fa-search"></i></button>
     </span><!-- input-group-btn -->
   </div><!-- input-group -->

   <label class="sidebar-label">Menu</label>

   <div class="sl-sideleft-menu">
     <?php
      session_start();
      $userRole = isset($_SESSION['userRole']) ? $_SESSION['userRole'] : null;

      // Check user role and include corresponding menu items
      switch ($userRole) {
        case 'admin':
          include('admin-menu.php'); // Assuming you have a file with admin menu items
          break;
        case 'student':
          include('student-menu.php'); // Assuming you have a file with student menu items
          break;
        case 'accounts':
          include('accounts-menu.php'); // Assuming you have a file with accounts menu items
          break;
        case 'hallsuper':
          include('hallsuper-menu.php'); // Assuming you have a file with hallsuper menu items
          break;
        case 'provost':
          include('provost-menu.php'); // Assuming you have a file with provost menu items
          break;
        default:
          // Handle the case when the user role is not recognized
          echo '<p>User role not recognized.</p>';
      }
      ?>
   </div><!-- sl-sideleft-menu -->

   <br>
 </div><!-- sl-sideleft -->
 <!-- ########## END: LEFT PANEL ########## -->