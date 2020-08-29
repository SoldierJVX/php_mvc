<?php

class UserDao
{
  const _table = '__user';

  public function __construct() { }

  public function insert($user)
  {
    $db = Database::singleton();

    $sql = 'INSERT INTO '. self::_table .' (name, email, password, active) VALUES (?,?,?,?)';
    
    $sth = $db->prepare($sql);

    $sth->bindValue(1, strtolower(trim ($user->getName())), PDO::PARAM_STR);
    $sth->bindValue(2, trim ($user->getEmail()), PDO::PARAM_STR);
    $sth->bindValue(3, trim (sha1($user->getPassword())), PDO::PARAM_STR);
    $sth->bindValue(4, $user->getActive(), PDO::PARAM_STR);
  
    return $sth->execute();
  }

  public function update($user)
  {  
    $db = Database::singleton();

    $sql = 'UPDATE '. self::_table .' SET name = ?, email = ? WHERE id = ?';
    
    $sth = $db->prepare($sql);

    $sth->bindValue(1, strtolower(trim ($user->getName())), PDO::PARAM_STR);
    $sth->bindValue(2, trim ($user->getEmail()), PDO::PARAM_STR);
    $sth->bindValue(3, $user->getId(), PDO::PARAM_INT);
    
    return $sth->execute();    

  }
	
	 public function activate($id)
	 {  
		$db = Database::singleton();

		$user = $this->getUser($id);

		$sql = 'UPDATE '. self::_table .' SET active = ? WHERE id = ?';

		$sth = $db->prepare($sql);

		$sth->bindValue(1, $user->getActive() == '0' ? '1' : '0' , PDO::PARAM_STR);
		$sth->bindValue(2, $user->getId(), PDO::PARAM_INT);

		$sth->execute(); 
		 
		return $user->getActive() == '0' ? TRUE : FALSE;
	 }

  public function updatePassword($id, $newPassword)
  {  
    $db = Database::singleton();

    $sql = 'UPDATE '. self::_table .' SET password = ? WHERE id = ?';
    
    $sth = $db->prepare($sql);

    $sth->bindValue(1, sha1($newPassword), PDO::PARAM_STR);
    $sth->bindValue(2, $id, PDO::PARAM_INT);
    
    return $sth->execute();    

  }

  public function delete($id)
  {  
    $db = Database::singleton();

    $sql = 'DELETE FROM ' . self::_table . ' WHERE id = ?';
    
    $sth = $db->prepare($sql);

    $sth->bindValue(1, $id, PDO::PARAM_INT);
    
    return $sth->execute();    

  }

  public function getAll()
  {
    
    $db = Database::singleton();

    $sql = 'SELECT * FROM ' . self::_table;
    
    $sth = $db->prepare($sql);

    $sth->execute();

    $users = array();
    
    while($obj = $sth->fetch(PDO::FETCH_OBJ))
    {
      $user = new User();
      $user->setId($obj->id);
      $user->setName($obj->name);
      $user->setEmail($obj->email);
      $user->setActive($obj->active);

      $users[] = $user; 
    }
    
    return $users;  
  }


  public function getUser($id)
  {
    $db = Database::singleton();

    $sql = 'SELECT * FROM ' . self::_table . ' WHERE id = ?';

    $sth = $db->prepare($sql);

    $sth->bindValue(1, $id, PDO::PARAM_STR);

    $sth->execute();

    if($obj = $sth->fetch(PDO::FETCH_OBJ))
    {
      $user = new User();
      $user->setId($obj->id);
      $user->setName($obj->name);
      $user->setPassword($obj->password);
      $user->setEmail($obj->email);
      $user->setActive($obj->active);

      return $user;
    }

    return false;
  }

  public function login($email, $password)
  {
    $db = Database::singleton();

    $sql = 'SELECT * FROM ' . self::_table . ' WHERE email = ? AND password = ?';

    $sth = $db->prepare($sql);

    $sth->bindValue(1, trim(strtolower($email)), PDO::PARAM_STR);
    $sth->bindValue(2, trim($password), PDO::PARAM_STR);

    $sth->execute();

    if($obj = $sth->fetch(PDO::FETCH_OBJ))
    {
      $user = new User();
      $user->setId($obj->id);
      $user->setName($obj->name);
      $user->setPassword($obj->password);
      $user->setEmail($obj->email);
      $user->setActive($obj->active);

      return $user;
    }

    return false;
  }

  public function checkPassword($id, $currentPassword)
  {
    $user = $this->getUser($id);

    if($user->getPassword() == sha1($currentPassword))
      return true;

    return false;

  }


}