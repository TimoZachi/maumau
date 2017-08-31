<?php
namespace MauMau\Models;

use DB;

class Suit extends Model
{
	protected $table = 'suits';

	protected $fillable = [
		'name', 'icon', 'color'
	];

	public static function getRandomId()
	{
		return static::select('id')
			->orderBy(DB::raw('RAND()'))
			->limit(1)
			->value('id');
	}
}