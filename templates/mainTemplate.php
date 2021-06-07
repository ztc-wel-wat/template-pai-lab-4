<?php if (!isset($portal)) die(); ?>
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
        <div>Jesteś zalogowany jako: <?= $portal->zalogowany->nazwa ?></div>
        <div><a href="index.php?action=logout">Wylogowanie</a></div>
      <?php else : ?>
        <div>Nie jesteś zalogowany.</div>
        <div><a href="index.php?action=showLoginForm">Logowanie</a></div>
      <?php endif ?>
    </div>
  </div>

  <div id="centerDiv" class="scafoldingDiv">
    <div id="mainContentDiv">

      <?php if ($komunikat) : ?>
        <div class="komunikat"><?= $komunikat; ?></div>
      <?php endif; ?>

      <?php
      switch ($action):
        case 'showLoginForm':
          //Wyświetlenie formularza logowania
          break;
        case 'showRegistrationForm':
          //Wyświetlenie formularza wyszukiwania
          break;
        case 'showSearchForm':
          //Wyświetlenie formularza rejestracyjnego
          break;
        case 'searchBook':
          //Wyszukanie książki
          break;
        case 'showBookDetails':
          //Wyświetlenie szczegółowych informacji o książce
          break;
        case 'showBasket':
          //Wyświetlenie zawartości koszyka
          break;
        case 'checkout':
          //Wyświetlenie podsumowania zamówienia
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