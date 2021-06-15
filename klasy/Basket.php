<?php
class Basket
{
	private $dbo = null;

	function __construct($dbo)
	{
		$this->dbo = $dbo;
		if (!isset($_SESSION['basket']))
			$_SESSION['basket'] = array();
	}

	function add()
	{
		// Sprawdzenie poprawności parametru id
		if (!isset($_GET['id'])) {
			return FORM_DATA_MISSING;
		}
		if (($id = (int) $_GET['id']) < 1) {
			return INVALID_ID;
		}
		// Sprawdzenie, czy istnieje książka o podanym id
		$query = "SELECT Cena FROM ksiazki WHERE id=$id";
		if (($cena = $this->dbo->getQuerySingleResult($query)) === false) {
			return INVALID_ID;
		}
		// Zapisanie identyfikatora książki w koszyku
		if (isset($_SESSION['basket'][$id])) {
			$_SESSION['basket'][$id]->ile++;
			$_SESSION['basket'][$id]->cena = $cena;
		} else {
			$_SESSION['basket'][$id] = new BasketItem($id, $cena, 1);
		}
		return ACTION_OK;
	}

	function show($title, $allowModify = true)
	{
		if (count($_SESSION['basket']) == 0) {
			$komunikat = 'Koszyk jest pusty.';
		} else { // Pobranie listy identyfikatorów dla warunku zapytania
			$ids = implode(',', array_keys($_SESSION['basket']));
			// Pobranie danych dotyczących książek z koszyka
			$query = 'SELECT `Id`, `Tytul`, `Cena` FROM ksiazki WHERE `Id` IN(' . $ids . ') ORDER BY `Tytul`';
			// Tutaj można sprawdzić, czy nie zmieniły się ceny książek
			if ($books = $this->dbo->query($query)) {
				$basket = $_SESSION['basket'];
				$komunikat = false;
			} else
				$komunikat = "Błąd serwera. Zawartość koszyka nie jest dostępna.";
		}
		include 'templates/basket.php';
	}

	function modify()
	{
		foreach ($_SESSION['basket'] as $id => $item) {
			if (!isset($_POST[$id]))
				unset($_SESSION['basket'][$id]);
			else if ($_POST[$id] < 1)
				unset($_SESSION['basket'][$id]);
			else
				$item->ile = (int) $_POST[$id];
		}
	}

	function saveOrder(&$orderId)
	{
        if (count($_SESSION['basket']) < 1) // Sprawdzenie, czy koszyk ma zawartość
			return EMPTY_BASKET;
		if (!isset($_SESSION['zalogowany'])) // Sprawdzenie, czy użytkownik jest zalogowany
			return LOGIN_REQUIRED;
		// Pobranie identyfikatorów książek z koszyka
		$ids = implode(',', array_keys($_SESSION['basket']));
		$userId = $_SESSION['zalogowany']->id;
		// Wyłączenie automatycznego zatwierdzania transakcji
		$this->dbo->autocommit(false);
		// Utworzenie nowego zamówienia
		$query = "INSERT INTO zamowienia VALUES(0, $userId, NOW(), NULL, 0)";
		if (!$this->dbo->query($query))
			return SERVER_ERROR;
		if (($orderId = $this->dbo->insert_id) < 1)
			return SERVER_ERROR;
		$query = "INSERT INTO ksiazkiZamowienia VALUES";
		foreach ($_SESSION['basket'] as $item) {
			$id = $item->id;
			$cena = $item->cena;
			$ile = $item->ile;
			$query .= "($id, $orderId, $ile, $cena),";
		}
		$query[strlen($query) - 1] = ' ';
		// Jeśli nie udało się wykonać zapytania
		if (!$this->dbo->query($query)) {
			return SERVER_ERROR;
		}
		// Jeśli liczba dodanych rekordów mniejsza niż liczba produktów w koszyku
		if ($this->dbo->affected_rows != count($_SESSION['basket'])) {
			return SERVER_ERROR;
		}
		$this->dbo->commit(); // Zatwierdzenie transakcji
		$_SESSION['basket'] = array(); // Wyczyszczenie koszyka
		return ACTION_OK;
	}
}