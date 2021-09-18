## Start
```
# Clone via HTTPS or SSH
$ git clone https://github.com/glenncai/e-library-auth.git
or
$ git clone git@github.com:glenncai/e-library-auth.git

# For linux user (edit the permissions)
$ sudo chown -R username /var/www/html/e-library-auth

# Install packages
$ composer install
$ npm install
$ npm run dev

# Create .env file, and then copy the whole info from .env.example and paste it to .env file

# Set the APP_KEY value in .env file
$ php artisan key:generate

# Go to phpMyAdmin, create a database and name it what you want... 
# ...Fill in the database name and username into the corresponding... 
# ...location in the .env file. Don't forget to fill in the database password

# Migration table create
$ php artisan migrate

# Run the application in two terminal
$ php artisan serve
$ npm run watch

# enjoy collaborating with me! ❤️😉
```
