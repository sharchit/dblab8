# How to run the file on your system
It is assumed that a database dblab8 is created in mysql. Change the password in the following files-
- delete_Account.php
- login.php
- registration.php
- update_info.php

# Features
- Readability and UI improved by using Bootstrap5.
- Passwords are hashed.
- Session terminated once logged out. Improving security.
- Registration page where password strength is checked, compared with confirm password, email is validated.
- Login page where HTML, and PHP that authenticates the user against the previously registered user data stored in the MySQL "users" table.
- Welcome page where first name, last name and emails are shown. Also links to logout, deleting account, updating info.
- Delete option implemented where user has to confirm their password to terminate account from database.
- Update information form displays the user's current information and allows them to make changes to their information.