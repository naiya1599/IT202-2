CREATE TABLE if not exists `Users_prj` (
	`id` INT NOT NULL AUTO_INCREMENT
	,`email` VARCHAR(100) NOT NULL
	,`password` VARCHAR(60) NOT NULL
	,PRIMARY KEY(`id`)
	,UNIQUE(`EMAIL`))


