<?php
namespace MauMau\Models;

class Action extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key', 'name', 'description'
    ];

	protected $table = 'actions';
}
