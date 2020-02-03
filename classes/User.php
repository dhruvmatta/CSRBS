<?php
class User {
  private $_db,
      $_data,
      $_sessionName,
      $_cookieName,
      $_isLoggedIn;

  // construct a database connection
  // parameters entered are user which is empty
  // if there is no user currently logged in then check if session exists and get it
  // if user is logged in output boolean value true
  // if not then find user
  public function __construct($user = null){
    $this->_db = DB::getInstance();

    $this->_sessionName = config::get('session/session_name');
    $this->_cookieName = config::get('remember/cookie_name');

    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);
        if ($this->find($user)) {
          $this->_isLoggedIn = true;
        } else {
          //process logout
        }
      }
    } else {
      $this->find($user);
    }

  }

  // parameters for function are fields which is an array and id to be updated
  // if a user  is logged in, retrieve the user_id
  // update the users with ID and fields
  // if there is a problem with updating output an error message
  public function update($fields = array(), $id = null){

    if (!$id && $this->isLoggedIn()) {
      $id = $this->data()->ID;
    }

    if (!$this->_db->update('users', $id, $fields)) {
      throw new Exception("There was a problem updating");

    }
  }

  // parameters are variable fields and it is an array
  // if it cant be inserted into db - output an error message
  public function create($fields = array()){
    if(!$this->_db->insert('users', $fields)){
      throw new Exception('There was a problem creating an account.');
    }
  }

  // parameters are user
  // checks if there is a user instanciated
  // if there is a user, sets field to id or the username depending on whether if it a number or simplexml_load_string
  // the data variable gets the users details but retrieving from database
  public function find($user = null){
    if($user){
      $field = (is_numeric($user)) ? 'id' : 'username';
      $data = $this->_db->get('users', array($field, '=', $user));

      if($data->count()){
        $this->_data = $data->first();
        return true;
      }
    }
  }

  // login function - parameters are username, password and remember me
  public function login($username = null, $password = null, $remember = false ){

    // if username and password and sessions exists exists - a session is already set
    if (!$username && !$password && $this->exists()) {
      Session::put($this->_sessionName, $this->data()->ID);

    // if there isn't a session - the username is run through the database to check if it exists and is set in user variable
    } else {
      $user = $this->find($username);

      // if the outcome is true, the entered password is hashed along with the salt retrieved from the database in relation to the user
      if ($user){
        // if the hashed password matches the hash password retrieved from the db, a session is created
        if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
          Session::put($this->_sessionName, $this->data()->ID);

          // if there is a rememeber me selected, a new hash is created and stored in the users_session table with the user id in the db
          if ($remember) {
            $hash = Hash::unique();
            $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->ID));

            // if there is no count on the hash in the db, the new hash is inserted into the users_session table
            if(!$hashCheck->count()){
              $this->_db->insert('users_session', array(
                'user_id' => $this->data()->ID,
                'hash' => $hash
              ));
            } else {
              $hash = $hashCheck->first()->hash;
            }

            // cookie is set with a hash and an expiry
            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
          }

          return true;
        }
      }
    }
    return false;
  }

  // the function hasPermission checks if the user has permissions as an admin or a normal user in the project
  public function hasPermission($key){
    $group = $this->_db->get('groups', array('id', '=', $this->data()->groupid));

    // checks if the user has a groupid which is the permissions
    if ($group->count()) {
      $permissions = json_decode($group->first()->permissions, true );
      if ($permissions[$key] == true) {
        return true;
      }
    }
    return false;
  }

  // checks if there any data and outputs a boolean value
  public function exists(){
    return (!empty($this->_data)) ? true : false;
  }

  // logs out current user
  public function logout(){

    $this->_db->delete('users_session', array('user_id', '=', $this->data()->ID));

    // retrieves session details and deletes it
    // retrieves current cookie and deletes it
    Session::delete($this->_sessionName);
    Cookie::delete($this->_cookieName);
  }

  // retrieves all information about the current user from the users table in db
  public function data(){
    return $this->_data;
  }

  // checks if a user is loggedin or not
  public function isLoggedIn(){
    return $this->_isLoggedIn;
  }

}
