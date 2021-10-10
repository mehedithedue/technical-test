# Technical Test

## Project overview
* This project is build with Core php as backend without any framework. 
* Also for frontend used Vue js CDN, Not CLI.

## Project structure
* All PHP Functionality is in ``/src`` folder.
    * Repository for connect PDO to Database client ( MYSQL )
    * Builder for Build the Query and execute by PDO
    * Router for handle routes and call related controller method
    * Controller for execute functionality as per business logic
    * config folder contain ``config`` file of Database credential
    * ``index.php`` in ``src`` folder is basically the route file of the project

* All Vue Js Functionality is in ``/resource`` folder.
    * All required page as home and for create and edit document are in ``page`` folder.

* Vue js is initiated in root ``index.html`` file.   

## Run project 
* run ``composer install`` in the root of the project.
* running with inbuild php server ``php -S localhost:8000`` in terminal

