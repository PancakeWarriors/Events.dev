<?php
    class Tag extends Eloquent
    {
		protected $fillable = array('name');
        protected $table = 'tags';
        public function posts()
        {
            return $this->belongsToMany('CalendarEvent', 'calendar_event_tag');
        }
    }