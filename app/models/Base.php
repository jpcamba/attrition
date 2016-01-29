<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	* The identifier for the authentication.
	*
	* @var key
	*/
	public function getAuthIdentifier() {
		return $this->getKey();
	}

	/**
	* The password of the authenticated user.
	*
	* @var string
	*/
	public function getAuhthPassword() {
		return $this->password;
	}

	/**
	* The token of the remember element of the session.
	*
	* @var int
	*/
	public function getRememberToken() {
		return $this->remember_token;
	}

	/**
	* Set the value of the token of the remember element of the session.
	*
	* @var int
	*/
	public function setRememberToken($value) {
		$this->remember_token = $value;
	}

	/**
	* Get the name of the token of the remember element of the session.
	*
	* @var string
	*/
	public function getRememberTokenName() {
		return "remember_token";
	}

	/**
	* The email address of the authenticated user.
	*
	* @var string
	*/
	public function getReminderEmail() {
		return $this->email;
	}

}
