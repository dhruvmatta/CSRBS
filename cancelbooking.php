<?php

require_once 'core/init.php';

// creates a new user
$user = new User;

// checks if the user isnt logged in and if successful, page is redirected to the homepage
if (!$user->isLoggedIn()) {
   Redirect::to('index.php');
}

// if there is a bookingID present on the page, the get function is used to retrieve it and it is stored as a variable
if ($_GET['bookingID']) {
  $bookingID = $_GET["bookingID"];

  // the booking ID is taken and removed from the booking table in the the database and page is redirected to the managebookings page
  $booking = DB::getInstance()->delete('booking', array('bookingID', '=', $bookingID));
  Redirect::to('managebookings.php');

} else {
  // if an admin deletes the booking, it removes it from the booking table and is redirected to the userbooking page
  $bookingID = $_GET["userbookingID"];
  $booking = DB::getInstance()->delete('booking', array('bookingID', '=', $bookingID));
  Redirect::to('userbookings.php');
}

?>
