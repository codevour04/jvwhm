<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = [];
    protected $table = 'persons';
    protected $appends = ['fullname'];

    public function insertables()
    {
        return $this->morphMany(Insertable::class, 'insertable');
    }

    public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->lastname}";
	}
}