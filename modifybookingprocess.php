<?php
require_once 'core/init.php';
    // checks if user is logged in, if not redirects to homepage
    $user = new User;
    if (!$user->isLoggedIn()) {
       Redirect::to('index.php');
    }
// if there is data available on the page
// the get function is used to store the bookingID, day. room, period and the week
if ($_GET) {
  $bookingID = Input::get('bookingID');
  $day = Input::get('dayID');
  $roomID = Input::get('roomID');
  $periodID = Input::get('periodID');
  $week = Input::get('week');

  // the details are then updated onto the booking table with the new details
  DB::getInstance()->query("UPDATE `booking` SET `date`=$day,`roomID`=$roomID,`periodID`=$periodID,`week`=$week WHERE `bookingID` = $bookingID");
  Redirect::to('managebookings.php');
  // page is then redirected back to managebookings page
}
