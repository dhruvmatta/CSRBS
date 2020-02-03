<?php
// initialisation file
require_once 'core/init.php';
$user = new User;

// stores current Users groupid in vairable
// check for permissions and if it doesn't match criteria of page, it is redirected
$currentUser = $user->data()->groupid;
if ($currentUser == 1) {
  Redirect::to('index.php');
} else {
  // userID is retrieved useiing the GET function
  // user is deleted and so is all of their bookings
  // page is redirected back to where this action took place
  $userID = $_GET['userID'];
  DB::getInstance()->delete('users', array('ID', '=', $userID));
  DB::getInstance()->delete('booking', array('staffID', '=', $userID));
  Redirect::to('usermanager.php');
}

    $user = new User;
    if (!$user->isLoggedIn()) {
       Redirect::to('index.php');
    }
?>
