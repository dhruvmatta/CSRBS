<?php

class Session {

  // checks if there is a function already existing with the name entered as a string
  // outputs a boolean value
  public static function exists($name){
    return (isset($_SESSION[$name])) ? true : false;
  }

  // a session can be set with a string 'name' and given it a value with the variable value
  public static function put($name, $value){
    return $_SESSION[$name] = $value;
  }

  // gets the name session details with the parameter of name which is the desired session
  public static function get($name){
    return $_SESSION[$name];
  }

  // deletes the session that is specified in the parameters 'name'
  public static function delete($name){
    if(self::exists($name)){
      unset($_SESSION[$name]);
    }
  }

  // if session exists, de;ete session and update session with string
  public static function flash($name, $string = ''){
    if(self::exists($name)){
      $session = self::get($name);
      self::delete($name);
      return $session;
    } else {
      self::put($name, $string);
    }
    return '';
  }

}
