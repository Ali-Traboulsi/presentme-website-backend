<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = [
        'gender-name'
    ];

    public function organizers() {
        return $this->belongsToMany(Organizer::class);
    }


    public function participants() {
        return $this->belongsToMany(Participant::class);
    }

}
