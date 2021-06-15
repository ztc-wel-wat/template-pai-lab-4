-- Utworzenie bazy danych
CREATE DATABASE bookworm DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci;
-- Utworzenie wymaganych tabel w DB.
CREATE TABLE Ksiazki( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `WydawnictwoId` INTEGER NOT NULL, 
    `Tytul` VARCHAR(100) NOT NULL, `ISBN` VARCHAR(13), `Rok wydania` YEAR, 
    `Opis` TEXT, `Cena` DECIMAL(6,2));
CREATE TABLE Autorzy( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `Nazwa` VARCHAR(100) NOT NULL);
CREATE TABLE KsiazkiAutorzy( 
    `KsiazkaId` INTEGER NOT NULL, `AutorId` INTEGER NOT NULL, 
    PRIMARY KEY(`KsiazkaId`, `AutorId`));
CREATE TABLE Wydawnictwa( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `Nazwa` VARCHAR(100) NOT NULL, 
    `Adres` VARCHAR(100));
CREATE TABLE Klienci( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `Imie` VARCHAR(45) NOT NULL, 
    `Nazwisko` VARCHAR(45) NOT NULL, `Ulica` VARCHAR(80) NOT NULL, `Nr domu` VARCHAR(5) NOT NULL, 
    `Nr mieszkania` VARCHAR(5), `Miasto` VARCHAR(60) NOT NULL, `Kod` VARCHAR(6) NOT NULL, 
    `Kraj` VARCHAR(45) NOT NULL);
CREATE TABLE Zamowienia( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `KlientId` INTEGER NOT NULL, 
    `Data wprowadzenia` DATETIME NOT NULL, `Data realizacji` DATE, `Status` INTEGER NOT NULL);
CREATE TABLE KsiazkiZamowienia( 
    `KsiazkaId` INTEGER NOT NULL, `ZamowienieId` INTEGER NOT NULL, `Ilosc` INTEGER NOT NULL,
    `Cena` DECIMAL(6,2) NOT NULL, PRIMARY KEY(`KsiazkaId`, `ZamowienieId`));
CREATE TABLE Opinie( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `KsiazkaId` INTEGER NOT NULL, 
    `KlientId` INTEGER NOT NULL, `Ocena` ENUM ('1', '2', '3', '4', '5', '6'), `Opinia` TEXT);
CREATE TABLE Recenzje( 
    `Id` INTEGER AUTO_INCREMENT PRIMARY KEY, `KsiazkaId` INTEGER NOT NULL, `Autor` VARCHAR(60), 
    `Zrodlo` VARCHAR(100), `Recenzja` TEXT NOT NULL);
CREATE TABLE AutorzyPseudonimy( 
    `AutorId1` INTEGER NOT NULL, `AutorId2` INTEGER NOT NULL, 
    PRIMARY KEY(`AutorId1`, `AutorId2`));

-- Modyfikacja tabel w celu rozszerzenia funkcjonalności
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
ADD CONSTRAINT `KsiazkiZamowieniaZamowienieIdFK` FOREIGN KEY (`ZamowienieId`) REFERENCES 
Zamowienia(`Id`);
ALTER TABLE KsiazkiZamowienia 
ADD CONSTRAINT `KsiazkiZamowieniaKsiazkaIdFK` FOREIGN KEY (`KsiazkaId`) REFERENCES Ksiazki(`Id`);

-- Dodanie początkowej zawartości do tabel.

INSERT INTO Autorzy
VALUES (1, 'Orson Scott Card'),
    (2, 'Robin Hobb'),
    (3, 'Alex Kava'),
    (4, 'Harlan Coben'),
    (5, 'Megan Lindholm'),
    (6, 'Kathryn Kidd');

INSERT INTO Wydawnictwa
VALUES (1, 'Prószyński i S-ka', NULL),
    (2, 'Mag', NULL),
    (3, 'Ace Books', NULL),
    (4, 'Arlekin', NULL),
    (5, 'Albatros', NULL);

INSERT INTO Ksiazki
VALUES (        1,
        2,
        'Uczeń skrytobójcy',
        '8371800738',
        1997,
        '',
        29.90
    ),
    (
        2,
        2,
        'Królewski skrytobójca',
        '8371806981',
        1997,
        '',
        32.00
    ),
    (
        3,
        1,
        'Gra Endera',
        '8372557675',
        1994,
        '',
        24.50
    ),
    (
        4,
        1,
        'Zadomowienie',
        '8372554129',
        2000,
        '',
        18.50
    ),
    (
        5,
        2,
        'Uczeń skrytobójcy',
        '8389004976',
        2005,
        '',
        31.00
    ),
    (
        6,
        2,
        'Misja Błazna',
        '8389004917',
        2004,
        '',
        35.00
    ),
    (
        7,
        3,
        'The Windsingers',
        '0441892485',
        1984,
        '',
        24.00
    ),
    (
        8,
        3,
        'The Limbreth Gate',
        '0441483585',
        1984,
        '',
        21.95
    ),
    (
        9,
        3,
        'Wolf\'s Brother',
        '0441712347',
        1988,
        '',
        14.90
    ),
    (
        10,
        4,
        'Dotyk zła',
        '8323805547',
        2003,
        '',
        24.99
    ),
    (
        11,
        4,
        'Łowca dusz',
        '8323805547',
        2004,
        '',
        24.99
    ),
    (
        12,
        5,
        'Bez pożegnania',
        '8387834238',
        2004,
        '',
        19.00
    ),
    (
        13,
        5,
        'Najczarniejszy strach',
        '8388722239',
        2004,
        '',
        18.90
    ),
    (
        14,
        5,
        'Jeden fałszywy ruch',
        '8388722220',
        2004,
        '',
        22.00
    ),
    (
        15,
        1,
        'Lovelock',
        '8371801025',
        '1997',
        '',
        18.50
    );

