<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1507720898.
 * Generated on 2017-10-11 11:21:38 by fenric
 */
class PropelMigration_1507720898
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

DROP INDEX `aa64ab94-118f-41e6-963f-707af0b10da2` ON `fenric_publication_relation`;

ALTER TABLE `fenric_publication_relation`

  CHANGE `related_publication_id` `relation_id` INTEGER;

CREATE INDEX `aa64ab94-118f-41e6-963f-707af0b10da2` ON `fenric_publication_relation` (`relation_id`);

ALTER TABLE `fenric_section_field` DROP FOREIGN KEY `ec6149c7-f7fc-40c3-93b4-8873976aae67`;

DROP INDEX `fi_149c7-f7fc-40c3-93b4-8873976aae67` ON `fenric_section_field`;

ALTER TABLE `fenric_section_field`

  DROP `created_at`,

  DROP `created_by`;

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

DROP INDEX `aa64ab94-118f-41e6-963f-707af0b10da2` ON `fenric_publication_relation`;

ALTER TABLE `fenric_publication_relation`

  CHANGE `relation_id` `related_publication_id` INTEGER;

CREATE INDEX `aa64ab94-118f-41e6-963f-707af0b10da2` ON `fenric_publication_relation` (`related_publication_id`);

ALTER TABLE `fenric_section_field`

  ADD `created_at` DATETIME AFTER `sequence`,

  ADD `created_by` INTEGER AFTER `created_at`;

CREATE INDEX `fi_149c7-f7fc-40c3-93b4-8873976aae67` ON `fenric_section_field` (`created_by`);

ALTER TABLE `fenric_section_field` ADD CONSTRAINT `ec6149c7-f7fc-40c3-93b4-8873976aae67`
    FOREIGN KEY (`created_by`)
    REFERENCES `fenric_user` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}