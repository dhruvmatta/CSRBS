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
      include 'banner.php';
      require_once 'core/init.php';
    ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="timetable.php">Timetable</a></li>
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
          // check if there is any input
          if (Input::exists()) {
            // check for a room selected and store in vairable
            $selectedRoom = Input::get('selectedRoom');
            // check for a week and store in vairable
            $week = Input::get('week');

            // set week number from current week or next week
            if ($week == 'thisWeek') {
              $week = intval(date("W"));
            } else {
              $week = intval(date("W"))+1;
            }

            if ($selectedRoom !== 'none') {
              // retieve data for current timetable selected
              $selectedRoomName = DB::getInstance()->get('room', array('roomID', '=', $selectedRoom));
              foreach ($selectedRoomName->results() as $selectedRoomName) {
                // room name is retrieved and stored
                $selectedRoomName = $selectedRoomName->roomName;
              }
            }
          }
        ?>
        <h1> Timetable
          <?php
            // check for input and outputs room chosen and week chosen
            if (Input::exists()) {
              if ($selectedRoom !== 'none') {
                echo " - " . $selectedRoomName . " || Week Number - " . $week;
              }
            }
          ?>
        </h1>
      </div>
      <?php
        $user = new User;

        // checks if there is user logged in and retrieves userID
        if ($user->isLoggedIn()) {
          $userID = $user->data()->ID;
        }

        if (Input::exists()) {
          // checks which is the selected room
          $selectedRoom = Input::get('selectedRoom');
          // selected room data is retrieved
          $timetable = DB::getInstance()->get('timetable', array(
            'roomID',
            '=',
            $selectedRoom
          ));
          // rooms timetable is stored in a 2 dimensional array
          foreach ($timetable->results() as $timetable) {
            $fullTimetable[$timetable->dayID][$timetable->periodID] = $timetable->className;
          }

          // query for bookings
          $bookings = DB::getInstance()->query("SELECT * FROM booking INNER JOIN users WHERE booking.staffID = users.ID AND booking.roomID = $selectedRoom AND week = $week");

          // bookings is stored in same 2 dimensional array as the timetable
          foreach($bookings->results() as $bookings){
            $day = $bookings->date;
            $fullTimetable[$day][$bookings->periodID] = "Booked by " . $bookings->name;
          }

        }

      ?>

      <div id="comments" align="center">
        <form action="timetable.php" method="post">

          <?php

          echo "<form class='' action='timetable.php' method='post'>";
          $roomList = DB::getInstance()->query("SELECT * FROM room");

          ?>

          Classroom:<select name="selectedRoom">

            <?php
            // drop down of rooms
            foreach ($roomList->results() as $roomList){
              echo "<option value='".$roomList->roomID."'>".$roomList->roomName."</option>";
            }

            ?>
          </select>

          Week:
          <!-- Week dropdown is set -->
          <select name="week">
            <option value='thisWeek'>This Week</option>
            <option value='nextWeek'>Next Week</option>
          </select>
          <br>
          <input type="submit" value="View Timetable">

        </form>
        <br>
      </div>
      <?php if (Input::exists()) {
        # code...
      ?>
      <div class="scrollable" align="center">
        <table>
          <thead>
            <tr align='center'>
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
              // sets rest of vairable to be free
              for ($i=0; $i < 6 ; $i++) {
                for ($x=0; $x < 6 ; $x++) {
                  if (empty($fullTimetable[$x][$i])) {
                    $fullTimetable[$x][$i] = "Free Room";
                  }
                }
              }
              // outputs timetable in a table format
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
      </div>
      <?php } ?>

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
