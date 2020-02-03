<?php
class Redirect {

  // the to function has the parameters of a location
  // a link or a location on the folder can be chosen and the page is redirected to it
  public static function to($location = null){
    if($location) {
      if (is_numeric($location)){
        switch ($location) {
          case 404:
            header('HTTP/1.0 404 Not Found');
            include 'includes/errors/404.php';
            exit();
          break;
        }
      }
      header('Location: ' . $location);
      exit();
    }
  }
}
