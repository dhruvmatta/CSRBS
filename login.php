<?php
require_once 'core/init.php';

if(Input::exists()){
  if(Token::check(Input::get('token'))){

    // check validation of username and password if they match criteria
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('required' => true),
      'password' => array('required' => true),
    ));

    // if all the validation of fields is correct
    if($validation->passed()){
      $user = new User();

      // set variable remember to boolean value of true if check box is checked if not then set false
      $remember = (Input::get('remember') === 'on') ? true : false;
      $login = $user->login(Input::get('username'), Input::get('password'), $remember);

      // check if the users username and encryted password matches the corrcect user details in the 'user' table in the database
      if ($login){
        // redirect user to logged in homepage if details are correct
        Redirect::to('index.php');

      } else {

        //output the error since user failed to meet criteria of logging in
        ?>
        <script>
        alert('Sorry, login failed.');
        </script>
        <?php

      }

    } else {

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
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content">
      <br><br><br>
      <h1>Login Here</h1>

      <div id="comments">

        <form action="" method="post">

          <div class="field">
            <!-- User Input of Username -->
            <label for="username"> Username </label>
            <input type="text" name="username" id="username" autocomplete="off">
          </div>

          <div class="field">
            <!-- User Input of Password -->
            <label for="password"> Password </label>
            <input type="password" name="password" id="password" autocomplete="off">
          </div>

          <div class="field">
            <label for="remember">
              <!-- check box if user wants to remember -->
              <input type="checkbox" name="remember" id="remember"> Remember Me
            </label>
          </div>
          <!-- Token::generate() = creating a token  -->
          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          <input type="submit" value="Log in">
        </form>
        <br><br><br>
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
