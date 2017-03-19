<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class memberships extends Model
{
	protected $table = 'memberships';
	protected $primaryKey = 'id';
	protected $fillable = array();

	public function users()
	{
		return $this->hasMany('App\Models\Users');
	}
    //
}
