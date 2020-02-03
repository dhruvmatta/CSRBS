<?php

class Cookie {

  // checks if there is already a cookie that exists and outputs a boolean value for it
  public static function exists($name){
    return (isset($_COOKIE[$name])) ? true : false;
  }

  // retrieves the cookie that is a stored
  public static function get($name){
    // outputs cookie details with entered name
    return $_COOKIE[$name];
  }

  // sets the cookie name, value and an expiry time for it
  public static function put($name, $value, $expiry){
    // sets cookie with name value and takes current time and adds an expiration for it
    if (setcookie($name, $value, time() + $expiry, '/')) {
      return true;
    }
    return false;
  }

  // deletes a cookie with the entered name
  public static function delete($name){
    self::put($name, '', time() - 1);
  }
}
