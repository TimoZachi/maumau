<?php

namespace MauMau\Models;

class Modality extends Model
{
    protected $table = 'modalities';

    protected $fillable = [
        'deck_id', 'name', 'suits_count', 'description', 'main'
    ];

	public static function main()
	{
		return static::where('main', '=', 1)
			->orderBy('updated_at', 'desc')
			->limit(1);
	}

    public function Deck()
    {
        return $this->belongsTo('MauMau\Models\Deck', 'deck_id');
    }
}
