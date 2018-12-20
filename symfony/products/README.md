How to setup
======

1. To start the environment:
$ docker-compose build

2. To start the docker network:
$ docker-compose up

3. Create the database:
$ php bin/console doctrine:database:create

4. Update the schema:
$ php bin/console doctrine:schema:update --force

5. Create data dummy:
$ php bin/console hautelook:fixtures:load -n

6. Start the server:
$ php bin/console server:run