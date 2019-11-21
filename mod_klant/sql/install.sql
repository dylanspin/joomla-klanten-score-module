
CREATE TABLE IF NOT EXISTS `#__klantenscore`
(
    `id`                    int(255)      NOT NULL AUTO_INCREMENT,
    `rating`                int(255)  NOT NULL,
    `review`                varchar(255)  NOT NULL,
    `naam`                  varchar(255)  NOT NULL,
    `gem`                   varchar(255)      NOT NULL,
    `aantal`                int(255)      NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `#__klantenscore` (`rating`,`review`,`naam`,`gem`,`aantal`)
             VALUES
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','',''),
                    ('','','','','');
