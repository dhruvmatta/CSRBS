<?php

class Token{

  // generates a uniqueid token and then stores it in the Session with the configs token name
  public static function generate(){
    return Session::put(Config::get('session/token_name'), md5(uniqid()));
  }

  // retrieves token with config get function
  // check if the token exists and the entered token exists
  // if there already is a token existing which is the same as the entered one
  // delete the old token and output boolean true
  public static function check($token){
    $tokenName = Config::get('session/token_name');

    if(Session::exists($tokenName) && $token === Session::get($tokenName)){
      Session::delete($tokenName);
      return true;
    }

    return false;
  }
}
