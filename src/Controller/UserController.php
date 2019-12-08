<?php 

class UserController
{

	public $view;
	
	const viewCreate = "view/user/create.php";
	const viewList = "view/user/list.php";
	
	public function __construct()
	{
		#code
	}
	
	public function create()
	{
		$this->view = self::viewCreate;
	}
	
	public function createCommit()
	{
	
		$name = isset($_POST["name"]) ? $_POST["name"] : false;
		
		$email = isset($_POST["email"]) ? $_POST["email"] : false;
		
		try{
			
			if(!$name)
				throw new Exception("Preencha o campo nome");
			
			if(!$email)
				throw new Exception("Preencha o campo email");
				
			$user = new User();
			
			$user->setName($name);
			$user->setEmail($email);
			
			$_SESSION["users"] = $user;
			
			
			$this->view = self::viewList;
			
			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
		
			
		
		
	}
	
	public function listUsers()
	{
		$this->view = self::viewList;
	}
	
}