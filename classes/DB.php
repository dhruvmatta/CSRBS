<?php
class DB {
  private static $_instance = null;
  private $_pdo,
      $_query,
      $_error = false,
      $_results,
      $_count = 0;

  //sets up database to be able to access - username / password to database
  private function __construct(){
    //constructs the connection taken from the config file where the details are taken from the core.init.php file
    try{
      $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    } catch(PDOException $e){
      die($e->getMessage());
    }
  }

  //to be able to check if there person is logged in or not
  //if not instanciated, it will set and initiation
  public static function getInstance(){
    // checks if there is a instance stored which checks if there is a user logged in
    if (!isset(self::$_instance)) {
      self::$_instance = new DB();
    }
    return self::$_instance;
  }

  //runs sql query with paramaters which are inserted into the array
  public function query($sql, $params = array() ){
    $this->_error = false;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if (count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }

      if ($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }

    return $this;
  }

  //sql query with where statements and operations
  //sets up an sql statement that can be executed with certain operators
  public function action($action, $table, $where = array()){
    if(count($where) === 3){
      $operators = array('=', '>', '<', '>=', '<=', '<>');

      $field = $where[0];
      $operator = $where[1];
      $value = $where[2];

      if(in_array($operator, $operators)){
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
        if(!$this->query($sql, array($value))->error()){
          return $this;
        }
      }
    }
    return false;
  }

  //get information from the database
  public function get($table, $where){
    return $this->action('SELECT *', $table, $where);
  }

  //runs an SQL to retrieve all the data from a table
  public function getWholeTable($table){
    return $this->action('SELECT *', $table);
  }

  //delete query where a table is chosen and the where vairable acts as deleting rows of data with specific values
  public function delete($table, $where){
    return $this->action('DELETE', $table, $where);
  }

  //inserted into the db
  //requires the table to be inserted and the fields with the values in an array set in the variable called fields
  public function insert($table, $fields = array()){

    $keys = array_keys($fields);
    $values = '';
    $x = 1;

    //makes sure that the values are equal to the fields when using the function
    foreach($fields as $field){
      $values .= '?';
      if($x < count($fields)){
        $values .= ', ';
      }
      $x++;
    }

    //implode = takes keys and creates it into array with a separater
    $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values}) ";
    if(!$this->query($sql, $fields)->error()){
      return true;
    }

    return false;
  }

  //updates fields from table
  //takes the table the user wants to update information and updates it with the given fields stored in the fields variable
  public function update($table, $id, $fields){
    $set = '';
    $x = 1;

    foreach ($fields as $name => $value){
      $set .= "{$name} = ?";
      if($x < count($fields)){
        $set .= ', ';
      }
      $x++;
    }

    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

    if(!$this->query($sql, $fields)->error()){
      return true;
    }

    return false;

  }

  //outputs all results from the query executed
  public function results(){
    return $this->_results;
  }

  //outputs first result from the query executed
  public function first(){
    return $this->results()[0];
  }

  //outputs errors from the query executed
  public function error(){
    return $this->_error;
  }

  //count function on possibly a query or anything else
  public function count(){
    return $this->_count;
  }

}
