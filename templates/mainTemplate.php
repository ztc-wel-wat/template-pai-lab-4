<?php if (!isset($portal)) die(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <title>Portal</title>
</head>

<body>

  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
          <use xlink:href="#bootstrap" />
        </svg>
      </a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a class="me-3 py-2 text-dark text-decoration-none" href="index.php">Główna</a> </li>
        <li><a class="me-3 py-2 text-dark text-decoration-none" href="index.php?action=showSearchForm">Szukaj książki</a></li>
        <li><a class="me-3 py-2 text-dark text-decoration-none" href="index.php?action=showBasket">Twój koszyk</a> </li>
        <li><a class="me-3 py-2 text-dark text-decoration-none" href="index.php?action=showRegistrationForm">Rejestracja</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <?php if ($portal->zalogowany) : ?>
          <div>Jesteś zalogowany jako: <?= $portal->zalogowany->nazwa ?></div>
          <div><a class="btn btn-outline-primary me-2" href="index.php?action=logout">Wylogowanie</a></div>
        <?php else : ?>
          <div>Nie jesteś zalogowany.</div>
          <div><a class="btn btn-outline-primary me-2" href="index.php?action=showLoginForm">Logowanie</a></div>
        <?php endif ?>
      </div>
    </header>
  </div>

  <div class="container" id="mainContentDiv">

    <?php if ($komunikat) : ?>
      <div class="komunikat"><?= $komunikat; ?></div>
    <?php endif; ?>

    <?php
    switch ($action):
      case 'showLoginForm':
        //Wyświetlenie formularza logowania
        include('templates/loginForm.php');
        break;
      case 'showRegistrationForm':
        //Wyświetlenie formularza wyszukiwania
        $portal->showRegistrationForm();
        break;
      case 'showSearchForm':
        //Wyświetlenie formularza rejestracyjnego
        $portal->showSearchForm();
        break;
      case 'searchBook':
        //Wyszukanie książki
        $portal->showSearchForm();
        $portal->showSearchResults();
        break;
      case 'showBookDetails':
        //Wyświetlenie szczegółowych informacji o książce
        $portal->showBookDetails();
        break;
      case 'showBasket':
        //Wyświetlenie zawartości koszyka
        $portal->showBasket();
        break;
      case 'checkout':
        //Wyświetlenie podsumowania zamówienia
        $portal->checkout();
        break;
      case 'showMain':
      default:
        include 'templates/innerContentDiv.php';
    endswitch;
    ?>
  </div>

  <div id="footerDiv" class="scafoldingDiv">
    <p>Stopka strony</p>
  </div>

</body>

</html>