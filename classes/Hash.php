<?php

class Hash {

  // takes a sting and takes the salt and uses the hash function to create a hashed string
  public static function make($string, $salt = ''){
    return hash('sha256', $string . $salt);
  }

  // generates a salt with a specific length which is a random set of characters
  public static function salt($length){
    return mcrypt_create_iv($length);
  }

  //creates a unique id based on the current time in microseconds
  public static function unique(){
    return self::make(uniqid());
  }
  
}
