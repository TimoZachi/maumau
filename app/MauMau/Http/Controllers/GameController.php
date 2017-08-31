<?php
namespace MauMau\Http\Controllers;

use Auth;
use Crypt;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use MauMau\Models\Game;
use MauMau\Models\Round;
use MauMau\Models\Suit;

class GameController extends Controller
{
    public function jogar(Request $request)
    {
	    $user = Auth::user();

	    $time = time();
	    $date = date('Y-m-d', $time);
	    $time = date('H:i:s', $time);

        $token = Crypt::encrypt($date . '|' . $user['id'] . '|' . $time);
	    $port = 9090;

        return view('jogar', compact('user', 'token', 'port'));
    }

    public function game(Request $request, $id)
    {
        /** @var Game $game */
        $game = Game::find($id);
        if(!$game) abort(404, 'Jogo não encontrado');

        /** @var Round $round */
        $round = $game->CurrentRound()->first();

        $user = Auth::user();
        $players = []; $player = null; $before = true;
        foreach($game->Players as $current_player)
        {
            if($current_player->user_id != $user->id)
            {
                $player_user = $current_player->User()->select('id', 'name', 'avatar')->first();
                $player_user->avatar = $player_user->avatar ?
                    asset('assets/img/upload/avatars/' . $player_user->avatar) :
                    asset('assets/img/no-avatar.jpg');
                $players[] = [
                    'cards' => $round->RoundCards($current_player->id)->count(),
                    'player' => $current_player,
                    'user' => $player_user,
					'before' => $before
                ];
            }
            else
            {
                $cards = $round->RoundCards($current_player->id)->get();
                foreach($cards as $card)
                {
                    $card->id = $card->round_card_id;
                }
				$before = false;
                $player = [
                    'cards' => $cards,
                    'player' => $current_player,
                    'user' => $user
                ];
            }
        }

		usort($players, function ($p1, $p2)
		{
			if($p2['before'] && !$p1['before']) return -1;

			return $p1['player']->id - $p2['player']->id;
		});

        $positions = [];
        if(count($players) == 1) $positions = [2];
        elseif(count($players) == 2) $positions = [1, 3];
        else $positions = [1, 2, 3];

		$base_layout = $request->ajax() ? 'nothing' : 'layout';

	    $suits = Suit::all();
	    $suit = $round->Suit;

	    return view('game', compact(['base_layout', 'game', 'round', 'players', 'player', 'positions', 'suits', 'suit']));
    }
}