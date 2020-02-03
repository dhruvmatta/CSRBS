<?php
// initialisation file
include 'core/init.php';

// sets current user
$user = new User;

$user = new User;
// checks if there is a user logged in
if (!$user->isLoggedIn()) {
  // if no user is logged in, redirected to homepage
   Redirect::to('index.php');
}

// retrieves all information through the get method and details in the url
// variables are set
$staffID = $_GET['staffID'];
$roomID = $_GET['roomID'];
$periodID = $_GET['periodID'];
$dayID = $_GET['dayID'];
$week = $_GET['week'];


// booking details are inserted into the database
DB::getInstance()->insert('booking', array(
  'staffID' => $staffID,
  'date' => $dayID,
  'roomID' => $roomID,
  'periodID' => $periodID,
  'week' => $week
));

// once insertion is complete, user is redirected to the manage booking page
Redirect::to('managebookings.php');

?>
