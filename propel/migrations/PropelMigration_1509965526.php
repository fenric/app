<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509965526.
 * Generated on 2017-11-06 10:52:06 by fenric
 */
class PropelMigration_1509965526
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

CREATE TABLE `fenric_banner_client`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `contact_name` VARCHAR(255) NOT NULL,
    `contact_email` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `bd5562e4-3c8b-4c20-9657-e688f975b6ac` (`contact_name`, `contact_email`),
    INDEX `b2890d49-6261-4896-b22d-0f8f676b9e77` (`created_at`, `updated_at`),
    INDEX `fi_adea3-2561-4abc-bade-9932c7b6e7a8` (`created_by`),
    INDEX `fi_9d390-8478-409a-8c23-8e21247a28ce` (`updated_by`),
    CONSTRAINT `a53adea3-2561-4abc-bade-9932c7b6e7a8`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `a839d390-8478-409a-8c23-8e21247a28ce`
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

DROP TABLE IF EXISTS `fenric_banner_client`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}