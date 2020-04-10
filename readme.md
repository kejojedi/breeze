# Breeze

This framework is just a concept right now. It is influenced by SwiftUI, and uses a bunch of Laravel components in the background.

The idea is to ditch the MVC paradigm, and use declarative functions for everything - including even building views.

## Usage

Grab this repo.

Run `composer update`.

Create a MySQL database.

Add a table called `cars` with the following structure:

    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(191) DEFAULT NULL,
    `year` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    
Update the `config.php` file.

## Notes

All of the magic happens in the `/app` folder.

There is a `/components` folder where custom components live. See `navbar.php` for an example.