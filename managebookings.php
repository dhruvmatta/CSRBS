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
<title>Manage Bookings</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
  <!-- Inlcude the banner of links -->
  <?php include 'banner.php'; ?>
	<?php
    // check if user is logged in, if not redirect to homepage
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
        <li><a href="managebookings.php">Manage Bookings</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="content">
      <div class="roomtitle" align="center">
        <h1>Manage Bookings</h1>
      </div>

      <?php
      // get current user's userID
      $userID = $user->data()->ID;

      // get results of the current users bookings from runnings sql
      // keep results in variable
      $userbooking = DB::getInstance()->get('booking', array('staffID', '=', $userID));
      $daysOfTheWeek = array('blank', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
	    $userbookings = $userbooking->results();

      // if there are no results from the sql
      // outputs a mesage saying that are no bookings
      if (empty($userbookings)) {
        echo "<div align='center'>";
        echo " <br> <p> You have no bookings </p>";
        echo "<a href='bookaroom.php'>Make A Booking Here!</a>";
        echo "</div>";
      } else {

        // if there are results
        // outputs results in a table of user's bookings
        ?>
        <div align="center">
          <p> <a href="bookaroom.php">Book a room</a></p>
        </div>
        <div class="scrollable">
          <table>
            <thead>
              <tr align="center">
                <th>Week</th>
                <th>Day</th>
                <th>Room</th>
                <th>Period</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>

              <?php foreach($userbooking->results() as $userbooking){ ?>
              <tr align="center">
                <td> <?php echo $userbooking->week; ?> </td>
                <td> <?php echo $daysOfTheWeek[$userbooking->date]; ?> </td>
                <td>
                <?php

                  $roomID = $userbooking->roomID;
                  $roomName = DB::getInstance()->get('room', array('roomID', '=', $roomID));
                  foreach ($roomName->results() as $roomName) {
                    echo $roomName->roomName;
                  }

                ?>

                </td>
                <td> <?php echo $userbooking->periodID; ?> </td>
                <td> <?php echo "<a href='modifybooking.php?bookingID=" . $userbooking->bookingID . "'> Modify </a> "; ?> / <?php echo "<a href='cancelbooking.php?bookingID=" . $userbooking->bookingID . "'> Cancel </a> </td>"; ?>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php
      }
      ?>

    </div>
  </main>
</div>
<?php include 'footer.php'; ?>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
