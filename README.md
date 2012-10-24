Antenna installation: 
==========

* Place the contents of cms/src on your webserver
* Create a MySQL database and user
* Run the cms/sql/base.sql
* Rename app/config/database.php.default to database.php
* Configure database.php with your database details
* Rename app/config/core.php.default to core.php
* Configure core.php with your application details including salt values
* make the following directories writeable:
	- app/tmp
	- app/tmp/cache
	
* you should now be able to logon by going to the url you installed the application into!
	- default username and password is: antenna / IgotAntenna!
	
