<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	use Notifiable;
    protected $primaryKey = 'store_id';

	protected $fillable = [
        'store_name', 'store_email', 'store_username', 'slug'
    ];

    public function setStore_nameAttribute($value)
    {
    	$this->attributes['store_name'] = $value;
    	$this->attributes['slug'] = str_slug($value);
    }

    public function user_links()
    {
    	return $this->hasMany('App\Link_to_store');
    }
}
