<?php
namespace net\mediaslave\calendar\lib\exceptions;
/**
* No controller for the specified route.
* @package exceptions
*/
class InitThruNotCalledException extends \Exception
{
  function __construct($object){
    parent::__construct("The initThru method was not called before the save method.
                        $object relies on an afterSave filter to connect the calendar
                        item to a given subscriber.");
  }
}
