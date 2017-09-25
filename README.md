# APiHP - A simple basis to build an API for any application.

This API supports both POST and GET requests.

For the application to work:

- rename the sample.config.php to config.php
- set the database credentials in the 'db' array
- change the password for creating new IDs in the 'generate_password' array

Done.

## generating IDs to access the API

- access the generate.php file in your browser
- enter the set password in the config.php
- save your newly generated ID

## creating new endpoints and actions

- create a new folder with the name of the endpoint in /endpoints
- create (a) new .php file(s) with the name(s) of the action(s) in the new folder
- everything in the php files gets executed when accessing the specific action at the endpoint


Don't abuse or use this code for malicious purposes.
