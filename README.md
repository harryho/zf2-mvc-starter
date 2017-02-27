Zend 2 App Starter 
=======================

Introduction
---

This is a simple, skeleton application using the ZF2 MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with ZF2.


Installation
---

Using Composer (recommended)
---

Please find instruction [here](https://harryho.github.io/blog/php-web/#composer)


Install or update your zendframework comppnents
---

**Without composer installed**
```bash
    cd my/project/dir
    curl -s https://getcomposer.org/installer | php --
    php composer.phar self-update
    php composer.phar install
```

**With composer installed**
```bash
    cd my/project/dir
    composer self-update
    composer install
```

Mysql setup
---
* Linux/Unix
    * Check the linux setup blog which covers many popular linux setup. If you cannot find the answer please refer official manual or site. 

* Windows 
    * Download and install mysql on your computer. 

* Prepare the databaes
    * Start mysql instance and login successfully. 
    * Create database & table with seed data
    ```
    DROP DATABASE   /*!32312 IF EXISTS*/ book_list;

    CREATE DATABASE book_list CHAR;

    SET utf8 COLLATE 'utf8_unicode_ci';

    SHOW DATABASES;

    create table book ( 
        id int not null auto_increment, 
        title varchar(255) not null,
        author varchar(255) not null,
        primary key (id)
    );

    insert into book (title, author) values ( 'Book A', 'Author A');
    insert into book (title, author) values ( 'Book B', 'Author A');
    insert into book (title, author) values ( 'Book C', 'Author C');
    insert into book (title, author) values ( 'Book D', 'Author D');
    ```

Update database connection info
---
* Open `project_dir\config\autoload\global.php` 
* Update connectionstring 'mysql:dbname=book_list;host=127.0.0.1;port=3306'.
* Open `project_dir\config\autoload\local.php` 
* Update the user and password which you can login to local mysql instance. 



Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:


**Linux**
```bash
    php -S 0.0.0.0:8080 -t public/ public/index.php
```  

**Windows**
```bash
    php -S 0.0.0.0:8080 -t public public/index.php
```    

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/zf2-tutorial/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-tutorial/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>


### Authorization & Authentication 

```
id: user
password: password
```
