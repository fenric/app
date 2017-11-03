<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509579488.
 * Generated on 2017-11-01 23:38:08 by fenric
 */
class PropelMigration_1509579488
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `fenric_banner`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `banner_group_id` INTEGER,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `picture` VARCHAR(255) NOT NULL,
    `picture_alt` VARCHAR(255),
    `picture_title` VARCHAR(255),
    `hyperlink_url` VARCHAR(255) NOT NULL,
    `hyperlink_title` VARCHAR(255),
    `hyperlink_target` VARCHAR(255),
    `show_start` DATETIME,
    `show_end` DATETIME,
    `shows` DECIMAL DEFAULT 0,
    `shows_limit` DECIMAL,
    `clicks` DECIMAL DEFAULT 0,
    `clicks_limit` DECIMAL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `c24e86a3-9bc4-4a1a-8457-83d814395977` (`title`),
    INDEX `cea2b0f0-7eb5-40aa-b1ff-db4f43bdb76b` (`show_start`, `show_end`, `shows`, `shows_limit`, `clicks`, `clicks_limit`),
    INDEX `cd570d28-3899-4452-ae47-625514659c91` (`created_at`, `updated_at`),
    INDEX `fi_27a35-da36-4175-933a-551a69b9e323` (`banner_group_id`),
    INDEX `fi_546e3-4d2f-4307-8722-d98513c2a672` (`created_by`),
    INDEX `fi_55358-115f-4707-9a36-b5ec1927d2b4` (`updated_by`),
    CONSTRAINT `b5427a35-da36-4175-933a-551a69b9e323`
        FOREIGN KEY (`banner_group_id`)
        REFERENCES `fenric_banner_group` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `b7b546e3-4d2f-4307-8722-d98513c2a672`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `b0a55358-115f-4707-9a36-b5ec1927d2b4`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET=\'utf8\' COLLATE=\'utf8_unicode_ci\';

CREATE TABLE `fenric_banner_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_banner_group_u_4db226` (`code`),
    INDEX `b6da494e-4bf3-4a72-8dad-f4d1b14f9589` (`title`),
    INDEX `b799d919-f812-401a-8601-62a7271ae341` (`created_at`, `updated_at`),
    INDEX `fi_5a508-5cd1-413a-a68a-cc47faaf27fe` (`created_by`),
    INDEX `fi_e35d2-7640-4773-979d-84a630688e6c` (`updated_by`),
    CONSTRAINT `af75a508-5cd1-413a-a68a-cc47faaf27fe`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `a47e35d2-7640-4773-979d-84a630688e6c`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET=\'utf8\' COLLATE=\'utf8_unicode_ci\';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `fenric_banner`;

DROP TABLE IF EXISTS `fenric_banner_group`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}