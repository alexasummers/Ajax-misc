DROP TABLE IF EXISTS dbEvent;

CREATE TABLE IF NOT EXISTS `dbEvent` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StartDate` datetime DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


INSERT INTO `dbEvent` (`ID`, `StartDate`, `Duration`, `Name`, `color`) VALUES
(1, '2020-11-29 08:00:00', 4, 'Conference', 'red'),
(2, '2020-12-02 10:00:00', 2, 'UMKC', 'blue'),
(3, '2020-12-03 11:00:07', 3, 'Meeting', 'red'),
(5, '2020-12-05 08:00:00', 2, 'Breakfast', 'green');

