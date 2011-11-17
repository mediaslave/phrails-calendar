<?
use net\mediaslave\calendar\lib\Settings;
/**
* Example:
*
* This example shows how to calendar will build the thru relationship to the person
* the given event/calendar belongs to.
*
* Employee is the model with the information about the person the calendar belongs to.
* CalendarThruEmployee is the thru relationship for the hasMany and belongs_to relationship.
*
* Settings::addModel('net\mediaslave\example-app\app\models\Employee',
*                    'net\mediaslave\example-app\app\models\CalendarThruEmployee');
*/
