<?php
// initialises connection with database
require_once 'core/init.php';

// checks the user and logouts them out, removes the current session
$user = new User();
$user->logout();

// redirect to the homepage after being logged out
Redirect::to('index.php');
