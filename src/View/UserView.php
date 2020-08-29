<?php

class UserView
{
	public function __construct(){}
	
	public function getIndexRoute()
	{
		return 'user/index.php';
	}
	public function getCreateRoute()
	{
		return 'user/create.php';
	}
	
	public function getPassRoute()
	{
		return 'user/pass.php';
	}	
	
	public function getListRoute()
	{
		return 'user/list.php';
	}
	public function getUpdateRoute()
	{
		return 'user/update.php';
	}
	public function getAuthenticateRoute()
	{
		return 'index/index.php';
	}
	public function getUpdatePasswordRoute()
	{
		return 'user/updatePassword.php';
	}
}