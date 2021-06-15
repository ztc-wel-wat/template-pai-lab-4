<?php if (!isset($portal)) {
    die();
} ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Portal</title>
</head>

<body>

  <div id="topDiv" class="scafoldingDiv">
    <div id="headerMainDiv">
      <a href="index.php">Główna</a> |
      <a href="index.php?action=showSearchForm">Szukaj książki</a> |
      <a href="index.php?action=showBasket">Twój koszyk</a> |
      <a href="index.php?action=showRegistrationForm">Rejestracja</a>
    </div>
    <div id="headerUserInfoDiv">
      <?php if ($portal->zalogowany) : ?>
        <div>Jesteś zalogowany jako: <?= $portal->zalogowany->nazwa; ?></div>
        <div><a href="index.php?action=logout">Wylogowanie</a></div>
      <?php else : ?>
        <div>Nie jesteś zalogowany.</div>
        <div><a href="index.php?action=showLoginForm">Logowanie</a></div>
      <?php endif; ?>
    </div>
  </div>

  <div id="centerDiv" class="scafoldingDiv">
    <div id="mainContentDiv">

      <?php if ($komunikat) : ?>
        <div class="komunikat"><?= $komunikat; ?></div>
      <?php endif; ?>

      <?php
      switch ($action):
        case 'showLoginForm': // Wyświetlenie formularza logowania
          include 'templates/loginForm.php';
          break;
        case 'showRegistrationForm': // Wyświetlenie formularza wyszukiwania
          $portal->showRegistrationForm();
          break;
        case 'showBookDetails':
          //Wyświetlenie szczegółowych informacji o książce
          $portal->showBookDetails();
          break;
          case 'showBasket': // Wyświetlenie zawartości koszyka
            $portal->showBasket(); break;

          case 'addToBasket': // Dodawanie książki do koszyka
            switch ($portal->addToBasket()) {
              case INVALID_ID:
                case FORM_DATA_MISSING:
                  $portal->setMessage('Błędny identyfikator książki.');
                  break;
                  case ACTION_OK: $portal->setMessage('Książka została dodana do koszyka.');
                  break; default: $portal->setMessage('Błąd serwera.');
                  break; }
                  header('Location:index.php?action=showBasket');
                  break;
          case 'modifyBasket': // Modyfikacja zawartości koszyka
            $portal->setMessage('Zawartość koszyka została uaktualniona');
            $portal->modifyBasket();
            header('Location:index.php?action=showBasket');
            break;
        case 'checkout':
          //Wyświetlenie podsumowania zamówienia
          break;
        case 'showSearchForm':
          $portal->showSearchForm();
          break;
        case 'searchBook':
          // Wyszukanie książki
          $portal->showSearchForm();
          $portal->showSearchResult();
          break;
        case 'showMain':
        default:
          include 'templates/innerContentDiv.php';
      endswitch;
      ?>
    </div>
  </div>

  <div id="footerDiv" class="scafoldingDiv">
    <p>Stopka strony</p>
  </div>

</body>

</html>