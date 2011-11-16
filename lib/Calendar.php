<?php

namespace net\mediaslave\calendar\lib;

/**
*
*/
class Calendar
{
	/**
	 * Array of settings that need to go into the head of the vcalendar
	 *
	 * @param array
	 */
	private $set;
	private $content;
	private $ret = "\r\n";

	function __construct(array $content) {
		$this->content = $content;

		$settings = new Settings();
		$this->set = $settings->export();
	}
	/**
	 * process the view
	 *
	 * @return void
	 * @author Justin Palmer
	 **/
	public function process(){
		$ics = "BEGIN:VCALENDAR" . $this->ret;
		foreach($this->set as $key => $value){
			$ics .= $key . ':' . $value . $this->ret;
		}

		foreach($this->content as $event){
			$ics .= "BEGIN:VEVENT" . $this->ret;
			$ics .= "" . $this->ret;
			$ics .= "END:VEVENT" . $this->ret;
		}

		return $ics . $this->ret . "END:VCALENDAR";
	}
}
