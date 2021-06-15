<?php

class PortalFront extends Portal
{
    public $zalogowany = null;

    public function __construct($host, $user, $pass, $db)
    {
        $this->dbo = $this->initDB($host, $user, $pass, $db);
        $this->zalogowany = $this->getActualUser();
    }

    public function getActualUser()
    {
        if (isset($_SESSION['zalogowany'])) {
            return $_SESSION['zalogowany'];
        } else {
            return null;
        }
    }

    public function setMessage($komunikat)
    {
        $_SESSION['komunikat'] = $komunikat;
    }

    public function getMessage()
    {
        if (isset($_SESSION['komunikat'])) {
            $komunikat = $_SESSION['komunikat'];
            unset($_SESSION['komunikat']);

            return $komunikat;
        } else {
            return null;
        }
    }

    public function login()
    {
        // Sprawdzenie czy ustanowiono połączenie z DB
        if (!$this->dbo) {
            return SERVER_ERROR;
        }
        // Sprawdzenie, czy użytkownik już jest zalogowany
        if ($this->zalogowany) {
            return NO_LOGIN_REQUIRED;
        }
        // Sprawdzenie, czy zostały przekazane parametry, a jeżeli tak to ich odczytanie
        if (!isset($_POST['email']) || !isset($_POST['haslo'])) {
            return FORM_DATA_MISSING;
        }
        $user = $_POST['email'];
        $pass = $_POST['haslo'];
        // Sprawdzenie długości przekazanych ciągów dla kodowania utf-8
        $userEmailLength = mb_strlen($user, 'utf8');
        $userPassLength = mb_strlen($pass, 'utf8');
        if ($userEmailLength < 5 || $userEmailLength > 250 || $userPassLength < 6 || $userPassLength > 100) {
            return ACTION_FAILED;
        }
        // Zabezpieczenie znaków specjalnych w parametrach
        $email = $this->dbo->real_escape_string($user);
        $pass = $this->dbo->real_escape_string($pass);
        // Wykonanie zapytania sprawdzającego poprawność danych
        $query = "SELECT `Id`, `Imie`, `Nazwisko`, `Haslo` FROM Klienci WHERE `Email`='$email'";
        if (!$result = $this->dbo->query($query)) {
            $this->setMessage("'Wystąpił błąd: nieprawidłowe zapytanie...");

            return ACTION_FAILED;
        }
        // Sprawdzenie wyników zapytania
        if ($result->num_rows != 1) {
            $this->setMessage('Wystąpił błąd: brak użytkownika o wskazanej nazwie');

            return ACTION_FAILED;
        } else {
            $row = $result->fetch_row(); // Zmiana rekordu do tablicy
      $pass_db = $row[3]; // Odczytanie hasła zapisanego w DB
      if ($pass != $pass_db) {
          $this->setMessage('Wystąpił błąd: podano niepoprawne hasło');

          return ACTION_FAILED;
      } else {
          $nazwa = $row[1].' '.$row[2]; // Utworzenie nazwy użytkownika
          $_SESSION['zalogowany'] = new User($row[0], $nazwa);

          return ACTION_OK;
      }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['zalogowany'])) {
            unset($_SESSION['zalogowany']);
            $this->zalogowany = null;
        }
        session_destroy();
    }

    //4.4

    public function showRegistrationForm()
    {
        $reg = new Registration($this->dbo);

        return $reg->showRegistrationForm();
    }

    public function registerUser()
    {
        $reg = new Registration($this->dbo);

        return $reg->registerUser();
    }
}
