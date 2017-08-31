<?php
namespace MauMau\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
	public static function getModelTable()
	{
		return with(new static())->getTable();
	}
}