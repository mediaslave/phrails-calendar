<?php

namespace net\mediaslave\calendar\lib;

use net\mediaslave\calendar\app\models\CalendarEvent;
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
			$ics .= "SUMMARY:" . $event->summary . $this->ret;
			$ics .= "COMMENT:" . $event->comment . $this->ret;
			$ics .= "CLASS:" . $event->class . $this->ret;
			$ics .= "PRIORITY:" . $event->priority . $this->ret;
			$ics .= "TRANSP:" . $event->transp . $this->ret;
			$ics .= "STATUS:" . $event->status . $this->ret;
			$ics .= "LOCATION:" . $event->location . $this->ret;
			$ics .= "UID:" . $event->uid . $this->ret;
			$ics .= "DTSTART:" . $event->objectify('dtstart')->format(CalendarEvent::DATE_FORMAT) . $this->ret;
			$ics .= "DTEND:" . $event->objectify('dtend')->format(CalendarEvent::DATE_FORMAT) . $this->ret;
			$ics .= "CREATED:" . $event->objectify('created_at')->format(CalendarEvent::DATE_FORMAT) . $this->ret;
			$ics .= $this->processAlarms($event->alarms);
			$ics .= "END:VEVENT" . $this->ret;
		}

		return $ics . "END:VCALENDAR";
	}

	/**
	 *
	 * process any alarms
	 *
	 * @return string
	 * @author Justin Palmer
	 **/
	private function processAlarms(array $alarms)
	{
		$ignore = array('id', 'calendar_event_id', 'updated_at', 'created_at');
		$ret = '';
		foreach($alarms as $alarm){
			$ret .= 'BEGIN:VALARM' . $this->ret;
			foreach($alarm->props()->export() as $key => $value){
				if($value == null || in_array($key, $ignore)){
					continue;
				}
				$ret .= strtoupper($key) . ':' . $value . $this->ret;
			}
			$ret .= 'END:VALARM' . $this->ret;
		}
		return $ret;
	}
}
