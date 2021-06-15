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

  function login() {
      // Sprawdzenie czy ustanowiono połączenie z DB
      if (!$this->dbo)
        return SERVER_ERROR;
      // Sprawdzenie, czy użytkownik już jest zalogowany
      if ($this->zalogowany)
        return NO_LOGIN_REQUIRED;
      // Sprawdzenie, czy zostały przekazane parametry, a jeżeli tak to ich odczytanie
      if (!isset($_POST["email"]) || !isset($_POST["haslo"]))
        return FORM_DATA_MISSING;
      
      $user = $_POST["email"];
      $pass = $_POST["haslo"];
      // Sprawdzenie długości przekazanych ciągów dla kodowania utf-8
      $userEmailLength = mb_strlen($user, 'utf8');
      $userPassLength = mb_strlen($pass, 'utf8');
      if ($userEmailLength < 5 || $userEmailLength > 250 || $userPassLength < 6 || $userPassLength > 100)
        return ACTION_FAILED;

      // Zabezpieczenie znaków specjalnych w parametrach
      $email = $this->dbo->real_escape_string($user);
      $pass = $this->dbo->real_escape_string($pass);
      // Wykonanie zapytania sprawdzającego poprawność danych
      $query = "SELECT `Id`, `Imie`, `Nazwisko`, `Haslo` FROM klienci WHERE `Email`='$email'";
      if (!$result = $this->dbo->query($query)) {
        $this->setMessage("'Wystąpił błąd: nieprawidłowe zapytanie...");
        return ACTION_FAILED;
      }
      // Sprawdzenie wyników zapytania
      if ($result->num_rows <> 1) {
        $this->setMessage("Wystąpił błąd: brak użytkownika o wskazanej nazwie");
        return ACTION_FAILED;
      } else {
          $row = $result->fetch_row(); // Zmiana rekordu do tablicy
          $pass_db = $row[3]; // Odczytanie hasła zapisanego w DB
          if ($pass != $pass_db) {
          $this->setMessage("Wystąpił błąd: podano niepoprawne hasło");
          return ACTION_FAILED;
        } else {
            $nazwa = $row[1] . ' ' . $row[2]; // Utworzenie nazwy użytkownika
            $_SESSION['zalogowany'] = new User($row[0], $nazwa);
            return ACTION_OK;
          }
      }
  }
  
  function logout() {
    if (isset($_SESSION['zalogowany'])) {
      unset($_SESSION['zalogowany']);
      $this->zalogowany = null;
    }
    session_destroy();
   }
  
   function showRegistrationForm(){
    $reg = new Registration($this->dbo);
    return $reg->showRegistrationForm();
   }
   function registerUser(){
    $reg = new Registration($this->dbo);
    return $reg->registerUser();
   }

   function showSearchForm() {
    $autor = filter_input(INPUT_GET, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
    $tytul = filter_input(INPUT_GET, 'tytul', FILTER_SANITIZE_SPECIAL_CHARS);
    include 'templates/searchForm.php';
   }

   function showSearchResult() {
    // Określenie warunku dla autora
    if (isset($_GET['autor']) && $_GET['autor'] != '') {
      // Tu lub po przefiltrowaniu dodatkowa weryfikacja poprawności parametru
      $autor = filter_input(INPUT_GET, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
      $cond1 = " AND a.`Nazwa` LIKE '%" . $autor . "%' ";
      } else {
      $cond1 = '';
      }
      // Określenie warunku dla tytułu
      if (isset($_GET['tytul']) && $_GET['tytul'] != '') {
      // Tu lub po przefiltrowaniu dodatkowa weryfikacja poprawności parametru
      $tytul = filter_input(INPUT_GET, 'tytul', FILTER_SANITIZE_SPECIAL_CHARS);
      $cond2 = " AND k.`Tytul` LIKE '%" . $tytul . "%' ";
      } else {
      $cond2 = '';
      }
      // Formowanie zapytania
      $query = 'SELECT k.`Tytul`, GROUP_CONCAT(a.`Nazwa`) AS `Autor`, '
      . 'k.`ISBN`, w.`Nazwa` AS `Wydawnictwo`, k.`Cena`, k.`Id` AS `Id` '
      . 'FROM ksiazki k JOIN Wydawnictwa w ON (k.WydawnictwoId = w.Id) '
      . 'JOIN ksiazkiautorzy ka ON (ka.`KsiazkaId` = k.`Id`) '
      . 'JOIN autorzy a ON (ka.`AutorId` = a.`Id`) WHERE 1=1 '
      . $cond1 . $cond2 . 'GROUP BY k.`Id` ORDER BY `Autor`, `Tytul`, `Wydawnictwo`';
      // Wykonanie zapytania i sprawdzenie wyników
      $komunikat = false;
      if (!$result = $this->dbo->query($query))
      $komunikat = 'Wyniki wyszukiwania nie są obecnie dostępne.';
      elseif ($result->num_rows < 1)
      $komunikat = 'Brak książek spełniających podane kryteria.';
      // Wyświetlenie rezultatów wyszukiwania
      include 'templates/searchResults.php';
     }

     function showBookDetails()
  {
    // Sprawdzenie poprawności identyfikatora książki (parametr id)
    if (!isset($_GET['id']) || ($id = intval($_GET['id'])) < 1) {
      $komunikat = 'Brak książki o podanym identyfikatorze.';
    } else { // Formowanie zapytania
      $query = 'SELECT `Tytul`, `ISBN`, `Rok wydania` AS Rok, `Opis`, `Cena`,'
        . 'w.`Nazwa` AS `Wydawnictwo`, GROUP_CONCAT(a.`Nazwa`) AS Autor,'
        . 'k.`Id` AS `Id` FROM ksiazki k '
        . 'JOIN ksiazkiautorzy ka ON (k.`Id`=ka.`KsiazkaId` AND k.id=' . $id . ')'
        . 'JOIN autorzy a ON (a.`Id` = ka.`AutorId`) '
        . 'JOIN wydawnictwa w ON (w.`Id`=k.`WydawnictwoId`) GROUP BY k.`Id`';
      // Umieszczenie wyników zapytania w tabeli
      if ($result = $this->dbo->query($query)) {
        if ($row = $result->fetch_assoc())
          $komunikat = false;
        else
          $komunikat = 'Brak książki o podanym identyfikatorze.';
      } else {
        $komunikat = 'Błąd serwera. Dane szczegółowe nie są dostępne.';
      }
    }
    include 'templates/bookDetails.php';
  }


  function addToBasket()
  {
    $basket = new Basket($this->dbo);
    return $basket->add();
  }

  function showBasket()
  {
    $basket = new Basket($this->dbo);
    $basket->show('Zawartość koszyka', true);
  }

  function modifyBasket()
  {
    $basket = new Basket($this->dbo);
    $basket->modify();
  }
     
  function checkout() {
    if (isset($_SESSION['zalogowany'])) {
    $basket = new Basket($this->dbo);
    $basket->show("podsumowanie zamówienia", false);
    } else
    include 'templates/orderNoLoginInfoDiv.php';
   }
     
}
?>