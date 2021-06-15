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

  if ($action == 'showLoginForm' && $portal->zalogowany) {
    $portal->setMessage("Najpierw proszę się wylogować");
    header("location:index.php?action=showMain");
    return;
  }

  if (($action == 'showLoginForm' || $action == 'showRegistrationForm' || $action == 'registerUser')
    && $portal->zalogowany
  ) {
    $portal->setMessage("Najpierw proszę się wylogować");
    header("Location:index.php?action=showMain");
    return;
  }

  switch ($action) {
    case 'login': // Obsługa logowania
      switch ($portal->login()) {
        case ACTION_OK:
          $portal->setMessage("Zalogowanie prawidłowe");
          header("Location:index.php?action=showMain");
          return;
        case NO_LOGIN_REQUIRED:
          $portal->setMessage("Najpierw proszę się wylogować");
          header("Location:index.php?action=showMain");
          return;
        case ACTION_FAILED:
        case FORM_DATA_MISSING:
          $portal->setMessage("Błędna nazwa lub hasło użytkownika");
          break;
        default:
          $portal->setMessage("Błąd serwera - zalogowanie nie jest obecnie możliwe");
      }
      header("Location:index.php?action=showLoginForm");
      break;
    case 'logout':
      //Obsługa wylogowania
      $portal->logout();
      header("Location:index.php?action=showMain");
      break;
    case 'registerUser': // Obsługa rejestracji użytkownika
      switch ($portal->registerUser()) {
        case ACTION_OK:
          $portal->setMessage("Rejestracja prawidłowa. Możesz się teraz zalogować.");
          header("Location:index.php?action=showLoginForm");
          return;
        case FORM_DATA_MISSING:
          $portal->setMessage("Proszę wypełnić wszystkie pola formularza!");
          break;
        case PASSWORDS_DO_NOT_MATCH:
          $portal->setMessage("'Hasło musi być takie samo w obu polach!");
          break;
        case USER_NAME_ALREADY_EXISTS:
          $portal->setMessage("Podany adres e-email jest już zarejestrowany!");
          break;
        case ACTION_FAILED:
          $portal->setMessage("Obecnie rejestracja nie jest możliwa.");
          break;
        case SERVER_ERROR:
        default:
          $portal->setMessage("Błąd serwera!");
          break;
      }
      header("Location:index.php?action=showRegistrationForm");
      break;
    case 'addToBasket': // Dodawanie książki do koszyka
      switch ($portal->addToBasket()) {
        case INVALID_ID:
        case FORM_DATA_MISSING:
          $portal->setMessage("Błędny identyfikator książki.");
          break;
        case ACTION_OK:
          $portal->setMessage("Książka została dodana do koszyka.");
          break;
        default:
          $portal->setMessage("Błąd serwera.");
          break;
      }
      header("Location:index.php?action=showBasket");
      break;
    case 'modifyBasket': // Modyfikacja zawartości koszyka
      $portal->setMessage("Zawartość koszyka została uaktualniona");
      $portal->modifyBasket();
      header("Location:index.php?action=showBasket");
      break;
    case 'saveOrder':
      //Zapis zamówienia w bazie danych
      $id = 0;
      $basket = new Basket($portal->dbo);
      switch ($basket->saveOrder($id)):
        case EMPTY_BASKET:
          $portal->setMessage('Koszyk jest pusty.');
          header("Location:index.php?action=showMain");
          return;
        case LOGIN_REQUIRED:
          $portal->setMessage('Najpierw proszę się zalogować');
          break;
        case ACTION_OK:
          $portal->setMessage('Zamówienie zostało złożone. Identyfikator zamówienia: ' . $id);
          header("Location:index.php?action=showMain");
          return;
        case SERVER_ERROR:
        default:
          $portal->setMessage('Błąd servera.');
      endswitch;
      header("Location:index.php?action=checkout");
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