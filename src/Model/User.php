<?php 

class User{

	private $name;
	private $email;
	
	public function __construct(){
		
	}
	
	public function getName(){
		return $name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getEmail(){
		return $email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
}