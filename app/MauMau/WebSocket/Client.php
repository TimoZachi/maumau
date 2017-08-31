<?php
namespace MauMau\WebSocket;

use Crypt;
use MauMau\Models\User;
use Ratchet\ConnectionInterface;

class Client
{
    /** @var \SplObjectStorage */
    public static $userIds = [];

    public $data = [];

	/** @var ConnectionInterface */
	protected $_conn;

	/** @var int */
	protected $_id;

	/** @var User */
	protected $_user;

	public function __construct(ConnectionInterface $conn)
	{
		$this->_conn = $conn;
	}

	public function getConn()
	{
		return $this->_conn;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->_user;
	}

	public function auth($token)
	{
		if($this->_user) return false;

        $now = time();
		$decrypted = Crypt::decrypt($token);
		list($date, $user_id, $time) = explode('|', $decrypted);
        $user_id = (int)$user_id;

        if(isset(static::$userIds[$user_id])) return 1;
		if(abs(strtotime($date . ' ' . $time) - $now) > 10) return 2;
		elseif(!($user = User::find($user_id))) return 3;

        static::$userIds[$user_id] = $this;
		if(!empty($user->avatar))
		{
			$user->avatar = asset('assets/img/upload/avatars/' . $user->avatar);
		}
        $this->_user = $user;

		return 0;
	}

	public function authenticated()
	{
		return !empty($this->_user);
	}
}