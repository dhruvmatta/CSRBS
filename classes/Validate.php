<?php


class Validate{
  private $_passed = false,
      $_errors = array(),
      $_db = null;


  // constructs a connection from the DB class
  public function __construct(){
    $this->_db = DB::getInstance();

  }

  // this is the main validation function and can be used in input forms
  // parameters are where it comes from and the requirements of the validation
  public function check($source, $items = array()){

    // the rules are the set of instructions set for the validation of form
    foreach ($items as $item => $rules) {
      foreach($rules as $rule => $rule_value){

        // value is what is being validated
        // the escape function is used to make sure the information is sanitized so therefore is not just copy pasted in another format
        $value = trim($source[$item]);
        $item = escape($item);

        // checks if the rule is required and checks if the field has been filled in
        if($rule === 'required' && empty($value)){
          // outputs error saying that the item in the form is required
          $this->addError("{$item} is required");

        // if the rule isnt required
        } else if(!empty($value)){
          switch ($rule) {

            // if the case is min it outputs what the minimum number of characters is
            case 'min':
              if(strlen($value) < $rule_value){
                $this->addError("{$item} must be a minimum of {$rule_value} characters");
              }
            break;

            // if the case is max it outputs what the maximum number of characters is
            case 'max':
              if(strlen($value) > $rule_value){
                $this->addError("{$item} must be a maximum of {$rule_value} characters");
              }
            break;

            // if the case is matches it checks if 2 fields match eachother and if they dont it outputs an error
            case 'matches':
              if($value != $source[$rule_value]){
                $this->addError("{$rule_value} must match {$item}");
              }
            break;

            // checks throught the database if it is a unique set of characters and doesnt match any in the db
            case 'unique':
              $check = $this->_db->get($rule_value, array($item, '=', $value));
              if($check->count()){
                $this->addError("{$item} already exists.");
              }
            break;


          }
        }
      }
    }

    // if there are no errors a boolean of true is set
    if(empty($this->_errors)){
      $this->_passed = true;
    }

    return $this;
  }

  // an error is set
  private function addError($error){
    $this->_errors[] = $error;
  }

  // checks the errors and sets them
  public function errors(){
    return $this->_errors;
  }

  // checks if validation has been passed
  public function passed(){
    return $this->_passed;
  }
}
