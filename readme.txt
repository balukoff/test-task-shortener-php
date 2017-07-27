Original task: http://www.xiag.ch/testtask/

Requirements:
php 5.3+
mysql 
Apache server 2.2+ or IIS
Linux or windows-based server

How to use:
1. Configure your web-server: apache or IIS, mysql server, php
2. Copy files into root directory of your web server
3. Create database. Nessesary sql requests are contained in tables.sql
4. You need to set up some options in configuration file(config.php) like database name, host, username and password for access to database.
5. Edit file .htaccess, change directive "RewriteBase" to "/" if your site in the root of web server
6. test your luck
P.S. configuration file has option called CHECKURL_EXISTS. It's responsible for checking exists real url or not. Now it's in 'false'.
