<?php
namespace MauMau\WebSocket\Messages;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use MauMau\Models\Game as GameModel;
use MauMau\Models\Modality;
use MauMau\Models\Player;
use MauMau\Models\Round;
use MauMau\Models\Table as TableModel;
use MauMau\Models\TableOccupant;
use MauMau\WebSocket\Client;

class Table extends Message
{
	const TYPE = 'table';

	public function input($data)
    {
        if(empty($data['action']))
        {
            throw new \Exception('action not set');
        }

        $response = null;
        switch($data['action'])
        {
            case 'at_table':
                $response = $this->_atTable();
                break;
            case 'toggle':
                $response = $this->_toggle();
                break;
        }

        return $response;
    }

    /**
     * Se o cliente desconectar, tira ele de qualquer mesa que ele estiver
     */
    public function onDisconnect()
    {
        $user = $this->_client->getUser();

	    /** @var TableModel $table */
	    $table = $this->_getOccupantTable($user['id']);
        if($table)
        {
            $table->Occupants()->detach($user['id']);
            $table->decrement('occupants');

	        $ids = $table->Occupants()->getRelatedIds()->toArray();
	        $this->_sendUsers(
		        $ids,
		        static::TYPE,
		        [
			        'action' => 'at_table',
			        'at_table' => false,
			        'user' => $user
		        ],
		        $user['id']
	        );

            if($table->occupants == 0)
            {
                $table->in_game = false;
                $table->save();
            }
        }
    }

    protected function _atTable()
    {
	    $user = $this->_client->getUser();

	    /** @var TableModel $table */
	    $table = $this->_getOccupantTable($user['id']);

        return [
            'action' => 'at_table',
            'at_table' => $table ? true : false,
            'user' => $user
        ];
    }

    protected function _toggle()
    {
        $user = $this->_client->getUser();

	    $table = $this->_getOccupantTable($user['id']);
	    /** @var TableModel $table */
        if($table) $at_table = true;
        else
        {

            $table = TableModel::getFirstAvailable();
            if(empty($table))
            {
                $table = TableModel::create([
                    'capacity' => TableModel::DEFAULT_CAPACITY,
                    'occupants' => 0,
                    'in_game' => false
                ]);
            }
            $at_table = false;
        }

	    $return = [
		    'action' => 'toggle',
		    'at_table' => !$at_table
	    ];
        if($at_table)
        {
	        $table->Occupants()->detach($user['id']);
            $table->decrement('occupants');
	        $ids = $table->Occupants()->getRelatedIds()->toArray();
        }
        else
        {
	        $table->Occupants()->attach($user['id'], ['created_at' => Carbon::now()]);
            $table->increment('occupants');

	        $occupants = $table->Occupants();
	        $return['users'] = $this->_parseUsers($occupants->get());
	        $ids = $occupants->getRelatedIds()->toArray();

	        if(count($ids) >= $table->capacity)
	        {
		        $occupants = $table->Occupants()->get();
		        $game = GameModel::create([
			        'table_id' => $table->id,
			        'winner_id' => null
		        ]);

		        $first_id = null; $players = [];
		        foreach($occupants as $occupant)
		        {
			        $player = Player::create([
				        'game_id' => $game->id,
				        'user_id' => $occupant->id,
				        'points' => 0,
				        'status' => Player::STATUS_IN_GAME
			        ]);
			        if(is_null($first_id)) $first_id = $player->id;
			        $players[] = $player;
		        }

		        /** @var Modality $modality */
		        $modality = Modality::main()->first();
		        Round::createWithCards([
			        'game_id' => $game->id,
			        'round' => 0,
			        'player_id' => $first_id
		        ], $modality, $players);

                $table->in_game = true;
                $table->save();

                foreach($ids as $id)
                {
                    /** @var Client $client */
                    $client = Client::$userIds[$id];
                    $client->data['game'] = $game;
                }

		        return [
			        $ids,
			        [
				        'action' => 'load',
				        'url' => route('game', ['id' => $game->id])
			        ]

		        ];
	        }
        }

	    $this->_sendUsers(
		    $ids,
		    static::TYPE,
		    [
			    'action' => 'at_table',
			    'at_table' => $return['at_table'],
			    'user' => $this->_parseUsers($user)
		    ],
		    $user['id']
	    );

        return $return;
    }

	protected function _getOccupantTable($id)
	{
		//Um usuário só pode estar em uma mesa de cada vez, por isso procura se ele está atualmente em uma mesa
		/** @var TableOccupant $table_occupant */
		$table_occupant = TableOccupant::where('user_id', $id)->first();

		$table = null;
		if($table_occupant) $table = $table_occupant->Table;

		return $table;
	}

	protected function _parseUsers($users)
	{
		$is_single = false;
		if(!empty($users))
		{
			if(!isset($users[0]))
			{
				$is_single = true;
				$users = [$users];
			}

			foreach($users as $i=>$user)
			{
				if(!preg_match('/^http:\\/\\//', $user->avatar))
				{
					if(!empty($user->avatar))
					{
						$users[$i]->avatar = asset('assets/img/upload/avatars/' . $user->avatar);
					}
					else
					{
						$users[$i]->avatar = asset('assets/img/no-avatar.jpg');
					}
				}
			}
		}
		else
		{
			$users = [];
		}

		return $is_single ? $users[0] : $users;
	}
}