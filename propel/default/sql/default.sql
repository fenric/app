
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- fenric_field
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_field`;

CREATE TABLE `fenric_field`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `tooltip` VARCHAR(255),
    `default_value` TEXT,
    `validation_regex` VARCHAR(255),
    `error_message` VARCHAR(255),
    `is_unique` TINYINT(1) DEFAULT 0 NOT NULL,
    `is_required` TINYINT(1) DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_field_u_d94269` (`name`),
    INDEX `032a3207-024f-4673-b9d0-afd86cbdac3f` (`label`),
    INDEX `02cdca6e-a332-48dd-9aaa-ac812f886145` (`created_at`, `updated_at`),
    INDEX `fi_d896f-3343-4e05-9ba4-6bd458afd995` (`created_by`),
    INDEX `fi_e0ab8-15f7-4bbd-9a84-e43f8ef165af` (`updated_by`),
    CONSTRAINT `097d896f-3343-4e05-9ba4-6bd458afd995`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `01be0ab8-15f7-4bbd-9a84-e43f8ef165af`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_parameter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_parameter`;

CREATE TABLE `fenric_parameter`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `value` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_parameter_u_4db226` (`code`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_section
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_section`;

CREATE TABLE `fenric_section`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `parent_id` INTEGER,
    `code` VARCHAR(255) NOT NULL,
    `header` VARCHAR(255) NOT NULL,
    `picture` VARCHAR(255),
    `content` TEXT,
    `meta_title` VARCHAR(255),
    `meta_author` VARCHAR(255),
    `meta_keywords` VARCHAR(255),
    `meta_description` VARCHAR(255),
    `meta_canonical` VARCHAR(255),
    `meta_robots` VARCHAR(255),
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_section_u_4db226` (`code`),
    INDEX `13b1aca8-173e-477e-9437-cf57d593e5f7` (`header`),
    INDEX `8572f35e-590b-49d6-b224-c3a99e0fce00` (`created_at`, `updated_at`),
    INDEX `fi_67a39-999a-4624-86f0-ede675b26d97` (`parent_id`),
    INDEX `fi_af8a9-dacd-4b52-a60a-e13fb80e7342` (`created_by`),
    INDEX `fi_a7a88-b516-4f37-a575-84aea282b1ed` (`updated_by`),
    CONSTRAINT `bbf67a39-999a-4624-86f0-ede675b26d97`
        FOREIGN KEY (`parent_id`)
        REFERENCES `fenric_section` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `ae3af8a9-dacd-4b52-a60a-e13fb80e7342`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `3aaa7a88-b516-4f37-a575-84aea282b1ed`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_section_field
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_section_field`;

CREATE TABLE `fenric_section_field`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER,
    `field_id` INTEGER,
    `sequence` DECIMAL DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `0690bf57-4850-46df-820e-f4dad8737aba` (`sequence`),
    INDEX `fi_2993a-a319-4f99-81db-f77c686d8d96` (`section_id`),
    INDEX `fi_d6703-acbc-4873-9954-8b7616ab0f4d` (`field_id`),
    INDEX `fi_149c7-f7fc-40c3-93b4-8873976aae67` (`created_by`),
    CONSTRAINT `c292993a-a319-4f99-81db-f77c686d8d96`
        FOREIGN KEY (`section_id`)
        REFERENCES `fenric_section` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `d07d6703-acbc-4873-9954-8b7616ab0f4d`
        FOREIGN KEY (`field_id`)
        REFERENCES `fenric_field` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `ec6149c7-f7fc-40c3-93b4-8873976aae67`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_publication
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_publication`;

CREATE TABLE `fenric_publication`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER,
    `code` VARCHAR(255) NOT NULL,
    `header` VARCHAR(255) NOT NULL,
    `picture` VARCHAR(255),
    `picture_signature` VARCHAR(255),
    `anons` TEXT NOT NULL,
    `content` TEXT,
    `meta_title` VARCHAR(255),
    `meta_author` VARCHAR(255),
    `meta_keywords` VARCHAR(255),
    `meta_description` VARCHAR(255),
    `meta_canonical` VARCHAR(255),
    `meta_robots` VARCHAR(255),
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    `show_at` DATETIME,
    `hide_at` DATETIME,
    `hits` DECIMAL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_publication_u_4db226` (`code`),
    INDEX `3ad20d0e-ffb1-4a40-a1ca-08c50aab5310` (`header`),
    INDEX `4e574eb5-d10a-496c-bfed-912e788ea908` (`created_at`, `updated_at`),
    INDEX `5c0359c2-c605-40f4-a0af-1e6169aec259` (`show_at`, `hide_at`),
    INDEX `610d07e6-0a39-4389-9ba7-2d4e2395f37c` (`hits`),
    INDEX `fi_6d124-043c-4286-abd8-b2c1d71c4667` (`section_id`),
    INDEX `fi_643e9-5fd8-4ea8-a247-6c2537382ecd` (`created_by`),
    INDEX `fi_60282-9ecc-4beb-b2b8-8f7340cb359a` (`updated_by`),
    CONSTRAINT `6ee6d124-043c-4286-abd8-b2c1d71c4667`
        FOREIGN KEY (`section_id`)
        REFERENCES `fenric_section` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `e15643e9-5fd8-4ea8-a247-6c2537382ecd`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `5de60282-9ecc-4beb-b2b8-8f7340cb359a`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_publication_field
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_publication_field`;

CREATE TABLE `fenric_publication_field`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `publication_id` INTEGER,
    `section_field_id` INTEGER,
    `int_value` INTEGER,
    `bool_value` TINYINT(1),
    `number_value` DECIMAL(65,30),
    `datetime_value` DATETIME,
    `string_value` VARCHAR(255),
    `text_value` TEXT,
    PRIMARY KEY (`id`),
    INDEX `a29db22d-7b7b-49e8-89ef-702af85a7480` (`int_value`),
    INDEX `b4545016-42bf-4ea3-b4cc-43d5e3441324` (`bool_value`),
    INDEX `c47bc148-4607-452d-a76f-f61301744ec0` (`number_value`),
    INDEX `d301e673-6589-4821-9dab-d27684645364` (`datetime_value`),
    INDEX `e9457770-6155-4c71-966e-d4cac884e9d3` (`string_value`),
    INDEX `fi_6f3c5-c38e-4dd5-a5d1-a9ff670a0ab8` (`publication_id`),
    INDEX `fi_3858d-cf21-4166-98d0-933a0a3066a0` (`section_field_id`),
    CONSTRAINT `a196f3c5-c38e-4dd5-a5d1-a9ff670a0ab8`
        FOREIGN KEY (`publication_id`)
        REFERENCES `fenric_publication` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `b1a3858d-cf21-4166-98d0-933a0a3066a0`
        FOREIGN KEY (`section_field_id`)
        REFERENCES `fenric_section_field` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_publication_photo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_publication_photo`;

CREATE TABLE `fenric_publication_photo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `publication_id` INTEGER,
    `file` VARCHAR(255) NOT NULL,
    `display` TINYINT(1) DEFAULT 1 NOT NULL,
    `sequence` DECIMAL DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `51f4b0ac-01f3-4278-9370-4b872fe8010c` (`display`, `sequence`),
    INDEX `666f85a9-0451-4b4d-a2d1-00874de229d9` (`created_at`, `updated_at`),
    INDEX `fi_df94b-0ba8-41ce-b69f-26ed76e0c2c9` (`publication_id`),
    INDEX `fi_8dd55-562d-4156-8f45-974be136fe79` (`created_by`),
    INDEX `fi_af54c-b6a6-437d-87a9-4eee28f9a1f1` (`updated_by`),
    CONSTRAINT `6b3df94b-0ba8-41ce-b69f-26ed76e0c2c9`
        FOREIGN KEY (`publication_id`)
        REFERENCES `fenric_publication` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `4a98dd55-562d-4156-8f45-974be136fe79`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `70daf54c-b6a6-437d-87a9-4eee28f9a1f1`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_publication_relation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_publication_relation`;

CREATE TABLE `fenric_publication_relation`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `publication_id` INTEGER,
    `related_publication_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `aa64ab94-118f-41e6-963f-707af0b10da2` (`related_publication_id`),
    INDEX `fi_10e89-ee47-4fd7-adc5-dbbf97967ccf` (`publication_id`),
    CONSTRAINT `ac910e89-ee47-4fd7-adc5-dbbf97967ccf`
        FOREIGN KEY (`publication_id`)
        REFERENCES `fenric_publication` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_publication_tag
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_publication_tag`;

CREATE TABLE `fenric_publication_tag`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `publication_id` INTEGER,
    `tag_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `fi_06349-8b35-4620-b8db-75d284af1940` (`publication_id`),
    INDEX `fi_b04f8-5f70-4c73-9c6a-179cb17df43f` (`tag_id`),
    CONSTRAINT `9be06349-8b35-4620-b8db-75d284af1940`
        FOREIGN KEY (`publication_id`)
        REFERENCES `fenric_publication` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `d28b04f8-5f70-4c73-9c6a-179cb17df43f`
        FOREIGN KEY (`tag_id`)
        REFERENCES `fenric_tag` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_snippet
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_snippet`;

CREATE TABLE `fenric_snippet`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `value` TEXT NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_snippet_u_4db226` (`code`),
    INDEX `a2567ba3-c2ba-4903-8187-b996337ebed1` (`title`),
    INDEX `aba5d14e-7744-4aff-84c9-eb225388cdbe` (`created_at`, `updated_at`),
    INDEX `fi_bee5b-6ed6-4823-a281-c8cfb4b6549b` (`created_by`),
    INDEX `fi_aa3d1-eef7-43d7-8b2b-39a6e310c30b` (`updated_by`),
    CONSTRAINT `251bee5b-6ed6-4823-a281-c8cfb4b6549b`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `fbdaa3d1-eef7-43d7-8b2b-39a6e310c30b`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_tag
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_tag`;

CREATE TABLE `fenric_tag`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `header` VARCHAR(255) NOT NULL,
    `content` TEXT,
    `meta_title` VARCHAR(255),
    `meta_author` VARCHAR(255),
    `meta_keywords` VARCHAR(255),
    `meta_description` VARCHAR(255),
    `meta_canonical` VARCHAR(255),
    `meta_robots` VARCHAR(255),
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_tag_u_4db226` (`code`),
    INDEX `1635b4a5-fb36-420e-8b5d-83d2ad8c0eca` (`header`),
    INDEX `2e967b41-f254-4c59-8022-a0033bc12fd3` (`created_at`, `updated_at`),
    INDEX `fi_c5de6-e1b1-4a8b-944f-b91bf9d8d3bc` (`created_by`),
    INDEX `fi_8be1f-c948-4b0a-bf7e-ad3820536276` (`updated_by`),
    CONSTRAINT `92dc5de6-e1b1-4a8b-944f-b91bf9d8d3bc`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `8008be1f-c948-4b0a-bf7e-ad3820536276`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- fenric_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fenric_user`;

CREATE TABLE `fenric_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `role` VARCHAR(64) DEFAULT 'user' NOT NULL,
    `email` VARCHAR(128) NOT NULL,
    `username` VARCHAR(48) NOT NULL,
    `password` VARCHAR(60) NOT NULL,
    `photo` VARCHAR(255),
    `firstname` VARCHAR(64),
    `lastname` VARCHAR(64),
    `gender` VARCHAR(16),
    `birthday` DATETIME,
    `about` TEXT,
    `params` TEXT,
    `registration_at` DATETIME,
    `registration_ip` VARCHAR(45),
    `registration_confirmed` TINYINT(1) DEFAULT 0,
    `registration_confirmed_at` DATETIME,
    `registration_confirmed_ip` VARCHAR(45),
    `registration_confirmation_code` VARCHAR(40),
    `authentication_at` DATETIME,
    `authentication_ip` VARCHAR(45),
    `authentication_key` VARCHAR(255),
    `authentication_token` VARCHAR(40),
    `authentication_token_at` DATETIME,
    `authentication_token_ip` VARCHAR(45),
    `authentication_attempt_count` DECIMAL DEFAULT 0,
    `track_at` DATETIME,
    `track_ip` VARCHAR(45),
    `track_url` VARCHAR(255),
    `ban_from` DATETIME,
    `ban_until` DATETIME,
    `ban_reason` VARCHAR(255),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_user_u_afde13` (`email`, `username`),
    INDEX `c8de93f2-5233-48b2-8893-57e10219493b` (`role`, `firstname`, `lastname`, `gender`, `birthday`),
    INDEX `c2df32b4-3037-4b95-890c-dd59ced7b952` (`registration_at`, `registration_ip`, `authentication_at`, `authentication_ip`, `track_at`, `track_ip`),
    INDEX `c4bbdbb3-d143-4ef0-bf40-9b658e45f0db` (`ban_from`, `ban_until`),
    INDEX `fc83f193-745a-4c48-bc46-271594e101a5` (`registration_confirmation_code`),
    INDEX `f6de10b6-8374-4a34-a7c0-00b46b26c58a` (`authentication_key`),
    INDEX `f3e2d4cc-c454-4eff-9b74-2176d525c591` (`authentication_token`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
