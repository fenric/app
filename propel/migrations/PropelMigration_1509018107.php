<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509018107.
 * Generated on 2017-10-26 11:41:47 by fenric
 */
class PropelMigration_1509018107
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

CREATE TABLE `fenric_comment`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `parent_id` INTEGER,
    `publication_id` INTEGER,
    `content` TEXT,
    `is_deleted` TINYINT(1) DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    `deleted_at` DATETIME,
    `deleted_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `b84a4d07-70f3-47a9-b015-306ac557f889` (`created_at`, `updated_at`),
    INDEX `fi_50411-4478-40b5-a1cf-97fc39852401` (`parent_id`),
    INDEX `fi_713eb-c124-4c18-b1de-55a7d3dcc79f` (`publication_id`),
    INDEX `fi_235e6-5e38-4377-92a8-1c0d2d59b3d6` (`created_by`),
    INDEX `fi_6337f-b187-4095-af3a-2a9efdda59e0` (`updated_by`),
    INDEX `fi_ab6b7-8ed0-4079-b366-79a2fdf3b2be` (`deleted_by`),
    CONSTRAINT `aa150411-4478-40b5-a1cf-97fc39852401`
        FOREIGN KEY (`parent_id`)
        REFERENCES `fenric_comment` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `a07713eb-c124-4c18-b1de-55a7d3dcc79f`
        FOREIGN KEY (`publication_id`)
        REFERENCES `fenric_publication` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `a00235e6-5e38-4377-92a8-1c0d2d59b3d6`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `a576337f-b187-4095-af3a-2a9efdda59e0`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `a3eab6b7-8ed0-4079-b366-79a2fdf3b2be`
        FOREIGN KEY (`deleted_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
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

DROP TABLE IF EXISTS `fenric_comment`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}