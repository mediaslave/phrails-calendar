<?php
/**
 * Namespace for models
 */
namespace net\mediaslave\calendar\app\models;
/**
 * PageBlock
 */
/**
 * ClassBlock
 */
class CalendarAlarm extends \Model{

  const ACTION_AUDIO = "AUDIO";
  const ACTION_EMAIL = "EMAIL";
  const ACTION_DISPLAY = "DISPLAY";


  /**
   *
   * Set an audio alarm
   *
   * @return CalendarAlarm
   * @author Justin Palmer
   **/
  static public function newAudio($path, $trigger="-PT30M")
  {
    return new CalendarAlarm(array(
                              'action' => self::ACTION_AUDIO,
                              'description' => 'This is an event reminder',
                              'summary' => 'Alarm notification',
                              'attach' => $path,
                              'trigger'=> $trigger
                              ));
  }

  /**
   *
   * Set an email alarm
   *
   * @return CalendarAlarm
   * @author Justin Palmer
   **/
  static public function newEmail($email, $trigger="-PT30M")
  {
    return new CalendarAlarm(array(
                              'action' => self::ACTION_EMAIL,
                              'description' => 'This is an event reminder',
                              'summary' => 'Alarm notification',
                              'attendee' => 'mailto:' . $email,
                              'trigger'=> $trigger
                              ));
  }


	/**
	 * Add rules for this model.
	 *
	 * @author
	 */
	public function init(){
    $s = $this->schema();
    $s->belongsTo('event')->className('net\mediaslave\calendar\app\models\CalendarEvent', true);
	}
}
