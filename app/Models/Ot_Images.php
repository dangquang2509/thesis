<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Ot_Images extends Model
{
	protected $table='ot_images';

	public static $rules = array(
		'spherical_id'	=> 'required|unique',
		'title'			=> 'required'
	);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}
}
