SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `adventure` (
  `uid` char(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `players_min_recommended` int(11) NOT NULL,
  `players_max_recommended` int(11) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `themes` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `rewards` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `player_character` (
  `uid` char(11) NOT NULL,
  `user_uid` char(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `uploaded_sheet` varchar(255) NOT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `validated_sheet` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `player_session` (
  `session_uid` char(11) NOT NULL,
  `player_uid` char(11) NOT NULL,
  `player_character_uid` char(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `session` (
  `uid` char(11) NOT NULL,
  `adventure_uid` char(11) NOT NULL,
  `master_uid` char(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `players_min` int(11) NOT NULL,
  `players_max` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `settings` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `settings` (`id`, `description`, `value`) VALUES
('app_name', 'Título de la aplicación que se muestra en el título de la ventana y en el menú', ''),
('contact_email', 'Email de contacto', ''),
('default_max_players', 'Máximo de jugadores por defecto', ''),
('default_min_players', 'Mínimo de jugadores por defecto', ''),
('default_time', 'Hora por defecto para las sesiones', ''),
('google_client_id', 'google_client_id', ''),
('wiki_link', 'Link de la Wiki', '');

CREATE TABLE `upload_log` (
  `id` int(11) NOT NULL,
  `user_uid` char(11) DEFAULT NULL,
  `directory` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `remote_addr` varchar(255) NOT NULL,
  `http_x_forwarded_for` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `user` (
  `uid` char(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `master` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `banned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `adventure`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `player_character`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `user_uid` (`user_uid`);

ALTER TABLE `player_session`
  ADD PRIMARY KEY (`session_uid`,`player_uid`),
  ADD KEY `player_character_uid` (`player_character_uid`),
  ADD KEY `player_uid` (`player_uid`),
  ADD KEY `session_uid` (`session_uid`);

ALTER TABLE `session`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `adventure_uid` (`adventure_uid`),
  ADD KEY `master_uid` (`master_uid`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `upload_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_uid` (`user_uid`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `upload_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `player_character`
  ADD CONSTRAINT `player_character_ibfk_1` FOREIGN KEY (`user_uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `player_session`
  ADD CONSTRAINT `player_session_ibfk_1` FOREIGN KEY (`session_uid`) REFERENCES `session` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `player_session_ibfk_2` FOREIGN KEY (`player_uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `player_session_ibfk_3` FOREIGN KEY (`player_character_uid`) REFERENCES `player_character` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`adventure_uid`) REFERENCES `adventure` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `session_ibfk_2` FOREIGN KEY (`master_uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `upload_log`
  ADD CONSTRAINT `upload_log_ibfk_1` FOREIGN KEY (`user_uid`) REFERENCES `user` (`uid`) ON DELETE SET NULL ON UPDATE SET NULL;

ALTER TABLE `session` ADD `location` VARCHAR(255) NOT NULL AFTER `time`; 

ALTER TABLE `user` ADD `delete_on` DATE NULL AFTER `banned`;

ALTER TABLE `user` ADD `password` VARCHAR(255) NULL AFTER `admin`;

INSERT INTO `settings` (`id`, `description`, `value`) VALUES ('google_secret', 'google_secret', '');

INSERT INTO `settings` (`id`, `description`, `value`) VALUES ('no_reply_email', 'Email desde el que se enviarán comunicaciones', '');

INSERT INTO `settings` (`id`, `description`, `value`) VALUES ('bcc_email', 'Email al que se enviará copia de los emails enviados a los usuarios', '');

CREATE TABLE `email_setting` (
  `user_uid` char(11) NOT NULL,
  `setting` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`user_uid`,`setting`);

COMMIT;
