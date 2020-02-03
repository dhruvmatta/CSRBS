<?php
// checks if there is a booking available from get and sets it in the variable
if (isset($_GET["bookingID"])) {
  $bookingID = $_GET["bookingID"];
} else {
  $bookingID = $_GET["userbookingID"];
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
<title>Modify Booking</title>
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
    // initialises the current users
    $user = new User;
    // checks if there is a user logged in, if not - redirects to homepage
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
        <?php echo"<li><a href='modifybooking.php?bookingID=".$bookingID."'>Modify Booking</a></li>"; ?>
      </ul>
    </div>
  </div>
</div>

<!-- End Top Background Image Wrapper -->

<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content" align='center'>
      <?php
      // gets current user's user ID
      $userID = $user->data()->ID;

      // gets information about the current booking trying to be modified from the booking table in the db
      $user = DB::getInstance()->get('booking', array('bookingID', '=', $bookingID));

      // if there is no booking with that booking ID -
      if (empty($user)) {
        echo " <br> <br> <h3> That Booking Doesn't Exist </h3>";
        echo "<a href='#'></a>";
      } else {

        $daysOfTheWeek = array('', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        ?>

        <h1> Current Booking </h1>
        <div class="scrollable">


          <table>
            <thead>
              <tr>
                <th>Week</th>
                <th>Period</th>
                <th>Day</th>
                <th>Room</th>



              </tr>
            </thead>
            <tbody align='center'>

              <?php foreach($user->results() as $user){ ?>
              <tr>
                <td> <?php echo $user->week; ?> </td>
                <td> <?php echo $user->periodID; ?> </td>
                <td> <?php echo $daysOfTheWeek[$user->date]; ?> </td>
                <td>
                <?php
                  $roomID = $user->roomID;
                  $roomName = DB::getInstance()->get('room', array('roomID', '=', $roomID));
                  foreach ($roomName->results() as $roomName) {
                    echo $roomName->roomName;
                  }
                ?>
                </td>


              </tr>
            <?php } ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
      <br>
      <h1 align='center'> Modify Booking
        <br>
        <?php
          // check if there is an input on the modify booking page and store them in variables
          if (Input::exists()) {
            $selectedRoom = Input::get('selectedRoom');
            $week = Input::get('week');
            // set week number according to current week
            if ($week == 'thisWeek') {
              $week = intval(date("W"));
            } else {
              $week = intval(date("W"))+1;
            }

            // if the selected room exists, then get the name from the db using the ID
            if ($selectedRoom !== 'none') {
              $selectedRoomName = DB::getInstance()->get('room', array('roomID', '=', $selectedRoom));
              foreach ($selectedRoomName->results() as $selectedRoomName) {
                $selectedRoomName = $selectedRoomName->roomName;
              }
            }

            // print the name of the room along with the week number
            if ($selectedRoom !== 'none') {
              echo " <br> " . $selectedRoomName;
              echo " <br> Week Number: " . $week;
            }
          }
        ?>
      </h1>
      <div id="comments">
        <form action='<?php echo "modifybooking.php?bookingID=".$bookingID; ?>' method="post">
          <?php
            // get list of all rooms in department from db
            $roomList = DB::getInstance()->query("SELECT * FROM room");
          ?>
          Classroom:
          <select name="selectedRoom" required>

            <?php
            // print the room names in a dropdown
            foreach ($roomList->results() as $roomList){
              echo "<option value='".$roomList->roomID."'>".$roomList->roomName."</option>";
            }
            ?>
          </select>

          Week:
          <select name="week">
            <?php
              // dropdown for week
              echo "<option value='thisWeek'>This Week</option>";
              echo "<option value='nextWeek'>Next Week</option>";
            ?>
          </select>
          <br>
          <input type="submit" value="View Rooms Available">

        </form> <br>
      </div>
      <?php
        // check if there any input
        if (Input::exists()) {


          // if there is a room selected
          // retrieve results from db about the selected room
          if ($selectedRoom !== 'none') {
            $selectedRoomName = DB::getInstance()->get('room', array('roomID', '=', $selectedRoom));
            foreach ($selectedRoomName->results() as $selectedRoomName) {
              $selectedRoomName = $selectedRoomName->roomName;
            }
          }
        }

        // check if an input exists and store the selected room in a variable
        if (Input::exists()) {
          $selectedRoom = Input::get('selectedRoom');

          if ($selectedRoom !== 'none') {
            // retrieve results of the rooms timetable
            $timetable = DB::getInstance()->get('timetable', array(
              'roomID',
              '=',
              $selectedRoom
            ));
            // set timetable in a 2 dimensional array with the className
            foreach ($timetable->results() as $timetable) {
              $fullTimetable[$timetable->dayID][$timetable->periodID] = $timetable->className;
            }

            // retrieve bookings from booking table in db
            $bookings = DB::getInstance()->query("SELECT * FROM booking INNER JOIN users
              WHERE booking.staffID = users.ID
              AND booking.roomID = $selectedRoom AND booking.week = $week");

            // store bookings in the timetable variable
            foreach($bookings->results() as $bookings){
              $day = $bookings->date;
              $fullTimetable[$day][$bookings->periodID] = "Booked by " . $bookings->name;
            }

            // set rest of spots at available to change the booking to
            for ($i=0; $i < 6 ; $i++) {
              for ($x=0; $x < 6 ; $x++) {
                if (empty($fullTimetable[$x][$i])) {
                  $fullTimetable[$x][$i] = "<a href='modifybookingprocess.php?bookingID=".$bookingID."&roomID=".$selectedRoom."&periodID=".$i."&dayID=".$x."&week=".$week."'> Change To This </a>";
                }
              }
            }

          } else {
            // set all as empty
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
      <div class="scrollable">
        <?php
          // check if input exists
          if (Input::exists()) {
        ?>

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
              // output entire timetable in table format
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
