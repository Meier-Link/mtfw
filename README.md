mtfw
====

My tiny framework for tiny web devs in PHP

Objective
---------

This tiny framework is intended to provide a simple solution to web hobbyists.

### Available

It deliberately don't make coffee for you :)
Here you have:
* a controller
* some basic tools in StdTools
* a log class
* a model to implement (with User.php as example)
* a basic skeleton to place your own files
* basic js functions (only VanillaJS, here)

### For your hands

* your customized CSS (the provided one is strongly ugly 8))
* your js libs
* your html templates
* what you want !

Installation
------------

Two ways :

### As a vhost

And my own vhost as example (for Debian Wheezy) :
	<VirtualHost *:80>
		ServerAdmin foo@bar.baz
		ServerName  yourproject.localhost.net

		DocumentRoot /home/user/vhosts/yourproject/htdocs/
		ErrorLog "/home/user/vhosts/yourproject/logs/error.log"
		CustomLog "/home/user/vhosts/yourproject/logs/access.log" combined

		ErrorDocument 500 /errordocs/internalerror.html
		ErrorDocument 404 /errordocs/filenotfound.html
		ErrorDocument 403 /errordocs/accessdenied.html
	</VirtualHost>

	<Directory /home/user/vhosts/mtfw/htdocs/>
		AllowOverride All
		Options -Indexes
		Order Deny,Allow
		Deny from none
		Allow from all
	</Directory>

And then: git pull (or unzip) in the "yourproject" directory

### Or directly in your /www

* git pull (or unzip) sources in the "www" directory
* move htdocs content on the root of www
* move secure directory on the same level as www directory

And it's work !

### Important

Do not forget to activate url rewriting ! (see .htaccess file ...)

Author
------

Jérémie aka Meier Link <jeremie.balagna@autistici.org>
