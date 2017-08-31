<?php
namespace MauMau\Models;

class Player extends Model
{
    const STATUS_IN_GAME = 0;
    const STATUS_ABANDONED = 1;
    const STATUS_ELIMINATED = 2;

	protected $table = 'players';

    protected $fillable = [
        'game_id', 'user_id', 'points', 'status'
    ];

    public function User()
    {
        return $this->belongsTo('MauMau\Models\User', 'user_id', 'id');
    }

    public function Cards($roundId)
    {
        return $this->belongsToMany('MauMau\Models\Card', 'rounds_cards', 'player_id', 'card_id')
            ->wherePivot('round_id', '=', $roundId);
    }
}
