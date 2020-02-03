<?php
// initialisation file
require_once 'core/init.php';
  // check if there is any input
  if (Input::exists()){
    // checks for a token and retrieves it
    if (Token::check(Input::get('token'))){
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        // specific validation rules for the fields of the forms
        'username' => array(
          'name' => 'Username',
          'required' => true,
          'min' => 2,
          'max' => 20,
          'unique' => 'users'
        ),
        'email' => array(
          'required' => true,
          'min' => 7
        ),
        'password' => array(
          //also could add strengh password factor built into this class
          'required' => true,
          'min' => 6
        ),
        'password_again' => array(
          'required' => true,
          'matches' => 'password'
        ),
        'name' => array(
          'required' => true,
          'min' => 2,
          'max' => 50
        ),
      ));

      // checks if all the fields are validated
      if($validation->passed()){
        //register user
        $user = new User();
        // generates a new salt to be added to hash
        $salt = Hash::salt(32);

        try {
          // user is being created and data being inserted into the user, db class
          $user->create(array(
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password'), $salt),
            'salt' => $salt,
            'name' => Input::get('name'),
            'joined' => date('Y-m-d H:i:s'),
            'groupid' => 1

          ));

          //redirects to homepage once register is complete
          Redirect::to('index.php');

        }

          catch(Exception $e){
          // change to more user friendly later // maybe redirect and show message
          die($e->getMessage());

        }

      } else {
        //outputs errors of validation
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







<!--
//escape function = sanitizing the form for security
//use of opening php is for getting the previous entered name/username if password dont make (reduces time)
-->


<html>
<head>
<title>Register</title>
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
        <li><a href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content">
      <h1>Register Here</h1>

      <div id="comments">

        <form action="" method="post">
          <div class="field">
            <label for="username"> Username </label>
            <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
          </div>

          <div class="field">
            <label for="email"> Email </label>
            <input type="email" name="email" id="email" value="<?php echo escape(Input::get('email'));?>" autocomplete="off">
          </div>

          <div class="field">
            <label for="password"> Choose a password </label>
            <input type="password" name="password" id="password">
          </div>

          <div class="field">
            <label for="password_again"> Enter your password again </label>
            <input type="password" name="password_again" id="password_again">
          </div>

          <div class="field">
            <label for="name"> Your Name </label>
            <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name'));?>">
          </div>

          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          <input type="submit" value="Register">
        </form>
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
