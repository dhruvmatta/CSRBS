<?php

// start connection
session_start();

//connection to database
$GLOBALS['config']=array(
  //connection to database
  'mysql' => array(
    'host' => 'localhost',
    'username' => 'ibdb4',
    'password' => 'IBdb4!',
    'db' => 'ibdb4'
  ),
  // rememberme function
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  // session details
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
  )
);



//runs everytime a class is accessed
//it takes the name and requires it once
spl_autoload_register(function($class) {
  require_once 'classes/' . $class . '.php';
});

// includes the code of the functions/sanitize page
require_once 'functions/sanitize.php';

//check if there is a cookie existing
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
  $hash = Cookie::get(Config::get('remember/cookie_name'));
  $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

  //gets the first hash from the user_session table in the db
  if ($hashCheck->count()) {
    $user = new User($hashCheck->first()->user_id);
    $user->login();
  }
}

$schoolNumber = '+65 6778 0771';
//sets current timezone to Singapore
$timezoneSet = date_default_timezone_set('Asia/Singapore');
//retrieves today's date
$dateToday =  date("d/m/Y");
