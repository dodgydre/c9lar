<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{
    protected $fillable = ['uuid'];
    protected $dates = ['start', 'end'];

    public function patient() {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
     public function getId() {
       return $this->id;
     }

     /**
      * Get the event's title
      *
      * @return string
      */
    public function getTitle() {
      return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */

    public function isAllDay() {
      return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
   public function getStart() {
     return $this->start;
   }

   /**
    * Get the end time
    *
    * @return DateTime
    */
  public function getEnd() {
    return $this->end;
  }

}
