<?php
// initialisation
require_once 'core/init.php';

// user initialised
$user = new User();

// if no user is logged in, page is redirected to the homepage
if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

// if there is any input by the user, page checks for a token
if (Input::exists()) {
  if (Token::check(Input::get('token'))) {

    // if a token exists, the validation class is initialised
    // and the input fields are checked for its validation
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'password_current' => array(
        'required' => true,
        'min' => 6
      ),
      'password_new' => array(
        'required' => true,
        'min' => 6
      ),
      'password_new_again' => array(
        'required' => true,
        'min' => 6,
        'matches' => 'password_new'
      )
    ));

    // if all the validation is passed
    // the current password is checked if it matches the password in the db after it being hashed with the current salt
    if ($validation->passed()) {
      if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
        echo 'Your current password is wrong';
      } else{

        // if current password is correct, a new salt is generated and is stored as a variable
        // the new password is hashed with the salt created
        $salt = Hash::salt(32);
        $user->update(array(
          'password' => Hash::make(Input::get('password_new'), $salt),
          'salt' => $salt
        ));

        // page is to homepage
        Redirect::to('index.php');

      }

    } else {
      // errors are outputted if the validation isn't correct
      ?>

      <script>
      alert('<?php foreach ($validation->errors() as $error) {

      echo  " " . $error . " |";

      }?>');
      </script>

      <?php
    }


  }
}

?>

<?php
require_once 'core/init.php';

$user = new User();

// curent user details are stored
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
<title>Change Password</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="content">
      <div class="roomtitle">
        <h1>Change Password</h1>
      </div>
      <!-- User's Name is outputted -->
      <p> <?php echo "Hello, " . $fullName . "!" . "<br>"; ?></p>
      <div id="comments">
        <!-- Form for password update is displayed -->
        <form action="" method="post">
          <div class="field">
            <label for="password_current"> Current password </label>
            <input type="password" name="password_current" id="password_current">
          </div>

          <div class="field">
            <label for="password_new"> New password </label>
            <input type="password" name="password_new" id="password_new">
          </div>

          <div class="field">
            <label for="password_new_again"> New password again</label>
            <input type="password" name="password_new_again" id="password_new_again">
          </div>


          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          <input type="submit" value="Change">

        </form>
      </div>
    </div>
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
