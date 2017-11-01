kvizomat
==============

Steps to run project:

*	clone repository locally
*   make sure you have php and composer installed
*	run "composer install" inside project root
*	make sure you have mysql up and running with kvizomat database created
*	run "bin/console doctrine:schema:update --force"
*	run "bin/console doctrine:fixtures:load"
*	run "bin/console server:run"
*	go to "localhost:8000"
*	???
*	profit $$$






Dev notes:
 - When a commit is marked with "ENTITY CHANGED!", its necessary to run "bin/console doctrine:schema:update --force". If there are errors, try to run "bin/console cache:clear" before running again. If its still throwing errors, it might be best to backup data from tables, drop whole database, create new one and run schema update again.