<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class locations extends Model
{
	protected $table = 'locations';
	protected $primaryKey = 'id';
	protected $fillable = array();
	public $timestamps = false;
    
}
