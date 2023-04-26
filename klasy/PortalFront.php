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
    if (isset($_SESSION['zalogowany']))
      return $_SESSION['zalogowany'];
    else
      return null;
  }

  function setMessage($komunikat)
  {
    $_SESSION['komunikat'] = $komunikat;
  }

  function getMessage()
  {
    if (isset($_SESSION['komunikat'])) {
      $komunikat = $_SESSION['komunikat'];
      unset($_SESSION['komunikat']);
      return $komunikat;
    } else 
      return null;
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
