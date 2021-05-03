<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    protected $guarded = [];
    protected $table = 'persons';
    protected $appends = ['fullname', 'leadername'];

    use Softdeletes;

    public function insertables()
    {
        return $this->morphMany(Insertable::class, 'insertable');
    }

    public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->lastname}";
	}

    public function getLeaderNameAttribute()
    {
        $id = Insertable::select('insertable_id')->where('person_id', $this->id)->get();

        if ($id->isEmpty()) {
            return "Not set";
        }

        $person = Person::find($id);

        return $person[0]->fullname;
    }



}