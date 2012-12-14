Antenna
==========

We hope you enjoy using Antenna and it makes your life a whole lot easier.

We've had tons of great feedback in already, and we're looking forward to hearing what you've got to say about it:- which features work for you, what you don't like, and what you'd like to see.

Drop us an email at info@getantenna.com and with your valuable insight, we can continue to tweak and improve the Antenna experience for everyone.


Antenna installation
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


Using Antenna
==========

The Antenna platform offers a web-app based admin UI for managing events listings, it is currently configured around a weekly publishing schedule, however, that can easily be changed. It was developed by iQ Content in order to give Joerg Steegmueller the visibility he deserved with the DublinEventGuide.com, re-formatting his free weekly newsletter of free events, and mobilising his content, making it more accessible & usable to a wider audience. So the out-of-the-box process is very specific to Joerg's working model, but with some developer chops it can of course be tailored as required.

Here's the working process that Antenna is configured for out-of-the-box:

* Admin logs in
* Adds or edits recurring events.
* Creates a new draft edition, for a certain date range.
	- all recurring events in that date range are added to the draft edition upon creation
	- these can be deleted from this edition
	- recurring events added after a draft edition is created do NOT get retrospectively added to older drafts editions
* Adds specific events to this draft edition
* Adds content to this draft edition (some content sections by default are populated by the previous live edition's contents)
* Publishes the draft edition
	 - it becomes the live edition
	 - populating the mobile formatted html
	 - and generating the email newsletter html
	 

Antenna is just beginning
==========

We’ve released it as an open-source tool: free now and forever for developers to use, improve, and extend.

So take it, run with it and bring to places we can’t even imagine...

Drop us a line and let us know where you've taken Antenna - info@getantenna.com
