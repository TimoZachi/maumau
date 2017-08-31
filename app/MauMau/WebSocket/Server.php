<?php
namespace MauMau\WebSocket;

use MauMau\WebSocket\Messages\Game;
use MauMau\WebSocket\Messages\Message;
use MauMau\WebSocket\Messages\Table;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface
{
	protected $_clients;

	public $data = [];

    protected $_onDisconnectClasses = [
	    Game::class,
        Table::class
    ];

    public function __construct()
    {
	    $this->_clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
	    $client = new Client($conn);
	    $this->_clients[$conn] = $client;

	    echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
	    $json = json_decode($msg, true);
	    if($json === false || !is_array($json) || empty($json['type']))
	    {
		    $from->send($this->error('request', 'Invalid JSON'));
	    }
	    else
	    {
		    $type = $json['type']; $data = isset($json['data']) ? $json['data'] : null;
		    if($type == 'auth')
            {
                $token = (string)$data;

                /** @var Client $client */
                $client = $this->_clients[$from];

                $status = $client->auth($token);
                if($status == 0)
                {
                    echo "Client ({$from->resourceId}) authenticated\n";
                    $from->send($this->response('auth', ['message' => 'User Authenticated Successfully', 'user' => $client->getUser()]));

	                $users = $this->getUsers($from);
	                /*if(!empty($users))
	                {*/
		                $from->send($this->response('user', [
			                'action' => 'online',
			                'users' => $users
                        ]));
	                /*}*/


                    $this->sendAll($this->response('user', [
                        'action' => 'connected',
                        'user' => $client->getUser()
                    ]), $from);
                }
			    else
                {
	                $message = $status == 1 ? 'Current user is already connected' : ($status == 2 ? 'Invalid Token' : 'Invalid User');
                    echo $status == 1 ? 'User already connected' : ($status == 2 ? 'Invalid Token' : 'Invalid User'), "\n";
                    $from->send($this->error('auth', ['message' => $message]));

	                $from->close();
                }
		    }
		    else
		    {
			    /** @var Client $client */
			    $client = $this->_clients[$from];

			    if(!$client->authenticated()) $from->send($this->error('auth', 'User must be authenticated to send data'));
			    else
			    {
                    $return = null;
                    try {
                        switch($type)
                        {
                            case Table::TYPE:
                                $message = new Table($this, $client);
                                $return = $message->input($data);
                                break;
	                        case Game::TYPE:
		                        $message = new Game($this, $client);
		                        $return = $message->input($data);
		                        break;
                            default:
                                $return = $this->error('type', 'Unknown type: ' . $type);
                                break;
                        }
                    } catch(\Exception $e) {
                        $return = $e->getMessage() . "\n" . $e->getTraceAsString();
                    }

                    if(!empty($return))
                    {
						if(is_array($return))
						{
							if(!$this->sendData($type, $return, $message->error))
							{
								$from->send($this->response($type, $return, $message->error));
							}
						}
						else $from->send($this->response($type, $return, $message->error));
                    }
			    }
		    }
	    }
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection ({$conn->resourceId}) has disconnected\n";

	    /** @var Client $client */
	    $client = $this->_clients[$conn];

        $this->_onDisconnect($client);

	    $this->_clients->detach($conn);

	    if($client->authenticated())
	    {
		    $user = $client->getUser();
	        unset(Client::$userIds[$user['id']]);

	        $this->sendAll($this->response('user', [
	            'action' => 'disconnected',
	            'user' => $user
	        ]));
	    }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred ({$conn->resourceId}): {$e->getMessage()}\n";
	    echo "Backtrace:\n", $e->getTraceAsString(), "\n";

	    /** @var Client $client */
	    $client = $this->_clients[$conn];

	    $this->_clients->detach($conn);
	    $conn->close();

        $this->_onDisconnect($client);

	    if($client->authenticated())
	    {
		    $user = $client->getUser();
		    unset(Client::$userIds[$user['id']]);

		    $this->sendAll($this->response('user', [
			    'action' => 'error',
			    'user' => $user
		    ]));
	    }
    }

    protected function _onDisconnect(Client $client)
    {
        foreach($this->_onDisconnectClasses as $class)
        {
	        try {
		        /** @var Message $message */
		        $message = new $class($this, $client);
		        $message->onDisconnect();
	        } catch(\Exception $e) {
		        //Ignore exceptions
	        }
        }
    }

	public function sendData($type, $return, $error = false)
	{
		$sent = false;
		if(is_array($return))
		{
			if(isset($return[0]) && isset($return[0]['ids']) && isset($return[0]['data']))
			{
				foreach($return as $row)
				{
					$this->sendUsers(
						$row['ids'],
						$this->response($type, $row['data'], $error),
						isset($row['except']) ? $row['except'] : null
					);
				}
				$sent = true;
			}
			elseif(isset($return[0]) && isset($return[1]))
			{
				list($ids, $actual_return) = $return;

				$except = null;
				if(isset($return[2])) $except = $return[2];
				$this->sendUsers(
					$ids,
					$this->response($type, $actual_return, $error),
					$except
				);
				$sent = true;
			}
		}
		else
		{
			echo "Data must be an array: ", print_r($return, true), "\n";
		}

		return $sent;
	}

	public function sendAll($msg, $except = null)
	{
		if(is_null($except)) $except = [];
		elseif(!is_array($except)) $except = [$except];

		/** @var ConnectionInterface $conn */
		foreach($this->_clients as $conn)
		{
			/** @var Client $client */
			$client = $this->_clients[$conn];
			if($client->authenticated() && !in_array($conn, $except, true))
			{
				$conn->send($msg);
			}
		}

		return true;
	}

	public function sendUsers($ids, $msg, $except = null)
	{
		if(is_null($except)) $except = [];
		elseif(!is_array($except)) $except = [$except];
		$except = array_map('intval', $except);

		foreach($ids as $id)
		{
			/** @var Client $client */
			$client = isset(Client::$userIds[$id]) ? Client::$userIds[$id] : null;
			if(in_array((int)$id, $except, true) || is_null($client)) continue;

			$conn = $client->getConn();
			$conn->send($msg);
		}

		return true;
	}

    public function getUsers($except = null)
    {
        $users = [];
        foreach($this->_clients as $conn)
        {
	        if($conn !== $except) {
		        $users[] = $this->_clients[$conn]->getUser();
	        }
        };

        return $users;
    }

    public function response($type, $data, $error = false)
	{
        $response = [
            'type' => $type,
            'error' => $error,
            'data' => $data
        ];

		return json_encode($response);
	}

	public function error($type, $data)
	{
		return $this->response($type, $data, true);
	}
}
