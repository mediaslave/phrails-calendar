<?php

namespace net\mediaslave\calendar\lib;

/**
*
*/
class IcsView extends \View
{
	public $can_have_layout=false;
	public $should_fallback_to_html = false;
	public $extension = 'ics';
	/**
	 * process the view
	 *
	 * @return void
	 * @author Justin Palmer
	 **/
	public function process($content){
		$cal = new Calendar($content);
		header('content-type:text/calendar');
		return $cal->process();
	}
}
