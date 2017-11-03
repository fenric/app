<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509288611.
 * Generated on 2017-10-29 14:50:11 by fenric
 */
class PropelMigration_1509288611
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

CREATE TABLE `fenric_radio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `stream` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `be581dc7-8bb8-4cae-a07e-6d72e33acba9` (`title`),
    INDEX `b7406d80-ec28-4961-861d-800a5631b6b4` (`created_at`, `updated_at`),
    INDEX `fi_4062e-ebcb-47d9-93f3-8685c012b613` (`created_by`),
    INDEX `fi_cd028-2b7e-442e-bff9-f7267b878d83` (`updated_by`),
    CONSTRAINT `a1c4062e-ebcb-47d9-93f3-8685c012b613`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `ab8cd028-2b7e-442e-bff9-f7267b878d83`
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

DROP TABLE IF EXISTS `fenric_radio`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}
