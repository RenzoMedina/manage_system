USE sistema_administrable;
/*
? table of roles relation one to many
*/
CREATE TABLE IF NOT EXISTS table_roles(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `type_role` VARCHAR(50) NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

/*
? table of users
*/
CREATE TABLE IF NOT EXISTS table_users(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `rut` VARCHAR(13) NOT NULL UNIQUE,
    `name` VARCHAR(50)NOT NULL,
    `last_name` VARCHAR(70)NOT NULL,
    `email` VARCHAR(70)NOT NULL UNIQUE,
    `password` VARCHAR(255)NOT NULL,
    `id_rol` INT,
    `status` VARCHAR(20) NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_id_rol FOREIGN KEY (`id_rol`) REFERENCES `table_roles` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of user details relation one to one
*/
CREATE TABLE IF NOT EXISTS table_details_users(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT UNIQUE,
    `health_insurance` VARCHAR(70)NOT NULL,
    `type_health_insurance` VARCHAR(70)NOT NULL,
    `afp` VARCHAR(70)NOT NULL,
    `date_start` DATE,
    `date_end` DATE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_id_user FOREIGN KEY (`id_user`) REFERENCES `table_users` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? for manage relations one to one patient
*/
CREATE INDEX idx_user_role_relation ON table_users(id_rol);

/*
? table  of patient
*/
CREATE TABLE IF NOT EXISTS table_patients(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `rut` VARCHAR(13) NOT NULL UNIQUE,
    `name` VARCHAR(70)NOT NULL,
    `last_name` VARCHAR(70)NOT NULL,
    `age` INT NOT NULL,
    `weigth` FLOAT NOT NULL,
    `size` FLOAT NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

/*
? table of contacts relations patient
*/
CREATE TABLE IF NOT EXISTS table_contacts_patients(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_patient` INT,
    `rut` VARCHAR(13) NOT NULL,
    `name` VARCHAR(70)NOT NULL,
    `last_name` VARCHAR(70)NOT NULL,
    `relations` VARCHAR(70)NOT NULL,
    `telephone` VARCHAR(25)NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_contacts_id_patient FOREIGN KEY (`id_patient`) REFERENCES `table_patients` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of details_medicals patient
*/
CREATE TABLE IF NOT EXISTS table_details_medicals(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_patient` INT UNIQUE,
    `gttd` FLOAT,
    `sng` FLOAT,
    `s_folley` FLOAT,
    `cit` FLOAT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_details_id_patient FOREIGN KEY (`id_patient`) REFERENCES `table_patients` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? for manage relations one to one of contacts,details_medicals of patients
*/
CREATE INDEX idx_contacts_id_patient ON table_contacts_patients(id_patient);
CREATE INDEX idx_details_id_patient ON table_details_medicals(id_patient);

/*
? table of daily_report patient 
*/
CREATE TABLE IF NOT EXISTS table_daily_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_patient` INT,
    `observartions_global` TEXT,
    `id_user` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_daily_report_id_patient FOREIGN KEY (`id_patient`) REFERENCES `table_patients` (`id`) ON DELETE SET NULL,
    CONSTRAINT fk_daily_report_id_user FOREIGN KEY (`id_user`) REFERENCES `table_users` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;
/*
? table of vital_signs patient 
*/
CREATE TABLE IF NOT EXISTS table_vital_signs_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `hh_start` TIME,
    `hh_end` TIME,
    `blood_pressure` FLOAT,
    `respiratory_rate` FLOAT,
    `heart_rate` FLOAT,
    `saturation` FLOAT,
    `temperature` FLOAT,
    `eva_flacc` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_vital_signs_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of intake_control patient 
*/
CREATE TABLE IF NOT EXISTS table_intake_control_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `hh_start` TIME,
    `hh_end` TIME,
    `type_food` TEXT,
    `tolerance` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_intake_control_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/* 
? table of expense_control patient 
*/
CREATE TABLE IF NOT EXISTS table_expense_control_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `hh_start` TIME,
    `hh_end` TIME,
    `urine` BOOLEAN,
    `deposition` BOOLEAN,
    `others` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_expense_control_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of other_instructions patient 
*/
CREATE TABLE IF NOT EXISTS table_other_instructions_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `schedule` TIME,
    `observations` TEXT,
    `frequency` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_other_instructions_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of day_evaluation patient 
*/
CREATE TABLE IF NOT EXISTS table_day_evaluation_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `observations` TEXT,
    `date` DATETIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_day_evaluation_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? table of night_evaluation patient 
*/
CREATE TABLE IF NOT EXISTS table_night_evaluation_report_of_patient(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_daily_report` INT,
    `observations` TEXT,
    `date` DATETIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_night_evaluation_id_daily_report FOREIGN KEY (`id_daily_report`) REFERENCES `table_daily_report_of_patient` (`id`) ON DELETE SET NULL
)ENGINE = InnoDB;

/*
? for manage relations daily report of patient
*/
CREATE INDEX idx_daily_patient ON table_daily_report_of_patient (id_patient);
CREATE INDEX idx_daily_user ON table_daily_report_of_patient (id_user);
CREATE INDEX idx_daily_created_at ON table_daily_report_of_patient (created_at);

/*
? for manage relations vital signs report of patient
*/
CREATE INDEX idx_vital_daily ON table_vital_signs_report_of_patient (id_daily_report);
CREATE INDEX idx_vital_start_end ON table_vital_signs_report_of_patient (hh_start, hh_end);
CREATE INDEX idx_vital_created_at ON table_vital_signs_report_of_patient (created_at);

/*
? for manage relations intake control report of patient
*/
CREATE INDEX idx_intake_daily ON table_intake_control_report_of_patient (id_daily_report);
CREATE INDEX idx_intake_created_at ON table_intake_control_report_of_patient (created_at);

/*
? for manage relations expense control report of patient
*/
CREATE INDEX idx_expense_daily ON table_expense_control_report_of_patient (id_daily_report);
CREATE INDEX idx_expense_created_at ON table_expense_control_report_of_patient (created_at);

/*
? for manage relations other instruccions report of patient
*/
CREATE INDEX idx_instructions_daily ON table_other_instructions_report_of_patient (id_daily_report);
CREATE INDEX idx_instructions_schedule ON table_other_instructions_report_of_patient (schedule);

/*
? for manage relations day observations report of patient
*/
CREATE INDEX idx_day_eval_daily ON table_day_evaluation_report_of_patient (id_daily_report);
CREATE INDEX idx_day_eval_date ON table_day_evaluation_report_of_patient (date);

/*
? for manage relations night observations report of patient
*/
CREATE INDEX idx_night_eval_daily ON table_night_evaluation_report_of_patient (id_daily_report);
CREATE INDEX idx_night_eval_date ON table_night_evaluation_report_of_patient (date);

/*
? for manage relations daily report of patient for date and user
*/
CREATE INDEX idx_daily_date_user ON table_daily_report_of_patient (created_at, id_user);

/*
? Load data type role for start 
*/
INSERT INTO table_roles (`type_role`) VALUES("Administrador");

/*
? Load data user for start
*/
INSERT INTO table_users (`rut`,`name`,`last_name`,`email`,`password`,`id_rol`) VALUES("11.111.111-1","Admin","Main","admin@sysadminclinical.com", "$2y$10$ru6P05vpIEyeGzzcROptbuXQgghvr4KlG8ZqWHbGQEXuYUKkxxHkm", 1);