<?php
    class Tag extends Eloquent
    {
        protected $table = 'tags';
        public function posts()
        {
            return $this->belongsToMany('CalendarEvent', 'calendar_event_tag');
        }
    }