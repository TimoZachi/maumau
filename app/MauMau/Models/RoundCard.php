<?php
namespace MauMau\Models;

class RoundCard extends Model
{
	const CARDS_PER_PLAYER = 8;

	protected $fillable = [
		'round_id', 'card_id', 'player_id'
	];

    protected $table = 'rounds_cards';

	public static function getFirstAvailableCardOnRound($id)
	{
		$table = static::getModelTable();
		$cards_table = Card::getModelTable();

		return static::select("$table.id", "c.suit_id")
			->join("$cards_table AS c", 'c.id', '=', "$table.card_id")
			->where("$table.round_id", '=', $id)
			->whereNull("$table.player_id")
			->whereNull("c.action_id")
            ->orderBy("$table.id", 'asc')
            ->limit(1)
            ->first();
	}

    public function Card()
    {
        return $this->belongsTo('MauMau\Models\Card', 'card_id', 'id');
    }
}
