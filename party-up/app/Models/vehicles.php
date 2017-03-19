<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicles extends Model
{
	protected $table = 'vehicles';
	protected $primaryKey = 'id';
	protected $fillable = array();

	public function locations() {
		return $this->hasMany('App\Models\locations');	
	}

	public function users() {
		return $this->hasMany('App\Models\Users');
	}
}

