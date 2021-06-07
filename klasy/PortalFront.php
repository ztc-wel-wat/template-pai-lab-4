<?php
class PortalFront extends Portal
{
  public $zalogowany = null;
  
  function __construct($host, $user, $pass, $db)
  {
    $this->dbo = $this->initDB($host, $user, $pass, $db);
    $this->zalogowany = $this->getActualUser();
  }
  
  function getActualUser()
  {
    //Treść meotdy getActualUser
  }
  
  function setMessage($komunikat)
  {
    //Treść meotdy setMessage
  }
  
  function getMessage()
  {
    //Treść meotdy getMessage
  }

  function login()
  {
    //Treść meotdy login
  }
  
  function logout()
  {
    //Treść meotdy logout
  }
  
  //Tutaj pozostałe metody klasy
}
?>