<?php
namespace MauMau\Models;

class TableOccupant extends Model
{
	protected $table = 'table_occupants';

    public function Table()
    {
        return $this->belongsTo('MauMau\Models\Table', 'table_id', 'id');
    }
}
