# APiHP - A simple basis to build an API for any application.

APiHP is a simple basis written in PHP to let you build an easy API for you web-app.
Though it handles every call to the API, you have to write the output yourself.
So this is some kind of basic handler but the main reason for an API, the output, has still to be added.

## For the application to work:

- rename the sample.config.php to config.php
- set the database credentials in the 'db' array
- change the password for creating new IDs in the 'generate_password' array

Done.

### generating IDs to access the API

- access the generate.php file in your browser
- enter the password which you set in the config.php
- save your newly generated ID

### disable the need of an ID to access the API

- simply change 'require_id' to 'false' in the config.php

### creating new endpoints and actions

- create a new folder with the name of the endpoint in /endpoints
- create (a) new .php file(s) with the name(s) of the action(s) in the new folder
- everything in the php file(s) gets executed when accessing the specific action(s) at the endpoint

### possibilities

As already mentioned before, this is only a basic handler.
You could handle many more parameters in every action and even add some kind of 'action-ception'.
This is possible because every action executed is a simple PHP file in which anything can be done.
So you literally have unlimited possibilities to realize your API!




Don't abuse or use this code for malicious purposes.
