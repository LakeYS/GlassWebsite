<?php
namespace Glass;

class UserObject {
	//public fields will automatically be put into json
	public $username;
	public $blid;
	public $banned;
	public $admin;

	private $verified;
	private $email;

	private $daaHash;

	public function __construct($resource) {
		$this->username = $resource->username;
		$this->blid = intval($resource->blid);
		$this->banned = intval($resource->banned);
		$this->admin = intval($resource->admin);
		$this->verified = intval($resource->verified);
		$this->email = $resource->email;
		$this->daaHash = $resource->daaHash;
		if(isset($resource->reset)) {
			$this->reset = explode(" ", $resource->reset);
		} else {
			$this->reset = null;
		}
	}

	public function getResetKey() {
		if(isset($this->reset[0])) {
			return $this->reset[0];
		} else {
			return false;
		}
	}

	public function getResetTime() {
		if(isset($this->reset[1])) {
			return $this->reset[1];
		} else {
			return false;
		}
	}

	public function getName() {
		return $this->getUserName();
	}

	public function getUserName() {
		return $this->username;
	}

	public function getID() {
		return $this->getBLID();
	}

	public function getBLID() {
		return $this->blid;
	}

	public function getBanned() {
		return $this->banned;
	}

	public function getAdmin() {
		return $this->admin;
	}

	public function getVerified() {
		return $this->verified;
	}

	public function getEmail() {
		return $this->email;
	}

	public function isMigrated() {
		return $this->getEmail() != null;
	}

	public function inGroup($name) {
		require_once(realpath(dirname(__FILE__) . '/GroupObject.php'));
		$groups = GroupManager::getGroupsFromBLID($this->blid);
		foreach($groups as $gid) {
			$group = GroupManager::getFromId($gid);
			if($group->getName() == $name) {
				return true;
			}
		}
		return false;
	}

	//this should be done in the UserManager class
	//the *Object classes are just for data storage
	//make sure this also checks for whether that blid is already verified with a different email
	public function setVerified($bool) {
		NotificationManager::createNotification($this, "Your account was verified.", array());
		$database = new DatabaseManager();
		$database->query("UPDATE `users` SET `verified`='" . $database->sanitize($bool) . "' WHERE `email`='" . $database->sanitize($this->getEmail()) . "'");
	}

	public function setUsername($name) {
		if($this->verified) {
			$database = new DatabaseManager();
			$database->query("UPDATE `users` SET `username`='" . $database->sanitize($name) . "' WHERE `email`='" . $database->sanitize($this->getEmail()) . "'");

		}
	}

	public function updateEmail($email) {
		$database = new DatabaseManager();
		$database->query("UPDATE `users` SET `email`='" . $database->sanitize($email) . "' WHERE `blid`='" . $database->sanitize($this->getBlid()) . "'");
		$this->email = $email;
	}

	public function getDAAHash() {
		return $this->daaHash;
	}
}
?>
