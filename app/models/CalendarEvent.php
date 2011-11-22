<?php
/**
 * Namespace for models
 */
namespace net\mediaslave\calendar\app\models;

use net\mediaslave\calendar\lib\Settings;
use net\mediaslave\calendar\lib\exceptions\InitThruNotCalledException;
/**
 * PageBlock
 */
/**
 * ClassBlock
 */
class CalendarEvent extends \Model{

  const DATE_FORMAT = 'Ymd\THis';
  const DATE_ALL_DAY_FORMAT = 'Ymd';
  /**
   * Hold the model name for the thru table
   *
   * @param string
   */
  private $thru_model=null;

  /**
   * The model with the primary key that belongs to the thru
   *
   * @param \Model
   */
  private $model;

	/**
	 * Add rules for this model.
	 *
	 * @author Justin Palmer
	 */
	public function init(){
    $this->filters()->afterSave('saveThru');
    $this->filters()->beforeDelete('deleteThru');

    $s = $this->schema();

    $s->hasMany('alarms')->className('net\mediaslave\calendar\app\models\CalendarAlarm', true);
	}

  /**
   * Init the thru relationship
   *
   * @param $model Model
   * @return void
   * @author Justin Palmer
   **/
  public function initThruRelationship(\Model $model){
    $this->model = $model;
    $this->thru_model = Settings::getThru($model);
    $model_name = get_class($model);

    $this->schema()->hasOne('subscriber')->className($model_name, true)->thru($this->thru_model, true);
    $this->schema()->hasOne('thru')->className($this->thru_model, true);
    return $this;
  }

  /**
   *
   * Save to the thru table.
   *
   * @return boolean
   * @author Justin Palmer
   **/
  public function saveThru(){
    $this->hasThru();
    //else we will save the record to the through relationship.
    $primary = $this->model->primary_key();
    $thru = $this->thru_model;
    $primary_id = $this->model->$primary;

    $calendar_event_foreign_key = \Inflections::foreignKey($this->table_name());
    $model_foreign_key = \Inflections::foreignKey($this->model->table_name());

    $thru = new $thru(array(
                        $calendar_event_foreign_key => $this->id,
                        $model_foreign_key => $this->model->id
                        ));
    return $thru->save();
  }

  /**
   *
   * Delete the thru record and all of the alarms.
   *
   * @return boolean
   * @author Justin Palmer
   **/
  public function deleteThru()
  {
    $this->hasThru();
    if($this->thru->delete()){
      foreach($this->alarms as $alarm){
        //If any of the alarms fail to delete we will cancel the transaction.
        if(!$alarm->delete()){
          return false;
        }
      }
      return true;
    }
    return false;
  }

  /**
   *
   * Check that we have the thru set
   *
   * @throws InitThruNotCalledException
   * @return void
   * @author Justin Palmer
   **/
  private function hasThru()
  {
    if($this->thru_model == null){
      throw new InitThruNotCalledException(get_class($this));
    }
  }
}
