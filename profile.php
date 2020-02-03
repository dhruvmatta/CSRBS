<?php
// initialises connection
require_once 'core/init.php';

// User class
// current user data is stored in variables
$user = new User();
$username = $user->data()->username;
$fullName = $user->data()->name;
$email = $user->data()->email;
$permissions = $user->data()->groupid;
  // the users permissions are stored as a string
  if ($permissions == 2) {
    $permissions = 'Administrator';
  } else {
    $permissions = 'User';
  }


?>


<!DOCTYPE html>
<!--
Template Name: Geodarn
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->



<html>
<head>
<title>Profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
	<?php
    $user = new User;
    if (!$user->isLoggedIn()) {
       Redirect::to('index.php');
    }
	?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content">
      <div class="roomtitle">
        <h1>Profile Details</h1>
      </div>
      <!-- Current User's details are outputted -->
      <p> <?php echo "Name: " . $fullName . "!" . "<br>"; ?></p>
      <p> <?php echo "Username: " . $username; ?> </p>
      <p> <?php echo "Email: " . $email; ?> </p>
      <p> <?php echo "Permissions: " . $permissions; ?> </p>

      <a href="changepassword.php"> Change Your Password </a>

    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<?php include 'footer.php'; ?>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
