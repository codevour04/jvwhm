<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $guarded = [];

    public function persons()
    {
    	return $this->hasMany('App\Person');
    }
}
