<?php
namespace MauMau\Models;

class Game extends Model
{
	protected $table = 'games';

    protected $fillable = [
        'table_id', 'winner_id'
    ];

    public function Players($clockwise = true, $all = false)
    {
        $return = $this->hasMany('MauMau\Models\Player', 'game_id', 'id')
            ->orderBy("id", $clockwise ? 'asc' : 'desc');

        if(!$all) $return->where("status", '=', 0);

        return $return;
    }

	public function NextPlayer($afterId, $clockwise = true)
	{
		return $this->hasMany('MauMau\Models\Player', 'game_id', 'id')
			->where("id", $clockwise ? '>' : '<', $afterId)
			->where("status", '=', 0)
			->orderBy("id", $clockwise ? 'asc' : 'desc')
			->limit(1);
	}

    public function CurrentRound($all = false)
    {
        $return = $this->hasMany('MauMau\Models\Round', 'game_id', 'id')
            ->orderBy('round', 'desc')
            ->limit(1);

        if(!$all) $return->where('status', '=', 0);

        return $return;
    }

    public function UserPlayer($userId)
    {
        return $this->hasMany('MauMau\Models\Player', 'game_id', 'id')
            ->where("user_id", '=', $userId)
            ->where("status", '=', 0)
            ->limit(1);
    }

}
