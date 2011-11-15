<?php

namespace net\mediaslave\calendar\lib;

/**
*
*/
class Settings extends \Hash
{
	const VERSION = '0.0.1';

	private $convert = array('ttl'=> 'X-PUBLISHED-TTL',
													 'scale'=> 'CALSCALE');

	function __construct() {
		parent::__construct();
		$this->set('PRODID', '-//Mediaslave//Mediaslave Calendar ' . self::VERSION . '//EN');
		$this->set('_PRODID', '-//%s//Mediaslave Calendar ' . self::VERSION . '//EN');
		$this->set('VERSION', '2.0');
		$this->set('CALSCALE', 'GREGORIAN');
		$this->set('METHOD', 'PUBLISH');
		$this->set('X-WR-CALNAME', sha1(time()));
		$this->set('X-PUBLISHED-TTL', 'PT1H');
		$this->processUserSettings();
		$this->remove('_PRODID');
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
