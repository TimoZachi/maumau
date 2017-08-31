<?php
namespace MauMau\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class Deck extends Model
{
	protected $table = 'decks';

	protected $fillable = [
		'name'
	];

	public function Cards()
	{
		return $this->belongsToMany('MauMau\Models\Card', 'decks_cards', 'deck_id', 'card_id')
            ->withPivot(['order'])
            ->orderBy('order', 'asc');
	}

	public function SuitsCount()
	{
		/** @var Builder $builder */
		$builder = $this->Cards()->getQuery();

		$cards_table = Card::getModelTable();
		$cnt = $builder->distinct("{$cards_table}.suit_id")->count("{$cards_table}.suit_id");

		return $cnt;
	}
}
