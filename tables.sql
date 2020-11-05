DROP TABLE IF EXISTS `task`;
DROP TABLE IF EXISTS `user`;

--
-- Table user
--
CREATE TABLE IF NOT EXISTS `user`(
    `id` SMALLINT(4) NOT NULL AUTO_INCREMENT,
    `login` VARCHAR(20) NOT NULL UNIQUE,
    `hash` CHAR(32) NOT NULL,
    `email` VARCHAR(60) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
);

INSERT INTO `user` (`login`, `hash`, `email`) VALUES
('admin', '5d4565b02217e1761d3b981c1f1c6878', 'admin@yandex.ru');

--
-- Table task
--
CREATE TABLE `task`(
    `id` SMALLINT(4) NOT NULL AUTO_INCREMENT,
    `description` TEXT NOT NULL,
    `userName` VARCHAR(50) NOT NULL,
    `email` VARCHAR(60) NOT NULL,
    `status` SMALLINT(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
);