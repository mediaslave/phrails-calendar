<?php
namespace net\mediaslave\calendar\lib\exceptions;
/**
* No controller for the specified route.
* @package exceptions
*/
class InvalidThruException extends \Exception
{
  function __construct($requested){
    parent::__construct("The relationship specified `" . get_class($requested) . "` was not found please added it to the phrails-calendar initializer.");
  }
}
