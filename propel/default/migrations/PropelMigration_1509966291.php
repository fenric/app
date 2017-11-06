<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509966291.
 * Generated on 2017-11-06 11:04:51 by fenric
 */
class PropelMigration_1509966291
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

ALTER TABLE `fenric_banner`

  ADD `banner_client_id` INTEGER AFTER `banner_group_id`;

CREATE INDEX `fi_45caa-f137-4de7-83c6-410fb898114b` ON `fenric_banner` (`banner_client_id`);

ALTER TABLE `fenric_banner` ADD CONSTRAINT `ba745caa-f137-4de7-83c6-410fb898114b`
    FOREIGN KEY (`banner_client_id`)
    REFERENCES `fenric_banner_client` (`id`)
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

ALTER TABLE `fenric_banner` DROP FOREIGN KEY `ba745caa-f137-4de7-83c6-410fb898114b`;

DROP INDEX `fi_45caa-f137-4de7-83c6-410fb898114b` ON `fenric_banner`;

ALTER TABLE `fenric_banner`

  DROP `banner_client_id`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}