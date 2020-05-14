<?php

class Person{
	protected $id;
	protected $name;
	protected $last_name;
	protected $phone;
	protected $email;

	function __construct($id,$name=null, $last_name=null, $phone=null, $email=null){
		$this->id=$id;
		$this->name=$name;
		$this->last_name=$last_name;
		$this->phone=$phone;
		$this->email=$email;
	}

	public function getId(){
		return $this->id;
	}


}