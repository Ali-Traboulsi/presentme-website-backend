<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = [
        'type-name'
    ];

    public function events() {
        return $this->belongsToMany(Event::class);
    }


}
