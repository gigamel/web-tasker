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
('admin', '5d4565b02217e1761d3b981c1f1c6878', 'admin@yandex.ru'),
('user', '03e37af4285fadeb3fc56e7cb5320327', 'user@gmail.com');

--
-- Table task
--
CREATE TABLE `task`(
    `id` SMALLINT(4) NOT NULL AUTO_INCREMENT,
    `description` TEXT,
    `userId` SMALLINT(4),
    `status` SMALLINT(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    CONSTRAINT `user_fk` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
        ON DELETE SET NULL
);

INSERT INTO `task` (`id`, `description`, `userId`, `status`) VALUES
(NULL, 'Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь. Если вам нужен Lorem Ipsum для серьёзного проекта, вы наверняка не хотите какой-нибудь шутки, скрытой в середине абзаца. Также все другие известные генераторы Lorem Ipsum используют один и тот же текст, который они просто повторяют, пока не достигнут нужный объём.', 2, 1),
(NULL, 'Классический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 "de Finibus Bonorum et Malorum" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.', 2, 1),
(NULL, 'Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.', 1, 1),
(NULL, 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации.', 2, 0),
(NULL, 'Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.', 1, 1);