<?php
class Registration{
    private $dbo = null;
    private $fields = array();

    public function __construct($dbo) {
        $this->dbo = $dbo;
        $this->initFields();
    }

    public function initFields(){
        $this->fields['email'] = new FormInput('email', 'Adres e-mail');
        $this->fields['haslo'] = new FormInput('haslo', 'Hasło', '', 'password');
        $this->fields['haslo2'] = new FormInput('haslo2', 'Powtórz hasło');
        $this->fields['imie'] = new FormInput('imie', 'Imię');
        $this->fields['nazwisko'] = new FormInput('nazwisko', 'Nazwisko');
        $this->fields['ulica'] = new FormInput('ulica', 'Ulica');
        $this->fields['nr_domu'] = new FormInput('nr_domu', 'Numer domu');
        $this->fields['nr_mieszkania'] =
          new FormInput('nr_mieszkania', 'Numer mieszkania', '', 'text', false);
        $this->fields['miejscowosc'] = new FormInput('miejscowosc', 'Miejscowość');
        $this->fields['kod'] = new FormInput('kod', 'Kod pocztowy');
        $this->fields['kraj'] = new FormInput('kraj', 'Kraj');
}

    public function showRegistrationForm() { }
    public function registerUser() { }
}
