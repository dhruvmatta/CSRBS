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
<title>User Bookings</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
	<?php
    $user = new User;
    if (!$user->isLoggedIn()) {
       Redirect::to('index.php');
    }
	?>
    <?php
      // Checks the current users permissions to check if they need to be redirected
      $permissions = $user->data()->ID;
      if ($permissions == 1) {
        Redirect::to('index.php');
      }

    ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="userbookings.php">User Bookings</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="content">
      <div class="roomtitle" align="center">
        <h1>User Bookings</h1>
      </div>

      <?php


      // set days of week and retrieve all the user's booking
      $userbooking = DB::getInstance()->query('SELECT * FROM booking');
      $daysOfTheWeek = array('blank', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
	    $userbookings = $userbooking->results();

      if (empty($userbookings)) {
        echo "<div align='center'>";
        echo " <p> There are no bookings </p>";
        echo "</div>";
      } else {



        // table of all the users bookings and details are outputted
        ?>
        <div class="scrollable">
          <table>
            <thead>
              <tr>
                <th>User</th>
                <th>Day</th>
                <th>Room</th>
                <th>Period</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>

              <?php foreach($userbooking->results() as $userbooking){ ?>
              <tr>
                <td> <?php $username = DB::getInstance()->get('users', array('ID', '=', $userbooking->staffID));
                    foreach($username->results() as $username){
                      echo $username->name;
                    }
                    ?>
                </td>
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
                <!-- Set as hyperlinks to cancelbooking -->
                <td> <?php echo "<a href='cancelbooking.php?userbookingID=" . $userbooking->bookingID . "'> Cancel </a> </td>"; ?>
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
