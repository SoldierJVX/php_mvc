<?php

class User
{
  private $id;
  private $name;
  private $email;
  private $password;
  private $active;
  
  public function __construct() { }
  
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getPassword()
  {
    return $this->password;
  }
  public function getActive()
  {
    return $this->active;
  }
  public function setPassword($password)
  {
    $this->password = $password;
  }
  public function setEmail($email)
  {
    $this->email = $email;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function setActive($active)
  {
    $this->active = $active;
  }
}