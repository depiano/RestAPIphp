create Database safe;
use safe;

CREATE TABLE event (
  Code varchar(10) primary key,
  Latitude varchar(10) NOT NULL,
  Longitude varchar(10) NOT NULL,
  Description varchar(50) DEFAULT NULL,
  Disabled tinyint(1) DEFAULT NULL,
  DateHour timestamp NOT NULL
) ;

INSERT INTO event (Code, Latitude, Longitude, Description, Disabled, DateHour) VALUES
('E00', '25.28757', '58.757587', 'Fire in the wood', 0, '2020-03-30 13:48:02'),
('E01', '40.916668', '14.788889', 'Landslide', 1, '2020-03-30 15:42:10'),
('E02', '40.916671', '14.788893', 'Building collpase', 0, '2020-03-27 05:18:45'),
('E10', '199.000', '200.00', 'here are the description', 0, '2020-03-28 20:49:07'),
('E99', '100.000', '300.00', 'The description', 0, '2020-03-30 10:58:51');

CREATE TABLE people (
  Name varchar(20) NOT NULL,
  Surname varchar(20) NOT NULL,
  Email varchar(30) primary key,
  Password varchar(50) NOT NULL,
  Householder varchar(50) DEFAULT NULL,
  Sex char(1) NOT NULL
) ;

INSERT INTO people (Name, Surname, Email, Password, Householder, Sex) VALUES
('Angela', 'De Luca', 'angela@gmail.com', 'okvaben11111e', 'vincenzo@gmail.com', 'F'),
('Antonio', 'De Luca', 'luca@gmail.com', 'antonio', 'vincenzo@gmail.com', 'M'),
('Antonio', 'De Piano', 'antonio@gmail.com', 'antonio', NULL, 'M'),
('Fausto', 'Bruno', 'fausto@gmail.com', 'fausto', NULL, 'M'),
('Marco', 'Rossi', 'marcorossi@gmail.com', 'marco', 'paolorossi@gmail.com', 'M'),
('Maria', 'De Luca', 'mariadeluca@gmail.com', 'maria', 'vincenzo@gmail.com', 'F'),
('Mirko', 'Bevilacqua', 'mirkobevilacqua@gmail.com', 'mirko', 'bevilacqua@gmail.com', 'M'),
('Monica', 'Giallo', 'monicagiallo@gmail.com', 'monica', 'bevilacqua@gmail.com', 'F'),
('Paolo', 'Rossi', 'paolorossi@gmail.com', 'paolo', NULL, 'M'),
('Umberto', 'Bevilacqua', 'umbertobevilacqua@gmail.com', 'umberto', 'bevilacqua@gmail', 'M'),
('Vincenzo', 'Bevilacqua', 'bevilacqua@gmail.com', 'vincenzo', NULL, 'M'),
('Vincenzo', 'De Luca', 'vincenzo@gmail.com', 'vincenzo', NULL, 'M');

CREATE TABLE status (
  EmailUser varchar(30) NOT NULL,
  CodeEvent varchar(10) NOT NULL,
  DateHour timestamp NOT NULL,
  Safe tinyint(1) DEFAULT '1',
  primary key(EmailUser, CodeEvent),
  FOREIGN KEY (EmailUser) REFERENCES people(Email),
  FOREIGN KEY (CodeEvent) REFERENCES event(Code)
) ;


INSERT INTO status (EmailUser, CodeEvent, DateHour, Safe) VALUES
('antonio@gmail.com', 'E00', '2020-03-28 12:39:28', 1),
('fausto@gmail.com', 'E00', '2020-03-28 12:39:28', 1),
('paolorossi@gmail.com', 'E01', '2020-03-27 06:15:14', 1),
('bevilacqua@gmail.com', 'E01', '2020-03-27 06:15:14', 1),
('vincenzo@gmail.com', 'E00', '2020-03-28 12:39:28', 1);

CREATE TABLE building (
  Code varchar(10) primary key,
  Description varchar(50) DEFAULT NULL,
  EmailUser varchar(30) DEFAULT NULL,
  Latitude varchar(20) NOT NULL,
  Longitude varchar(20) NOT NULL,
  FOREIGN KEY (EmailUser) REFERENCES people(Email)
) ;

INSERT INTO building (Code, Description, EmailUser, Latitude, Longitude) VALUES
('B00', 'My house', 'vincenzo@gmail.com', '25.28757', '58.757587'),
('B01', 'My house', 'antonio@gmail.com', '40.916668', '14.788889'),
('B02', 'My house', 'fausto@gmail.com', '40.916671', '14.788893'),
('B03', 'My house', 'paolorossi@gmail.com', '40.916650', '14.788860'),
('B04', 'My house', 'bevilacqua@gmail.com', '40.916665', '14.788865'),
('B05', 'My second house', 'vincenzo@gmail.com', '25.28775', '58.757587');