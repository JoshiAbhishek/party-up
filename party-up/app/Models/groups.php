<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
	protected $table = 'groups';
	protected $primaryKey = 'id';
	protected $fillable = array();

	public function locations()
	{
		return $this->hasMany('App\Models\locations');
	}
}
