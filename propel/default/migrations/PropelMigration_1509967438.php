<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509967438.
 * Generated on 2017-11-06 11:23:58 by fenric
 */
class PropelMigration_1509967438
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

DROP INDEX `bd5562e4-3c8b-4c20-9657-e688f975b6ac` ON `fenric_banner_client`;

CREATE INDEX `bd5562e4-3c8b-4c20-9657-e688f975b6ac` ON `fenric_banner_client` (`contact_name`);

CREATE UNIQUE INDEX `fenric_banner_client_u_274a78` ON `fenric_banner_client` (`contact_email`);

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

DROP INDEX `fenric_banner_client_u_274a78` ON `fenric_banner_client`;

DROP INDEX `bd5562e4-3c8b-4c20-9657-e688f975b6ac` ON `fenric_banner_client`;

CREATE INDEX `bd5562e4-3c8b-4c20-9657-e688f975b6ac` ON `fenric_banner_client` (`contact_name`, `contact_email`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}