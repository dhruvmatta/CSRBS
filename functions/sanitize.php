<?php

//  sanitizes the data being retrieved to the same font
function escape($string){
  return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
