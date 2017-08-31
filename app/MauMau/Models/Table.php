<?php
namespace MauMau\Models;

class Table extends Model
{
	const DEFAULT_CAPACITY = 3;

    protected $table = 'tables';

    protected $fillable = [
        'capacity', 'occupants'
    ];

    public static function getFirstAvailable()
    {
	    $table = static::whereRaw('occupants < capacity')
	        ->where('in_game', 0)
            ->orderBy('id', 'asc')
            ->first();

        return $table;
    }

    public function Occupants()
    {
	    $join_table = TableOccupant::getModelTable();

        return $this->belongsToMany('MauMau\Models\User', $join_table, 'table_id', 'user_id')
	        ->withPivot(['created_at'])
	        ->orderBy("$join_table.created_at", 'asc');
    }
}
