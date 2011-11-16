<?php
/**
 * Use the up method to describe the SQL that will be used to create/alter tables, columns.
 *
 * Use the down method to undo what the up method has described.
 */
/**
 * ClassBlock
 */
class Migration_20111115144441_CalendarEvent extends Migration{

	public function up(){
		$this->createTable('CalendarEvent');
            $this->references('CalendarCategory');
            $this->string('summary');
            $this->text('comment');
            $this->string('class', 'length:10');
            $this->integer('priority', 'length:1');
            $this->string('transp', 'length:11');
            $this->string('status', 'default:CONFIRMED,length:9');
            $this->text('location');
            $this->string('uid');
            $this->datetime('dtstart');
            $this->datetime('dtend');
            $this->timestamps();
	}


	public function down(){
		$this->dropTable('CalendarEvent');
	}


}
