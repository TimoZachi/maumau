<?php
namespace MauMau\WebSocket\Messages;

use MauMau\WebSocket\Client;
use MauMau\WebSocket\Server;

abstract class Message
{
	public $error = false;

    protected $_server;
	protected $_client;

	public function __construct(Server $server, Client $client)
	{
		$this->_server = $server;
		$this->_client = $client;
	}

	abstract public function input($data);

    public function onDisconnect() { }

	protected function _sendUsers($ids, $type, $msg, $except = null)
	{
		if(!empty($ids))
		{
			$server = $this->_server;
			$data = $server->response(
				$type,
				$msg,
				$this->error
			);
			$server->sendUsers($ids, $data, $except);
		}
	}
}