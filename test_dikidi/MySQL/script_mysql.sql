-- написал два запроса, т.к. не очень понял, что значит "и учесть, что мотоцикл может быть уже снят с производства"
-- запрос который просто выводит кол-во всех мотоциклов по типам  с учетом что какие-то мотоциклы сняты
SELECT tm.name as 'тип мотоцикла', count(m.id) as 'кол-во', m.discontinued as 'снят с производства?' FROM test_dikidi.types_motorcycles as tm
left join test_dikidi.motorcycles as m on m.type_id = tm.id
group by tm.name, m.discontinued;

-- запрос исключающий снятых с производства мотоциклов
SELECT tm.name as 'тип мотоцикла', count(m.id) as 'кол-во' FROM test_dikidi.types_motorcycles as tm
left join test_dikidi.motorcycles as m on m.type_id = tm.id
where m.discontinued != true
group by tm.name;

-- create database test_dikidi;

-- create table test_dikidi.motorcycles (
-- 	   id INT,
--     name VARCHAR(255),
--     discontinued  BOOLEAN,
--     type_id INT
-- );

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- CHANGE COLUMN `id` `id` INT NOT NULL ,
-- ADD PRIMARY KEY (`id`);
-- ;

-- create table test_dikidi.types_motorcycles(
-- 	   id INT PRIMARY KEY NOT NULL,
--     name VARCHAR(255)
-- );

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- ADD INDEX `fk_type_id_idx` (`type_id` ASC) VISIBLE;
-- ;

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- ADD CONSTRAINT `fk_type_id`
--   FOREIGN KEY (`type_id`)
--   REFERENCES `test_dikidi`.`types_motorcycles` (`id`);

-- insert into test_dikidi.types_motorcycles (id, name) values (1, 'Дорожный'), (2, 'Питбайк'), (3, 'Спортивный'); 

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- DROP FOREIGN KEY `fk_type_id`;

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- ADD CONSTRAINT `fk_type_id`
--   FOREIGN KEY (`type_id`)
--   REFERENCES `test_dikidi`.`types_motorcycles` (`id`)
--   ON DELETE SET NULL
--   ON UPDATE CASCADE;

-- ALTER TABLE `test_dikidi`.`motorcycles` 
-- CHANGE COLUMN `id` `id` INT NOT NULL AUTO_INCREMENT;

-- insert into test_dikidi.motorcycles (name, discontinued, type_id) values ('Yamaha YBR 125', true, 1), ('Stels flame 200', false, 1), ('Honda CB-1', true, 1),
-- ('JMC 160 PRO', true, 2), ('Yamaha TW 200', false, 2), ('Motoland 125 SX', false, 2),
-- ('Suzuki TL 1000', false, 3), ('Honda VFR 400', false, 3), ('Kawasaki ZZR400', false, 3); 