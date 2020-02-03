<?php

require_once 'core/init.php';
if(Session::exists('home')){
  echo '<p>' . Session::flash('home') . '</p>';
}

//current user - initiates user class
$user = new User();
?>

<header id="header" class="hoc clear">
  <div id="logo" class="fl_left">
    <h1><a href="index.php">Computer Science Room Booking System</a></h1>

  </div>
  <!-- Banner of Links -->
  <nav id="mainav" class="fl_right">
    <ul class="clear">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a class="drop" href="rooms.php">Rooms</a>
        <ul>
          <li><a href="timetable.php">Timetable</a></li>
          <li><a href="gracehopper.php">Grace Hopper Computer Lab</a></li>
          <li><a href="timberners-lee.php">Tim Berners-Lee Computer Lab</a></li>
          <li><a href="charlesbabbage.php">Charles Babbage Computer Lab</a></li>
          <li><a href="maths3.php">Maths 3</a></li>
        </ul>
      </li>
      <?php
      // checks if the a user is logged in and gives a different set of links for a user
      if ($user->isLoggedIn()) {

        $userType = $user->data()->groupid;
        $userName = $user->data()->username;

        echo "<li><a class='drop' href='#'>Bookings</a>";
          echo "<ul>";
            echo "<li><a href='bookaroom.php'>Book a Room</a></li>";
            echo "<li><a href='managebookings.php'>Manage Bookings</a></li>";
            if ($user->hasPermission('admin')) {
              echo "<li><a href='userbookings.php'> Manage All User Bookings </a></li>";
            }
          echo "</ul>";
        echo "</li>";

        echo "<li><a class='drop' href='#'>Account</a>";
          echo "<ul>";
            echo "<li><a href='profile.php'>Profile</a></li>";

            // if the user has admin permissions - more links are displayed for more functionality
            if ($user->hasPermission('admin')) {
              echo "<li><a href='usermanager.php'>Manage All Users</a></li>";
            }
            echo "<li><a href='changepassword.php'>Change Password</a></li>";
            echo "<li><a href='update.php'>Change Account Details</a></li>";
          echo "</ul>";
        echo "</li>";

        echo "<li><a href='logout.php'>Logout</a></li>";
      } else {

        // if no user is logged in - they are given option to register or login
        echo "<li><a href='register.php'>Register</a></li>";
        echo "<li><a href='login.php'>Login</a></li>";

      }

      ?>
    </ul>
  </nav>
</header>
