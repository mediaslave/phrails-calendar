<?php
/**
 * Use the up method to describe the SQL that will be used to create/alter tables, columns.
 *
 * Use the down method to undo what the up method has described.
 */
/**
 * ClassBlock
 */
class Migration_20111115150858_CalendarAlarm extends Migration{

	public function up(){
	 $this->createTable('CalendarAlarm');
	   $this->references('CalendarEvent');
     $this->string('action', 'limit:20');
     $this->text('description');
     $this->string('summary');
     $this->string('trigger', 'limit:25,default:-PT30M');
     $this->timestamps();
  }


	public function down(){
		$this->dropTable('CalendarAlarm');
	}


}
