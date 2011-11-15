<?php

namespace net\mediaslave\calendar\lib;

/**
*
*/
class IcsView extends \View
{
	public $extension = 'ics';
	/**
	 * process the view
	 *
	 * @return void
	 * @author Justin Palmer
	 **/
	public function process($content){
		$cal = new Icalendar($content);
		header('content-type:text/calendar');
		return $cal->process();
	}
}
