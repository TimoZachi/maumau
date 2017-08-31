<?php
namespace MauMau\Models;

use Illuminate\Database\Query\Builder;

class Card extends Model
{
	const MATCHES_BOTH = 1;
	const MATCHES_NAME = 2;
	const MATCHES_SUIT = 3;
	const MATCHES_ALL = 4;

	protected $table = 'cards';

	protected $fillable = [
		'suit_id', 'action_id', 'match', 'points', 'name', 'image'
	];

	/** @return Builder */
	public function Action()
	{
		return $this->belongsTo('MauMau\Models\Action', 'action_id', 'id');
	}

	public function Suit()
	{
		return $this->belongsTo('MauMau\Models\Suit', 'suit_id', 'id');
	}
}
