<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1509213092.
 * Generated on 2017-10-28 17:51:32 by fenric
 */
class PropelMigration_1509213092
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

CREATE TABLE `fenric_poll`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `multiple` TINYINT(1) DEFAULT 0 NOT NULL,
    `open_at` DATETIME,
    `close_at` DATETIME,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fenric_poll_u_4db226` (`code`),
    INDEX `f7672061-23aa-43ea-8717-a0d2dd9987ad` (`title`),
    INDEX `eaf3f736-8303-4362-9aa9-3ea9e686243f` (`open_at`, `close_at`),
    INDEX `c4334586-8a95-40e0-bece-8795a3b6c884` (`created_at`, `updated_at`),
    INDEX `fi_4e638-486c-47f9-90b7-601b6a3a434f` (`created_by`),
    INDEX `fi_dfb67-bd15-49f0-9788-478277d56822` (`updated_by`),
    CONSTRAINT `a2b4e638-486c-47f9-90b7-601b6a3a434f`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `a3adfb67-bd15-49f0-9788-478277d56822`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET=\'utf8\' COLLATE=\'utf8_unicode_ci\';

CREATE TABLE `fenric_poll_variant`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `poll_id` INTEGER,
    `title` VARCHAR(255) NOT NULL,
    `sequence` DECIMAL DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `created_by` INTEGER,
    `updated_at` DATETIME,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cf40dbec-2694-401d-bc1c-128aab0a9063` (`title`),
    INDEX `e3502bd2-3804-4258-a5ad-df2ec5650beb` (`sequence`),
    INDEX `dcaf06a3-90e4-4af1-ac61-eec35f4aca22` (`created_at`, `updated_at`),
    INDEX `fi_ef4d3-e9be-4896-a67a-063e5b679338` (`poll_id`),
    INDEX `fi_d73fa-4116-4695-b907-8f6e34e73fd3` (`created_by`),
    INDEX `fi_c1963-0424-4cb2-9550-0a7407247317` (`updated_by`),
    CONSTRAINT `e36ef4d3-e9be-4896-a67a-063e5b679338`
        FOREIGN KEY (`poll_id`)
        REFERENCES `fenric_poll` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `dccd73fa-4116-4695-b907-8f6e34e73fd3`
        FOREIGN KEY (`created_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `ff7c1963-0424-4cb2-9550-0a7407247317`
        FOREIGN KEY (`updated_by`)
        REFERENCES `fenric_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET=\'utf8\' COLLATE=\'utf8_unicode_ci\';

CREATE TABLE `fenric_poll_vote`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `poll_variant_id` INTEGER,
    `respondent_user_agent` VARCHAR(255) NOT NULL,
    `respondent_remote_address` VARCHAR(255) NOT NULL,
    `respondent_session_id` VARCHAR(255) NOT NULL,
    `respondent_vote_id` VARCHAR(255) NOT NULL,
    `respondent_id` VARCHAR(255) NOT NULL,
    `vote_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `a771f0ee-2ec1-4a1c-a103-7aaaf0cd22ea` (`vote_at`),
    INDEX `fi_11937-8db9-4d02-b08b-c1e611538b89` (`poll_variant_id`),
    CONSTRAINT `eeb11937-8db9-4d02-b08b-c1e611538b89`
        FOREIGN KEY (`poll_variant_id`)
        REFERENCES `fenric_poll_variant` (`id`)
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

DROP TABLE IF EXISTS `fenric_poll`;

DROP TABLE IF EXISTS `fenric_poll_variant`;

DROP TABLE IF EXISTS `fenric_poll_vote`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}