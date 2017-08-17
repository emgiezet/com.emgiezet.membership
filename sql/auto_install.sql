SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `civicrm_membershipperiod`;


SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE civicrm_membershipperiod (
  `id`                    INT(100) NOT NULL AUTO_INCREMENT,
  `contact_id`           INT(10) UNSIGNED NOT NULL,
  `membership_id`         INT(10) UNSIGNED NOT NULL,
  `start_date` DATE,
  `end_date`   DATE,
  `modified_date`         DATETIME,
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_membershipperiod_contact_id FOREIGN KEY (`contact_id`) REFERENCES civicrm_contact (id)
    ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_membershipperiod_membership_id FOREIGN KEY (`membership_id`) REFERENCES civicrm_membership (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_unicode_ci;


SET FOREIGN_KEY_CHECKS = 1;
