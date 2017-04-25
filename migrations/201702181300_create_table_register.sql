CREATE TABLE `register` ( `id` INT NOT NULL AUTO_INCREMENT , `first_name` VARCHAR(128) NOT NULL , `last_name` VARCHAR(128) NOT NULL , `password` VARCHAR(128) NOT NULL , `tempat_lahir` VARCHAR(128) NOT NULL , `tanggal_lahir` DATE NOT NULL , `email` VARCHAR(128) NOT NULL , `contact_no` VARCHAR(128) NOT NULL , `instansi_name` VARCHAR(128) NOT NULL , `bagian` VARCHAR(128) NOT NULL , `alamat_instansi` VARCHAR(255) NOT NULL , `thn_mengabdi` TINYINT(3) NOT NULL DEFAULT '0' , `pendidikan` VARCHAR(100) NOT NULL , `institusi_pendidikan` VARCHAR(128) NOT NULL , `fakultas` VARCHAR(128) NOT NULL , `no_ijazah` VARCHAR(128) NOT NULL , `nilai_ipk` DECIMAL NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = MyISAM;