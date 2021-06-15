-- Utworzenie bazy danych
-- Utworzenie wymaganych tabel w DB.
-- Modyfikacja tabel w celu rozszerzenia funkcjonalności
-- Dodanie początkowej zawartości do tabel.
CREATE TABLE Ksiazki(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `WydawnictwoId` INTEGER NOT NULL,
    `Tytul` VARCHAR(100) NOT NULL,
    `ISBN` VARCHAR(13),
    `Rok wydania` YEAR,
    `Opis` TEXT,
    `Cena` DECIMAL(6, 2)
);
CREATE TABLE Autorzy(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `Nazwa` VARCHAR(100) NOT NULL
);
CREATE TABLE KsiazkiAutorzy(
    `KsiazkaId` INTEGER NOT NULL,
    `AutorId` INTEGER NOT NULL,
    PRIMARY KEY(`KsiazkaId`, `AutorId`)
);
CREATE TABLE Wydawnictwa(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `Nazwa` VARCHAR(100) NOT NULL,
    `Adres` VARCHAR(100)
);
CREATE TABLE Klienci(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `Imie` VARCHAR(45) NOT NULL,
    `Nazwisko` VARCHAR(45) NOT NULL,
    `Ulica` VARCHAR(80) NOT NULL,
    `Nr domu` VARCHAR(5) NOT NULL,
    `Nr mieszkania` VARCHAR(5),
    `Miasto` VARCHAR(60) NOT NULL,
    `Kod` VARCHAR(6) NOT NULL,
    `Kraj` VARCHAR(45) NOT NULL
);
CREATE TABLE Zamowienia(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `KlientId` INTEGER NOT NULL,
    `Data wprowadzenia` DATETIME NOT NULL,
    `Data realizacji` DATE,
    `Status` INTEGER NOT NULL
);
CREATE TABLE KsiazkiZamowienia(
    `KsiazkaId` INTEGER NOT NULL,
    `ZamowienieId` INTEGER NOT NULL,
    `Ilosc` INTEGER NOT NULL,
    `Cena` DECIMAL(6, 2) NOT NULL,
    PRIMARY KEY(`KsiazkaId`, `ZamowienieId`)
);
CREATE TABLE Opinie(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `KsiazkaId` INTEGER NOT NULL,
    `KlientId` INTEGER NOT NULL,
    `Ocena` ENUM ('1', '2', '3', '4', '5', '6'),
    `Opinia` TEXT
);
CREATE TABLE Recenzje(
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `KsiazkaId` INTEGER NOT NULL,
    `Autor` VARCHAR(60),
    `Zrodlo` VARCHAR(100),
    `Recenzja` TEXT NOT NULL
);
CREATE TABLE AutorzyPseudonimy(
    `AutorId1` INTEGER NOT NULL,
    `AutorId2` INTEGER NOT NULL,
    PRIMARY KEY(`AutorId1`, `AutorId2`)
);
ALTER TABLE AutorzyPseudonimy
ADD CONSTRAINT `AutorzyPseudonimyAutorId1FK` FOREIGN KEY (`AutorId1`) REFERENCES Autorzy(`Id`);
ALTER TABLE AutorzyPseudonimy
ADD CONSTRAINT `AutorzyPseudonimyAutorId2FK` FOREIGN KEY (`AutorId2`) REFERENCES Autorzy(`Id`);
ALTER TABLE Opinie
ADD INDEX `OpinieKsiazkaIdInd` (`KsiazkaId`);
ALTER TABLE Opinie
ADD INDEX `OpinieKlientIdInd` (`KlientId`);
ALTER TABLE Opinie
ADD CONSTRAINT `OpinieKsiazkaIdFK` FOREIGN KEY (`KsiazkaId`) REFERENCES Ksiazki(`Id`);
ALTER TABLE Opinie
ADD CONSTRAINT `OpinieKlientIdFK` FOREIGN KEY (`KlientId`) REFERENCES Klienci(`Id`);
ALTER TABLE KsiazkiAutorzy
ADD CONSTRAINT `KsiazkiAutorzyKsiazkaIdFK` FOREIGN KEY (`KsiazkaId`) REFERENCES Ksiazki(`Id`);
ALTER TABLE KsiazkiAutorzy
ADD CONSTRAINT `KsiazkiAutorzyAutorIdFK` FOREIGN KEY (`AutorId`) REFERENCES Autorzy(`Id`);
ALTER TABLE Recenzje
ADD INDEX `RecenzjeKsiazkaIdInd` (`KsiazkaId`);
ALTER TABLE Recenzje
ADD CONSTRAINT `RecenzjeKsiazkaIdFK` FOREIGN KEY (`KsiazkaId`) REFERENCES Ksiazki(`Id`);
ALTER TABLE Ksiazki
ADD INDEX `KsiazkiWydawnictwoIdInd` (`WydawnictwoId`);
ALTER TABLE Ksiazki
ADD CONSTRAINT `KsiazkiWydawnictwoIdFK` FOREIGN KEY (`WydawnictwoId`) REFERENCES Wydawnictwa(`Id`);
ALTER TABLE Zamowienia
ADD INDEX `ZamowieniaKlientIdInd` (`KlientId`);
ALTER TABLE Zamowienia
ADD CONSTRAINT `ZamowieniaKlientIdFK` FOREIGN KEY (`KlientId`) REFERENCES Klienci(`Id`);
ALTER TABLE KsiazkiZamowienia
ADD CONSTRAINT `KsiazkiZamowieniaZamowienieIdFK` FOREIGN KEY (`ZamowienieId`) REFERENCES Zamowienia(`Id`);
ALTER TABLE KsiazkiZamowienia
ADD CONSTRAINT `KsiazkiZamowieniaKsiazkaIdFK` FOREIGN KEY (`KsiazkaId`) REFERENCES Ksiazki(`Id`);