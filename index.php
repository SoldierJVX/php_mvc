<?php 

session_start();

if(isset($_SESSION["users"]))
	$users = $_SESSION["users"];
else
	$users = array();


include ("src/Model/User.php");
include ("src/Controller/UserController.php");

if(isset($_GET["controller"]))
	$controller = $_GET["controller"];
else
	$controller = "UserController";
	
if(isset($_GET["action"]))
	$action = $_GET["action"];
else
	$action = "create";
	
switch($controller)
{
	
	case "UserController":
	
		$userController = new UserController();
		
		switch($action)
		{
			case "createCommit":
				$userController->createCommit();
				break;
				
			case "create":
				$userController->create();
				break;
		}
		
		include($userController->view);
	
		break;
	
}




