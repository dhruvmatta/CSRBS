<!-- Homepage / Start Page of Website -->
<html>
<head>
<title>CSRBS</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">

<?php
  // initialisation file
  require_once 'core/init.php';

  // check if there is a session existing called home and reinitialise it if it is
  if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
  }


  $user = new User(); //current user


 ?>
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php' ?>
  </div>
  <div id="pageintro" class="hoc clear">
    <div class="flexslider basicslider">
      <ul class="slides">
        <!-- Banner of rooms moving across the page -->
        <li>
          <article>
            <p>Room 1</p><br>
            <h3 class="heading">Grace Hopper Lab</h3>
            <p>Click below to view more details on the room</p>
            <footer><a class="btn inverse" href="gracehopper.php">View Room</a></footer>
          </article>
        </li>
        <li>
          <article>
            <p>Room 2</p><br>
            <h3 class="heading">Tim Berners-Lee Lab</h3>
            <p>Click below to view more details on the room</p>
            <footer><a class="btn inverse" href="timberners-lee.php">View Room</a></footer>
          </article>
        </li>
        <li>
          <article>
            <p>Room 3</p><br>
            <h3 class="heading">Charles Babbage Lab</h3>
            <p>Click below to view more details on the room</p>
            <footer><a class="btn inverse" href="charlesbabbage.php">View Room</a></footer>
          </article>
        </li>
        <li>
          <article>
            <p>Room 4</p><br>
            <h3 class="heading">Maths Room 3</h3>
            <p>Click below to view more details on the room</p>
            <footer><a class="btn inverse" href="maths3.php">View Room</a></footer>
          </article>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="btmspace-80 center">

      <?php
      // check if the user is logged in and outputs their name
      if ($user->isLoggedIn()) {
        ?>
        <h3> Hello,
        <?php echo $user->data()->name; ?>
        </h3> <?php
      }
      ?>

      <h3 class="nospace">Choose one of the following to view </h3>
    </div>
    <div class="mainbuttons">

      <?php
      // if user is logged in the buttons change
      if ($user->isLoggedIn()) {
        ?>

        <ul class="nospace group services">
          <li class="one_third first">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-lock"></i>
				  <h6 class="heading"><a href="managebookings.php">Manage Bookings</a></h6>
				  <p>Click here to manage your bookings.</p>
              </div>
              <footer><a href="managebookings.php">Manage Bookings &raquo;</a></footer>
            </article>
          </li>
          <li class="one_third">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-child"></i>
				  <h6 class="heading"><a href="rooms.php">Rooms</a></h6>
               <p>Click here to view the rooms of the department!</p>
              </div>
              <footer><a href="rooms.php">More &raquo;</a></footer>
            </article>
          </li>
          <li class="one_third">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-train"></i>
                <h6 class="heading"><a href="timetable.php">Timetable</a></h6>
                <p>Click here to view a timetable to book room</p>
              </div>
              <footer><a href="timetable.php">More &raquo;</a></footer>
            </article>
          </li>
        </ul>

        <?php
        // buttons for unlogged in user on homepage
      } else {
        ?>
        <ul class="nospace group services">
          <li class="one_third first">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-lock"></i>
				  <h6 class="heading"><a href="login.php">Login</a></h6>
                <p>Click here to login into your account</p>
              </div>
              <footer><a href="login.php">More &raquo;</a></footer>
            </article>
          </li>
          <li class="one_third">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-child"></i>
				  <h6 class="heading"><a href="rooms.php">Rooms</a></h6>
                <p>Click here to view the rooms of the department!</p>
              </div>
              <footer><a href="rooms.php">More &raquo;</a></footer>
            </article>
          </li>
          <li class="one_third">
            <article class="bgded overlay" style="background-image:url('images/gallery/lock.png');">
              <div class="txtwrap"><i class="block fa fa-4x fa-train"></i>
				  <h6 class="heading"><a href="register.php">Register</a></h6>
                <p>Click here to register yourself and to begin booking!</p>
              </div>
              <footer><a href="register.php">More &raquo;</a></footer>
            </article>
          </li>
        </ul>
        <?php

      }

      ?>
    </div>
    <div class="clear"></div>
  </main>
</div>
<!-- Footer with links and template detail -->
<?php include 'footer.php'; ?>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
</body>
</html>
