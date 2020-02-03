<?php

class input {

  // checks if that there is a post or get function
  public static function exists($type = 'post'){
    switch($type){
      // if the set datatype is post, outputs boolean true, else false
      case 'post';
        return (!empty($_POST)) ? true : false;
      break;
      // if the set datatype is get, outputs boolean true, else false
      case 'get';
        return (!empty($_GET)) ? true : false;
      break;

      // if there is no post or get set, outputs boolean false
      default:
        return false;
      break;
    }
  }


  // gets the post or get item in the form of a string
  // parameters item can be chosen by user
  public static function get($item){
    if(isset($_POST[$item])){
      return $_POST[$item];
    } else if (isset($_GET[$item])) {
      return $_GET[$item];
    }
    return '';
  }

  // isGet is used in my project for checking if the user has selected a room
  // if user has selected room, a boolean value is returned
  public static function isGet(){
    if($_GET['selectedRoom']){
      return true;
    } else {
      return false;
    }
  }

}
