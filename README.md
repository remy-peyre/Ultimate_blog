# Ultimate_blog

# installation

You need to have [composer](https://getcomposer.org/) installed.

run `composer install`

## database setup

create a database for this project (for more safety, also create a user for this database).

change your `.env` file `DATABASE_URL` var to the url to connect to the database.

generate the database with  
`php bin/console doctrine:database:create`
`php bin/console doctrine:schema:update --force`

To run your project
`php bin/console server:run`

To watch changed of style
`yarn encore dev --watch`