ALTER TABLE `users` ADD `status1` INT NOT NULL DEFAULT '0' AFTER `created_by`;
ALTER TABLE `users`  ADD `status2` INT NOT NULL DEFAULT '0'  AFTER `status1`;
ALTER TABLE `users`  ADD `status3` INT NOT NULL DEFAULT '0'  AFTER `status2`;