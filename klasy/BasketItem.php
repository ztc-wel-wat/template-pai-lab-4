<?php
class BasketItem {
 public $id;
 public $ile;
 public $cena;
 function __construct($id, $cena, $ile) {
 $this->id = $id;
 $this->cena = $cena;
 $this->ile = $ile;
 }
}