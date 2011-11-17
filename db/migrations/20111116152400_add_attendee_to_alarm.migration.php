<?php
/**
 * Use the up method to describe the SQL that will be used to create/alter tables, columns.
 *
 * Use the down method to undo what the up method has described.
 */
/**
 * ClassBlock
 */
class Migration_20111116152400_add_attendee_to_alarm extends Migration{

	public function up(){
		$this->alterTable('CalendarAlarm');
      $this->string('attendee', 'after:summary');
      $this->string('attach', 'after:attendee');
	}


	public function down(){
    $this->alterTable('CalendarAlarm');
      $this->drop('attendee');
      $this->drop('attach');
	}


}
