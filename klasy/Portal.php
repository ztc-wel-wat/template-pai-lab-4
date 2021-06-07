<?php
class Portal
{
  private $dbo = null;

  function __construct($host, $user, $pass, $db)
  {
    $this->dbo = $this->initDB($host, $user, $pass, $db);
  }

  function initDB($host, $user, $pass, $db)
  {
    $dbo = new MyDB($host, $user, $pass, $db);
    if ($dbo->connect_errno) {
      $msg = "Brak połączenia z bazą danych: ";
      $msg .= $dbo->connect_error;
      throw new Exception($msg);
    }
    return $dbo;
  }
}
