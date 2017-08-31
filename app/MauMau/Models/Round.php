<?php
namespace MauMau\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Query\Builder;

class Round extends Model
{
    const STATUS_IN_GAME = 0;
    const STATUS_FINISHED = 1;

	protected $fillable = [
		'game_id', 'round', 'player_id'
	];

	protected $table = 'rounds';

	public static function createWithCards(array $attributes = [], Modality $modality, $players)
	{
		$round = static::create($attributes);

        $cards = $modality->Deck->Cards->toArray();
        $all_cards = [];
        for($i = 0; $i < $modality->decks_count; $i++)
        {
            $all_cards = array_merge($all_cards, $cards);
        }
        shuffle($all_cards);

		$last = count($all_cards) - 1; $cards_players = [];
		foreach($players as $player)
		{
			for($i = 0; $i < RoundCard::CARDS_PER_PLAYER; $i++)
			{
				do
				{
					$c = rand(0, $last);
				} while(isset($cards_players[$c]));

				$cards_players[$c] = $player->id;
			}
		}

        $first_round_card_id = null; $cards_create = [];
        $date = Carbon::now();
		foreach($all_cards as $i=>$card)
		{
			$card_id = $card['id'];

			$cards_create[] = [
				'round_id' => $round->id,
				'card_id' => $card_id,
				'player_id' => isset($cards_players[$i]) ? $cards_players[$i] : null,
                'created_at' => $date,
                'updated_at' => $date
			];
		}

		RoundCard::insert($cards_create);

		$rc = RoundCard::getFirstAvailableCardOnRound($round->id);
        $round->round_card_id = $rc->id;
		$round->suit_id = $rc->suit_id ?
			$rc->suit_id :
			Suit::getRandomId();

        DB::table(RoundCard::getModelTable())
            ->where('id', $round->round_card_id)
            ->update(['used' => 1]);

        $round->save();
	}

    public function RoundCards($playerId = null)
    {
        $rounds_cards_table = RoundCard::getModelTable();

        $relation = $this->belongsToMany('MauMau\Models\Card', $rounds_cards_table, 'round_id', 'card_id')
            ->withPivot(['player_id', 'created_at', 'updated_at', 'id AS round_card_id'])
            ->orderBy("$rounds_cards_table.created_at", 'asc');

        if(!is_null($playerId))
        {
            if(!is_array($playerId)) {
                $relation->where("$rounds_cards_table.player_id", '=', $playerId);
            } else {
                $relation->whereIn("$rounds_cards_table.player_id", $playerId);
            }
        }

        return $relation;
    }

    public function CurrentRoundCard()
    {
        return $this->belongsTo('MauMau\Models\RoundCard', 'round_card_id', 'id');
    }

    public function Player()
    {
        return $this->belongsTo('MauMau\Models\Player', 'player_id', 'id');
    }

	public function Suit()
	{
		return $this->belongsTo('MauMau\Models\Suit', 'suit_id', 'id');
	}

    public function AvailableRoundCards($quantity = null)
    {
        $builder = $this->hasMany('MauMau\Models\RoundCard', 'round_id', 'id')
            ->whereNull('player_id')
            ->where('used', '=', false)
            ->orderBy('id', 'asc');

        if(!is_null($quantity)) $builder->limit($quantity);

        return $builder;
    }
}
