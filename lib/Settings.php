<?php

namespace net\mediaslave\calendar\lib;

use net\mediaslave\calendar\lib\exceptions\InvalidThruException;
/**
*
*/
class Settings extends \Hash
{
	const VERSION = '0.0.1';

	static $thru;

	private $convert = array('ttl'=> 'X-PUBLISHED-TTL',
													 'scale'=> 'CALSCALE');

	function __construct() {
		parent::__construct();
		$this->set('VERSION', '2.0');
		$this->set('PRODID', '-//Mediaslave//Mediaslave Calendar ' . self::VERSION . '//EN');
		$this->set('_PRODID', '-//%s//Mediaslave Calendar ' . self::VERSION . '//EN');
		$this->set('CALSCALE', 'GREGORIAN');
		$this->set('METHOD', 'PUBLISH');
		$this->set('X-WR-CALNAME', 'Mediaslave Calendar');
		$this->set('X-PUBLISHED-TTL', 'PT1H');
		$this->processUserSettings();
		$this->remove('_PRODID');
	}

	/**
   *
   * Register a model with a with calendar to use for the
   * thru relationship.
   *
   * @return void
   * @author Justin Palmer
   **/
  static public function addModel($model, $thru){
  	if(!(self::$thru instanceof \Hash)){
  		self::$thru = new \Hash;
  	}
    self::$thru->set($model, $thru);
  }
  /**
   *
   * Get the thru relationship class or throw an exception
   *
   * @return string
   * @author Justin Palmer
   **/
  static public function getThru($key){
  	$key = get_class($key);
  	if(!(self::$thru instanceof \Hash) || !self::$thru->isKey($key)){
  		throw new InvalidThruException($key);
  	}
  	return self::$thru->get($key);
  }

	/**
	 *
	 * Get the ini settings and added them or replace them in the list.
	 *
	 * @return void
	 * @author Justin Palmer
	 **/
	private function processUserSettings()
	{
		$settings = \Registry::get('pr-plugin-phrails-calendar')->global;
		foreach($settings as $key => $value){
			$hkey = $this->getKey($key);
			if($key == 'company'){
				$hkey = 'PRODID';
				$value = sprintf($this->get('_PRODID'), $value);
			}
			$this->set($hkey, $value);
		}
	}

	/**
	 *
	 * Get the key
	 *
	 * @return string
	 * @author Justin Palmer
	 **/
	private function getKey($key)
	{
		if(array_key_exists($key, $this->convert)){
			return $this->convert[$key];
		}
		return strtoupper($key);
	}

}
