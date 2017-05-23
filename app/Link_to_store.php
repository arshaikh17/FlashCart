<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link_to_store extends Model
{



    public function store()
    {
    	return $this->belongsTo('App\Store');
    }
    /*function stores() {
    return $this->belongsToMany('App\Store', 'store_id')->withPivot('privilege');
    }*/
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
