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
	}
}
