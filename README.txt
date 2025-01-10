Notes - Simple Note Management System

The project is a simple web application written in PHP that connects to a MySQL database.
It allows you to add, edit and delete notes.

Author
The project was created by pucio8.

Features

- Adding new notes.
- Editing existing notes.
- Deleting selected notes.
- Displaying a list of notes.

Requirements

PHP 8 or later
A server that supports PHP (e.g. Apache)
MySQL 5.7 or later

Installation
Cloning the repository:
git clone https://github.com/pucio8/repository-name.git
cd repository-name

Database Configuration: 
To create a database connection, you need to create a config/config.php file,
copy and paste the code below
- in place of xxx insert your data

<?php
declare( strict_types = 1 );
return [
  'db' => [
    'user' => 'xxx',
    'password' => 'xxx',
    'host' => 'xxx',
    'database' => 'xxx'
    ]
];