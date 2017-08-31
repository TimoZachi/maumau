<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MauMau\WebSocket\Server;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class ServerInit extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'server:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initiates maumau websocket server.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$port = 9090;

		$this->info("Starting web socket server on port " . $port);

		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Server()
				)
			),
			$port,
			'0.0.0.0'
		);

		$server->run();
	}
}
