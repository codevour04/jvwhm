<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insertable extends Model
{
    protected $guarded = [];

    public function insertable () {
    	return $this->morphTo();	
    }
}
