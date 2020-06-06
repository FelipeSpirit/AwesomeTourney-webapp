<?php

class Person{
	protected $id;
	protected $nickname;
	protected $name;
	protected $last_name;
	protected $phone;
	protected $email;

	function __construct($id=null,$nickname=null,$name=null, $last_name=null, $phone=null, $email=null){
		$this->id=$id;
		$this->nickname=$nickname;
		$this->name=$name;
		$this->last_name=$last_name;
		$this->phone=$phone;
		$this->email=$email;
	}

	public function getId(){
		return $this->id;
	}

	public function getNickname(){
		return $this->nickname;
	}

}