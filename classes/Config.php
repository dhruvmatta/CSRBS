<?php

class Config{

  //gets the GLOBALS array from the core/init.php file
  public static function get($path = null){
    //checks if there is a path in the globals file
    if ($path) {
      $config = $GLOBALS['config'];
      $path = explode('/', $path);

      //sets the config as the bit from the config in the globals variable in the core.init.php file
      foreach($path as $bit){
        if(isset($config[$bit])){
          $config = $config[$bit];
        }
      }
      return $config;
    }
    return false;
  }
}



?>
