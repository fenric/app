<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1510095612.
 * Generated on 2017-11-07 23:00:12 by fenric
 */
class PropelMigration_1510095612
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

ALTER TABLE `fenric_comment`

  ADD `is_verified` TINYINT(1) DEFAULT 0 NOT NULL AFTER `is_deleted`,

  ADD `verified_at` DATETIME AFTER `deleted_by`,

  ADD `verified_by` INTEGER AFTER `verified_at`;

CREATE INDEX `fi_c0210-7f75-48ed-a9ff-8ad7f69b8543` ON `fenric_comment` (`verified_by`);

ALTER TABLE `fenric_comment` ADD CONSTRAINT `a65c0210-7f75-48ed-a9ff-8ad7f69b8543`
    FOREIGN KEY (`verified_by`)
    REFERENCES `fenric_user` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

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

ALTER TABLE `fenric_comment` DROP FOREIGN KEY `a65c0210-7f75-48ed-a9ff-8ad7f69b8543`;

DROP INDEX `fi_c0210-7f75-48ed-a9ff-8ad7f69b8543` ON `fenric_comment`;

ALTER TABLE `fenric_comment`

  DROP `is_verified`,

  DROP `verified_at`,

  DROP `verified_by`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}