<?php

require_once 'core/init.php';

$user = new User();
// if no user is walked in, redirected to homepage
if (!$user->isLoggedIn()) {
  Redirect::to('index.php');

}

if (Input::exists()) {
  if (Token::check(Input::get('token'))) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'name' => array(
        // validation rules for fields in form
        'required' => true,
        'min' => 2,
        'max' => 50
      ),

      'email' => array(
        'min' => 2,
        'max' => 100
      )

    ));
    if ($validation->passed()) {
      try {
        // details are updated in user table if validation is passed
        $user->update(array(
          'name' => Input::get('name'),
          'email' => Input::get('email')
        ));

        // redirect to homepage
        Session::flash('home', 'Your details have been updated.');
        Redirect::to('index.php');

      } catch (Exception $e) {
        die($e->getMessage());
      }



    } else {
      // output all errors
      foreach ($validation->errors() as $error) {
        echo  " " . $error . " |";
      }
    }
  }
}

?>




<?php



require_once 'core/init.php';

$user = new User();
$username = $user->data()->username;
$fullName = $user->data()->name;
$email = $user->data()->email;



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
<title>Change Account Details</title>
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
        <li><a href="changepassword.php">Change Account Details</a></li>
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
        <h1>Change Account Details</h1>
      </div>

      <p> <?php echo "Hello, " . $fullName . "!" . "<br>"; ?></p>
      <div id="comments">
        <form method="post" action="">
          <div class="field">
            <label for="name"> Name </label>
            <input type="text" name="name" value="<?php echo escape($user->data()->name) ?>">

            <br>
            <label for="email"> Email </label>
            <input type="text" name="email" value="<?php echo escape($user->data()->email) ?>">

            <br>
            <input type="submit" value="Update">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          </div>
        </form>
      </div>
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
