<?php
include 'support/constants.php';

spl_autoload_register('classLoader');
session_start();

try {
  $portal = new PortalFront("localhost", "root", "", "bookworm");

  $action = 'showMain';
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  }

  $komunikat = $portal->getMessage();
  if (!$komunikat && $action == 'showLoginForm') {
    $komunikat = 'Wprowadź nazwę i hasło użytkownika';
  }

  switch ($action) {
    case 'login':
      //Obsługa logowania
      break;
    case 'logout':
      //Obsługa wylogowania
      break;
    case 'registerUser':
      //Obsługa rejestracji użytkownika
      break;
    case 'addToBasket':
      //Dodawanie książki do koszyka
      break;
    case 'modifyBasket':
      //Modyfikacja zawartości koszyka
      break;
    case 'saveOrder':
      //Zapis zamówienia w bazie danych
      break;
    default:
      include 'templates/mainTemplate.php';
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit('Portal chwilowo niedostępny');
}

function classLoader($nazwa)
{
  if (file_exists("klasy/$nazwa.php")) {
    require_once("klasy/$nazwa.php");
  } else {
    throw new Exception("Brak pliku z definicją klasy.");
  }
}
