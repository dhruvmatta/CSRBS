<!DOCTYPE html>

<html>
<head>
<title>Timetable</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php
      // include the banner of links and core initialisation file
      include 'banner.php';
      require_once 'core/init.php';

      // initiates a new user class on the page
      $user = new User;

    // checks if a user is not logged in and redirects them back to the home page since functionality is not allowed from this page
	  if (!$user->isLoggedIn()) {
		 Redirect::to('index.php');
	  }
    ?>
  </div>
  <!-- Small Page Links -->
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="bookaroom.php">Book A Room</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content">
      <div class="roomtitle" align="center">
        <?php
          // checks if there is an input
          if (Input::exists()) {

            // sets the variable as the selectedRoom input
            // gets the week
            $selectedRoom = Input::get('selectedRoom');
            $week = Input::get('week');


            // if input is thisweek - retrieves the current week
            if ($week == 'thisWeek') {
              $week = intval(date("W"));
            } else {
            // if input is the next week - retrieves current week and adds 1 to it
              $week = intval(date("W"))+1;
            }

            // if there is a selected room it gets the results from the db
            if ($selectedRoom !== 'none') {
              $selectedRoomName = DB::getInstance()->get('room', array('roomID', '=', $selectedRoom));
              foreach ($selectedRoomName->results() as $selectedRoomName) {
                $selectedRoomName = $selectedRoomName->roomName;
              }
            }
          }

        ?>
        <h1> Book a Room
          <?php
            // sets headings on the page related to the selected data
            if (Input::exists()) {
              if ($selectedRoom !== 'none') {
                echo " - " . $selectedRoomName;
                echo " || Week Number: " . $week;
              }
            }
          ?>
        </h1>
      </div>
      <?php
      $user = new User;
      // checks if user is logged in
      if ($user->isLoggedIn()) {
        $userID = $user->data()->ID;
        // counts the results where current user has made a booking
        $count = DB::getInstance()->query("SELECT COUNT(*) AS count FROM `booking` WHERE staffID = $userID");

        foreach($count->results() as $count){
          $count = $count->count;
        }

      }

      // doesnt let the user make more than 3 bookings
      if ($count < 3) {

        if (Input::exists()) {
          $selectedRoom = Input::get('selectedRoom');

          if ($selectedRoom !== 'none') {
            // retrieves timetable of selected room
            $timetable = DB::getInstance()->get('timetable', array(
              'roomID',
              '=',
              $selectedRoom
            ));

            // sets the timetable in a 2 dimensional array with the day, period and class name
            foreach ($timetable->results() as $timetable) {
              $fullTimetable[$timetable->dayID][$timetable->periodID] = $timetable->className;
            }

            // retrieves bookings
            $bookings = DB::getInstance()->query("SELECT * FROM booking INNER JOIN users
              WHERE booking.staffID = users.ID
              AND booking.roomID = $selectedRoom AND booking.week = $week");

            // sets the bookings into the variable of the timetable with their name
            foreach($bookings->results() as $bookings){
              $day = $bookings->date;
              $fullTimetable[$day][$bookings->periodID] = "Booked by " . $bookings->name;
            }

            // sets links for current user to make a booking with each button being redirected to another page
            // the next page takes the data through the get method
            for ($i=0; $i < 6 ; $i++) {
              for ($x=0; $x < 6 ; $x++) {
                if (empty($fullTimetable[$x][$i])) {
                  $fullTimetable[$x][$i] = "<a href='bookaroomprocess.php?staffID=".$userID."&roomID=".$selectedRoom."&periodID=".$i."&dayID=".$x."&week=".$week."'> Book This Room! </a>";
                }
              }
            }

          } else {

            // sets all left overs as empty uf nothing is selected
            for ($i=0; $i < 6 ; $i++) {
              for ($x=0; $x < 6 ; $x++) {
                if (empty($fullTimetable[$x][$i])) {
                  $fullTimetable[$x][$i] = "Empty";
                }
              }
            }
          }
        }

        ?>
        <div id="comments" align="center">
          <form action="bookaroom.php" method="post">
            <?php
              $roomList = DB::getInstance()->query("SELECT * FROM room");
            ?>
            Classroom:
            <select name="selectedRoom" required>

              <?php
              foreach ($roomList->results() as $roomList){
                echo "<option value='".$roomList->roomID."'>".$roomList->roomName."</option>";
              }
              ?>
            </select>

            Week:
            <select name="week">
              <?php
                echo "<option value='thisWeek'>This Week</option>";
                echo "<option value='nextWeek'>Next Week</option>";
              ?>
            </select>
            <br>
            <input type="submit" value="View Timetable">

          </form> <br>
        </div>
        <?php
        if (Input::exists()) {
        ?>
        <div class="scrollable" align="center">
          <table>
            <thead>
              <tr>
                <th>Period</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
              </tr>
            </thead>
            <tbody align='center'>

                <?php
                // outputs all the timetable information set above in a table for users to view and make bookings
                echo "<tr>";
                echo  "<td> 1 </td>";
                echo  "<td>" . $fullTimetable[1][1] ."</td>";
                echo  "<td>" . $fullTimetable[2][1] ."</td>";
                echo  "<td>" . $fullTimetable[3][1] ."</td>";
                echo  "<td>" . $fullTimetable[4][1] ."</td>";
                echo  "<td>" . $fullTimetable[5][1] ."</td>";
                echo "</tr>";

                echo "<tr>";
                echo  "<td> 2 </td>";
                echo  "<td>" . $fullTimetable[1][2] ."</td>";
                echo  "<td>" . $fullTimetable[2][2] ."</td>";
                echo  "<td>" . $fullTimetable[3][2] ."</td>";
                echo  "<td>" . $fullTimetable[4][2] ."</td>";
                echo  "<td>" . $fullTimetable[5][2] ."</td>";
                echo "</tr>";

                echo "<tr>";
                echo  "<td> 3 </td>";
                echo  "<td>" . $fullTimetable[1][3] ."</td>";
                echo  "<td>" . $fullTimetable[2][3] ."</td>";
                echo  "<td>" . $fullTimetable[3][3] ."</td>";
                echo  "<td>" . $fullTimetable[4][3] ."</td>";
                echo  "<td>" . $fullTimetable[5][3] ."</td>";
                echo "</tr>";

                echo "<tr>";
                echo  "<td> 4 </td>";
                echo  "<td>" . $fullTimetable[1][4] ."</td>";
                echo  "<td>" . $fullTimetable[2][4] ."</td>";
                echo  "<td>" . $fullTimetable[3][4] ."</td>";
                echo  "<td>" . $fullTimetable[4][4] ."</td>";
                echo  "<td>" . $fullTimetable[5][4] ."</td>";
                echo "</tr>";

                echo "<tr>";
                echo  "<td> 5 </td>";
                echo  "<td>" . $fullTimetable[1][5] ."</td>";
                echo  "<td>" . $fullTimetable[2][5] ."</td>";
                echo  "<td>" . $fullTimetable[3][5] ."</td>";
                echo  "<td>" . $fullTimetable[4][5] ."</td>";
                echo  "<td>" . $fullTimetable[5][5] ."</td>";
                echo "</tr>";

                ?>
            </tbody>
          </table>
          <?php } ?>
      <?php } else { ?>
        <!-- if the user has made 3 bookings, an error message is outputted -->
        <div align = "center">
          <p> You have made your maximum number of bookings at a time.<p>
          <p> <a href="managebookings.php">Manage</a> your bookings to make more bookings! </p>
        </div>

      <?php } ?>
      </div>
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
