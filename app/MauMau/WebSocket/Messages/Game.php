<?php
/**
 * Created by PhpStorm.
 * User: Soks DEV 01
 * Date: 13/06/2016
 * Time: 08:58
 */

namespace MauMau\WebSocket\Messages;

use MauMau\Models\Card;
use MauMau\Models\Modality;
use MauMau\Models\Player;
use MauMau\Models\Round;
use MauMau\Models\Game as GameModel;
use MauMau\Models\RoundCard;
use MauMau\Models\Suit;

class Game extends Message
{
	const TYPE = 'game';

	private $lastCardSignal = [];

	public function input($data)
	{
		if(empty($data['action'])) {
			throw new \Exception('action not set');
		}

        /** @var GameModel $game */
        $game = $this->_client->data['game'];

		// Pega do servidor caso já tenha sido setada pra essa instancia do game.
		if( isset($this->_server->data['last_card'][$game->id]) ) $this->lastCardSignal = $this->_server->data['last_card'][$game->id];

        /** @var Round $round */
        $round = $game->CurrentRound()->first();

		$response = null;
		switch($data['action'])
		{
            case 'game_info':
                /** @var Round $round */
                $round = $game->CurrentRound()->first();
                $response = $this->_gameInfo($round);
                break;
            case 'play':
                /** @var Round $round */
                $round = $game->CurrentRound()->first();

                if(!isset($data['do'])) {
                    throw new \Exception('do must be set in data field');
                }

                $response = $this->_play($game, $round, $data['do'], $data);

				if( count($this->lastCardSignal) ){
					// echo 'Zera os botoes';
					$lastCard['action'] = 'play';
					$lastCard['do'] = 'last_card';
					$lastCard['bt_status'] = false;
					$this->_sendUsers(
						$this->_gameUserIds(),
		                static::TYPE,
						$lastCard
					);
				}

				$this->_server->data['last_card'][$game->id] = [];

                break;
            case 'play_again':
                echo "Play again action\n";
                $response = $this->_playAgain($game, $data);
                break;
			case 'last_card':
                /** @var Round $round */
                $round = $game->CurrentRound()->first();
				$response = $this->_callLastCard($game, $data['user_id']);
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

        /** @var GameModel $game */
        $game = $this->_client->data['game'];

        $player = $game->UserPlayer($user['id'])->first();
        $player->status = Player::STATUS_ABANDONED;
        $player->play_again = false;
        $player->save();

        $this->_sendUsers(
            $this->_gameUserIds(),
            static::TYPE,
            [
                'action' => 'disconnected',
                'player' => $player,
                'user' => $user
            ]
        );

        $cnt = $game->Players()->count();
        if($cnt > 1)
        {
            $return = $this->_checkPlayAgain($game);
            if($return)
            {
                $this->_server->sendData(static::TYPE, $return);
            }
        }
        if($cnt == 1)
        {
            $remaining_player = $game->Players(true, true)->first();

            $winner = $remaining_player;
            if($player->points < $remaining_player->points) $winner = $player;

            $game->winner_id = $winner->user_id;
            $game->save();

            $player_left = $game->Players()->first(['id', 'user_id']);
            $this->_sendUsers(
                [$player_left->user_id],
                static::TYPE,
                ['action' => 'game_finished', 'winner' => $winner->User()->first(['id', 'name'])]
            );
        }
	}


    protected function _gameInfo(Round $round)
    {
        $rc = $round->CurrentRoundCard;
        $card = $rc->Card;
        $card->id = $rc->id;
        $player = $round->Player;
        $user = $player->User;
        return [
            'action' => 'game_info',
            'suits' => Suit::all(['id', 'name', 'icon']),
            'suit' => $round->Suit()->first(['id', 'name', 'icon']),
            'whose_turn' => [
	            'player' => $player,
                'user' => $user
            ],
            'card' => $card,
            'card_html' => view('card-template', ['card' => $card, 'tag' => 'div', 'style' => 'width:100%; height:100%;'])->render()
        ];
    }

    protected function _play(GameModel $game, Round $round, $do, $data)
    {
	    $return = [
		    'action' => 'play'
	    ];

	    $error = false; $message = '';
	    $cuser = $this->_client->getUser();

	    $ids = [$cuser->id]; $out_data = [];
		switch($do)
		{
			case 'card':
				if(!isset($data['id']))
				{
					throw new \Exception('id must be set in data field');
				}

                /** @var Player $player */
				$player = $round->Player;
				$user = $player->user_id == $cuser->id ? $cuser : $player->User()->first(['id', 'name']);

				$rc_id = (int)$data['id'];
				$rc = RoundCard::find($rc_id);

				$error = true;
				if(!$rc) $message = 'Carta inexistente';
				elseif($rc->player_id != $player->id) $message = 'Essa carta não é sua';
				else
				{
					/** @var Card $played_card */
					$played_card = $rc->Card;

					/** @var RoundCard $current_round_card */
					$current_round_card = $round->CurrentRoundCard;
					$current_card = $current_round_card->Card;

					if(!$this->_isCardPlayable($round, $current_card, $played_card)) $message = 'Carta jogada inválida';
					else
					{
                        $error = false;
						//Se a carta jogada não tem naipe, ou a ação requer naipe, o naipe é obrigatório
						$action = $played_card->Action()->first(['key', 'require_suit']);
						if(
							empty($played_card->suit_id) ||
							($action && $action['require_suit'])
						) {
							if(!isset($data['suit_id']))
							{
                                $error = true;
								$message = 'Naipe requerido para esta carta';
							}
							$suit_id = $data['suit_id'];
						}
						else $suit_id = $played_card->suit_id;

						if(!$error)
						{
							$clockwise = $round->clockwise;

							$next_player = null;
							switch($action['key'])
							{
								case 'skip_next': //Pula próximo jogador
									$next_player = $this->_getNextPlayer($game, $player, $clockwise, 1);
									$u = $next_player->User()->first(['id', 'name']);
									$this->_notify($u->name . ' pulou a vez.', $this->_gameUserIds(), $u->id);
									$this->_notify('Você pulou a vez.', [$u->id]);
									$next_player = $this->_getNextPlayer($game, $next_player, $clockwise, 1);
									break;
								case 'play_again': //Jogar novamente
									$next_player = $player;
                                    $this->_notify($user->name . ' joga denovo.', $this->_gameUserIds(), $user->id);
                                    $this->_notify('Você joga denovo.', [$user->id]);
									break;
								case 'next_draw_2':
									$next_player = $this->_getNextPlayer($game, $player, $clockwise, 1);
									$this->_draw($round, $next_player, 2, true);
									$next_player = $this->_getNextPlayer($game, $next_player, $clockwise, 1);
									break;
								case 'prev_draw_2':
									$prev_player = $this->_getNextPlayer($game, $player, !$clockwise, 1);
									$this->_draw($round, $prev_player, 2, true);
									$next_player = $this->_getNextPlayer($game, $player, $clockwise, 1);
									break;
								case 'wild_card':
									//Do nothing
									break;
								case 'revert_order':
									$clockwise = !$clockwise;
									$this->_notify('Ordem revertida para sentido ' . ($clockwise ? 'Horário' : 'Anti-Horário'));
									break;
								case 'wild_draw_4':
									$next_player = $this->_getNextPlayer($game, $player, $clockwise, 1);
									$this->_draw($round, $next_player, 4, true);
									$next_player = $this->_getNextPlayer($game, $next_player, $clockwise, 1);
									break;
							}

							if(!$next_player) $next_player = $this->_getNextPlayer($game, $player, $clockwise);

							$ids = $this->_gameUserIds();
							$rc->used = true;
							$rc->player_id = null;
							$rc->save();

							$out_data['user'] = $user;
							$out_data['card'] = $played_card;
							$played_card->id = $rc->id;
							$out_data['card_html'] = view('card-template', ['card' => $played_card, 'tag' => 'div', 'style' => 'width:100%; height:100%;transform:rotate('.rand(-5,5).'deg)'])->render();

							$out_data['suit'] = Suit::find($suit_id);

							$round->clockwise = $clockwise;
							$round->player_id = $next_player->id;
							$round->round_card_id = $rc->id;
							$round->suit_id = $suit_id;
							$round->save();

                            $out_data['clockwise'] = $clockwise;

                            if($player->Cards($round->id)->count() <= 0)
                            {
                                $cards_table = Card::getModelTable();

                                //Jogador $player venceu
                                foreach($game->Players()->get(['id', 'points', 'status']) as $p)
                                {
                                    if($p->id == $player->id) continue;

                                    $points = 0;
                                    foreach($p->Cards($round->id)->get(["$cards_table.id", "$cards_table.points"]) as $c)
                                    {
                                        $points += $c->points;
                                    }

                                    $p->points = $player->points + $points;
                                    $p->save();
                                }

                                $round->status = Round::STATUS_FINISHED;
                                $round->save();

                                $do = 'round_finished';
                            }
                            else
                            {
								if( !in_array( $player->id, $this->lastCardSignal) && count($this->lastCardSignal)  && $player->Cards($round->id)->count() == 1 )
								{
									// echo 'Nao apertou maumau.. comprou';
									$data = $this->_draw($round, $player, 1, true);
								}

                                $out_data['whose_turn'] = [
                                    'player' => $next_player,
                                    'user' => $next_player->User()->first(['id', 'name'])
                                ];
                            }
						}
					}
				}

				break;
			case 'draw':
				$player = $round->Player;

                $data = $this->_draw($round, $player, 1, false);

				$next_player = $this->_getNextPlayer($game, $player, $round->clockwise);

				$whose_turn = [
					'player' => $next_player,
					'user' => $next_player->User()->first(['id', 'name'])
				];
				foreach($data as &$row)
				{
					$row['data']['whose_turn'] = $whose_turn;
				}
				$this->_server->sendData('game', $data);

                $round->player_id = $next_player->id;
                $round->save();

                return null;
				break;
		}

	    if($error)
	    {
		    $return['do'] = 'error';
		    $return['message'] = $message;
	    }
	    else
	    {
		    $return['do'] = $do;
		    $return = array_merge($return, $out_data);
	    }

	    return [$ids, $return];
    }

    protected function _playAgain(GameModel $game, $data)
    {
        $user = $this->_client->getUser();
        $player = $game->UserPlayer($user->id)->first();

        //echo "Player ", $player->id, " wants to play again\n";

        $player->play_again = 1;
        $player->save();

        //echo "Player ", $player->id, " saved\n";

        //echo $game->Players()->count(), "|", $game->Players()->where('play_again', '=', true)->count();

        return $this->_checkPlayAgain($game);
    }

    protected function _checkPlayAgain($game)
    {
        if(
            $game->Players()->count() == $game->Players()->where('play_again', '=', true)->count()
        ) {
            $first_id = null; $players = $game->Players;
            $first_id = $players[0]->id;

            foreach($players as $player)
            {
                $player->play_again = false;
                $player->save();
            }

            $cround = $game->CurrentRound(true)->value('round');
            echo "cround: ", $cround, "\n";

            /** @var Modality $modality */
            $modality = Modality::main()->first();
            Round::createWithCards([
                'game_id' => $game->id,
                'round' => $cround + 1,
                'player_id' => $first_id
            ], $modality, $players);

            return [
                [
                    'ids' => $this->_gameUserIds(),
                    'data' => [
                        'action' => 'load',
                        'url' => route('game', ['id' => $game->id])
                    ]
                ]
            ];
        }

        return null;
    }

	protected function _getNextPlayer(GameModel $game, $player, $clockwise, $skip = 1)
	{
		$skipped = 0; $next_player = $player;
		do
		{
			/** @var Player $next_player */
			$next_player = $game->NextPlayer($next_player->id, $clockwise)->first();
			if(!$next_player) {
				$next_player = $game->Players($clockwise)->first();
			}

			$skipped++;
		} while($skipped < $skip);

		return $next_player;
	}

	protected function _notify($message, $ids = null, $except = null)
	{
		if(is_null($ids)) $ids = $this->_gameUserIds();
		$data = [
            $ids,
            ['action' => 'info', 'message' => $message]
        ];
		if($except) $data[] = $except;

		$this->_server->sendData('game', $data, false);
	}

    /**
	 * Compra carta(s) de uma rodada e as assinala a um jogador
	 *
	 * @param Round $round A Model da rodada com as cartas
	 * @param Player $player A Model do jogador
	 * @param int $quantity Quantidade de cartas que vão ser compradas
	 * @param bool $autoNotify Se você deseja que seja enviado automaticamente para os jogadores ou não
	 *
	 * @return array As informações sobre as cartas compradas e pra quais usuários deve ser enviadas
	 */
    protected function _draw(Round $round, Player $player, $quantity = 1, $autoNotify = true)
    {
        $cnt = $round->AvailableRoundCards()->count();

        $rcards = [];
        if($quantity > $cnt)
        {
            $quantity -= $cnt;
            foreach($round->AvailableRoundCards($cnt)->get() as $card)
            {
                $rcards[] = $card;
            }

            DB::table(RoundCard::getModelTable())
                ->where('round_id', '=', $round->id)
                ->whereNull('player_id')
                ->update(['used' => 0]);
        }

        foreach($round->AvailableRoundCards($quantity)->get() as $card)
        {
            $rcards[] = $card;
        }

        $cards = []; $cards_html = [];
        /** @var RoundCard $rcard */
        foreach($rcards as $rcard)
        {
            $rcard->player_id = $player->id;
            $rcard->used = 0;
            $rcard->save();

            $card = $rcard->Card;
            $card->id = $rcard->id;

            $cards[] = $card;

            $cards_html[] = view('card-template', ['card' => $card, 'tag' => 'div'])->render();
        }

        $user = $player->User()->first(['id', 'name']);

		$array = [
			'action' => 'play',
			'do' => 'draw',
			'count' => count($rcards),
			'player' => $player,
			'user' => $user
		];

		$return = [
			[
				'ids' => $this->_gameUserIds(),
				'data' => $array,
                'except' => $user->id
			]
		];

		$array['cards'] = $cards;
		$array['cards_html'] = $cards_html;

        $return[] = [
			'ids' => [$user->id],
			'data' => $array
		];

		if($autoNotify) $this->_server->sendData('game', $return, false);

		return $return;
    }

	protected function _gameUserIds()
	{
		/** @var GameModel $game */
		$game = $this->_client->data['game'];

		return $game->Players()->lists('user_id');
	}

    protected function _isCardPlayable(Round $round, Card $tableCard, Card $newCard)
    {
        $match = false;
        echo strtoupper($tableCard->name), '|', strtoupper($newCard->name), '|', $newCard->suit_id, '|', $round->suit_id, "\n";
        switch($newCard->match)
        {
            case Card::MATCHES_BOTH:
                if(
                    $newCard->suit_id == $round->suit_id ||
                    strtoupper($newCard->name) == strtoupper($tableCard->name)
                ) {
                    $match = true;
                }
                break;
            case Card::MATCHES_NAME:
                if(strtoupper($newCard->name) == strtoupper($tableCard->name)) {
                    $match = true;
                }
                break;
            case Card::MATCHES_SUIT:
                if($newCard->suit_id == $round->suit_id) {
                    $match = true;
                }
                break;
            case Card::MATCHES_ALL:
                $match = true;
                break;
        }

        return $match;
    }

	protected function _callLastCard(GameModel $game, $userId){
		$return = [
			'action' => 'play'
		];

		if( !in_array($userId, $this->lastCardSignal) ) {
			// echo "Nao encontrou, adicionou ao array.\n";
			array_push($this->lastCardSignal, $userId);
			$last_card = true;
		} else {
			// echo "Encontrou, vai remover do array.\n";
			array_splice( $this->lastCardSignal,array_search($userId, $this->lastCardSignal),1 );
			$last_card = false;
		}
		// Guarda o array no server p/ fazer a comparacao
		$this->_server->data['last_card'][$game->id] = $this->lastCardSignal;

		// var_dump($this->lastCardSignal);
		$return['do'] = 'last_card';
		$return['bt_status'] = $last_card;

		return [[$userId], $return];
	}
}
