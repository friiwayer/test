SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
--

-- --------------------------------------------------------

--
--

CREATE TABLE IF NOT EXISTS `tst_images` (
  `id` int(155) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `old_path` text NOT NULL,
  `new_path` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=474 ;
