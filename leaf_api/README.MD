# Qodehub Internship Project - TODO App - Leaf API version

This is my Qodehub summer internship project, a PHP todo API built with my [Leaf API framework](https://github.com/leafsphp/leafAPI).

## Set up

To get this project running:

* Clone this project to your local device.
* Install all required packages with `composer install`.
* Run `php leaf serve` to view the project in your browser.

## Configuration

This project uses a `.env` file for all environment variable configurations including database connections.

### Database creation

To get the database up and running, simply create an empty database and run the already created migrations to create the database tables. You can do this by running `php leaf db:migrate`.

After this, you just need to add your database information in the `.env` file, and voila!