INSERT INTO KsiazkiAutorzy
VALUES (3, 1),
    (4, 1),
    (1, 2),
    (2, 2),
    (5, 2),
    (6, 2),
    (10, 3),
    (11, 3),
    (12, 4),
    (13, 4),
    (14, 4),
    (7, 5),
    (8, 5),
    (9, 5),
    (15, 6),
    (15, 1);

INSERT INTO Klienci
VALUES (
        1,
        'Jan',
        'Kowalski',
        'Dworcowa',
        '1',
        '20',
        'Wrocław',
        '00-001',
        'Polska'
    ),
    (
        2,
        'Andrzej',
        'Nowak',
        'Majowa',
        '10',
        NULL,
        'Poznań',
        '00-002',
        'Polska'
    ),
    (
        3,
        'Janusz',
        'Malinowski',
        'Arkuszowa',
        '18',
        '5',
        'Szczecin',
        '00-003',
        'Polska'
    ),
    (
        4,
        'Marek',
        'Zieliński',
        'Kołowa',
        '15',
        NULL,
        'Łódź',
        '00-004',
        'Polska'
    ),
    (
        5,
        'Karol',
        'Rydzewski',
        'Bratkowa',
        '51',
        '8',
        'Kraków',
        '00-005',
        'Polska'
    ),
    (
        6,
        'Michał',
        'Nowak',
        'Galicyjska',
        '1',
        '2',
        'Lublin',
        '00-006',
        'Polska'
    ),
    (
        7,
        'Krzysztof',
        'Markowski',
        'Aluzyjna',
        '9',
        NULL,
        'Białystok',
        '00-007',
        'Polska'
    ),
    (
        8,
        'Marek',
        'Maj',
        'Kolejowa',
        '12',
        '1',
        'Gdańsk',
        '00-008',
        'Polska'
    ),
    (
        9,
        'Aleksander',
        'Kowalski',
        'Dolna',
        '21',
        '10',
        'Poznań',
        '00-009',
        'Polska'
    ),
    (
        10,
        'Adam',
        'Janowski',
        'Boczna',
        '1',
        '21',
        'Lublin',
        '00-010',
        'Polska'
    );

INSERT INTO Zamowienia
VALUES (1, 1, '2017-01-03', '2014-01-05', 1),
    (2, 1, '2017-05-10', NULL, 0),
    (3, 2, '2017-02-05', '2014-02-06', 1),
    (4, 3, '2017-04-29', NULL, 0),
    (5, 3, '2017-05-02', NULL, 0),
    (6, 4, '2017-02-23', '2014-02-26', 1),
    (7, 4, '2017-03-15', '2014-03-18', 1),
    (8, 4, '2017-04-03', '2014-04-08', 1),
    (9, 4, '2017-05-22', NULL, 0),
    (10, 5, '2017-05-24', NULL, 0),
    (11, 6, '2017-05-18', '2014-05-20', 1),
    (12, 7, '2017-05-04', '2014-05-08', 1),
    (13, 8, '2017-03-03', '2014-03-04', 1),
    (14, 8, '2017-05-21', NULL, 0),
    (15, 9, '2017-02-02', '2014-02-10', 1),
    (16, 10, '2017-01-05', '2014-01-08', 1);

INSERT INTO KsiazkiZamowienia
VALUES (1, 1, 1, 29.90),
    (3, 1, 1, 24.50),
    (15, 2, 1, 18.50),
    (1, 2, 1, 31.00),
    (8, 3, 1, 21.95),
    (2, 3, 1, 32.00),
    (9, 4, 1, 14.90),
    (1, 4, 1, 29.90),
    (7, 5, 1, 24.00),
    (4, 6, 2, 18.50),
    (12, 6, 1, 19.00),
    (14, 6, 1, 22.00),
    (3, 7, 1, 24.50),
    (9, 8, 1, 14.90),
    (1, 9, 2, 29.90),
    (2, 9, 1, 32.00),
    (15, 9, 1, 18.50),
    (1, 10, 1, 31.00),
    (15, 11, 2, 17.50),
    (3, 12, 2, 24.50),
    (4, 12, 1, 18.50),
    (12, 13, 1, 19.00),
    (13, 13, 1, 18.90),
    (14, 13, 1, 22.00),
    (10, 14, 1, 24.99),
    (9, 15, 1, 14.90),
    (2, 16, 1, 32.00),
    (5, 16, 1, 31.00),
    (6, 16, 1, 35.00),
    (11, 16, 1, 24.99);
    
INSERT INTO AutorzyPseudonimy
VALUES (5, 2);


ALTER TABLE Klienci ADD COLUMN `Email` VARCHAR(245) UNIQUE;
ALTER TABLE Klienci ADD COLUMN `Haslo` VARCHAR(100) NOT NULL;
ALTER TABLE Klienci CHANGE COLUMN `Nr domu` `Nr_domu` VARCHAR(5) NOT NULL;
ALTER TABLE Klienci CHANGE COLUMN `Nr mieszkania` `Nr_mieszkania` VARCHAR(5);
ALTER TABLE Klienci CHANGE COLUMN `Miasto` `Miejscowosc` VARCHAR(60) NOT NULL;

SELECT `Id`, `Imie`, `Nazwisko`, `Haslo` FROM Kliecni WHERE `Email`='$email'

UPDATE klienci SET Email = "jankowalski@wat.edu.pl", Haslo = "haslo1234" WHERE Id = 1
SELECT COUNT(*) FROM Klienci WHERE Email="adres";