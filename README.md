# Slim 4 Api Example

Example of api written in Slim Framework 4 
@since 2019 

## Packages

- [phpunit](https://github.com/sebastianbergmann/phpunit) as unit testing framework
- [slim/psr7](https://github.com/slimphp/Slim-Psr7) as PSR-7 implementation
- [monolog/monolog](https://github.com/monolog/monolog) as logger
- [php-di/php-di](https://github.com/PHP-DI/PHP-DI) as container implementation
- [robmorgan/phinx](https://github.com/robmorgan/phinx) as seeds and migrations
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) as loads environment variables
- [illuminate/database](https://github.com/illuminate/database) as eloquent orm
- [hassankhan/config](https://github.com/hassankhan/config) as loads config

## Running the project:

1.  Run composer

        $ composer install

2.  Edit Configuration

        $ cp .env.dist .env

3.  Run the migrations

        $ composer migrate
        $ composer seed

4.  Run the API

        $ composer start

5.  Run the Test

        $ composer test

## Movies Example

| #              | URL                  | METHOD |
| -------------- | -------------------- | ------ |
| Get All Movies | api/v1/movies        | GET    |
| Get One Movie  | api/v1/movies/{id}   | GET    |
| Create Movie   | api/v1/movies/create | POST   |
| Update Movie   | api/v1/movies/{id}   | PUT    |
| Delete Movie   | api/v1/movies/{id}   | DELETE |

## TODO

- authentication
- cache
- rate limit
- pagination
- doc

## License

MIT
