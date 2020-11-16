# Shopping task

## Running
* Copy docker-compose.yml.dist to docker-compose.yml and optionally change whatever you need to make it work.
* [Optional] Copy .env to .env.local and override variables to match your environment. Defaults work great with docker. To generate GoogleChat webhook goto https://chat.google.com/ and then add a room or enter an existing one and add new webhook.
* Run `docker-compose up -d` to create containers
* Run `docker exec -t -i -u application shopping-web bash` to enter PHP container then run:
  * `composer install` to install dependencies
  * `bin/console doctrine:database:create` to create database
  * `bin/console doctrine:migrations:migrate -n` to migrate db to newest version
  * `bin/console doctrine:fixtures:load -n` to load fixtures (including admin user with password=admin)
  * `bin/console assets:install --symlink public` to install assets
  * `bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json` to create routes in JS
  * Type `exit` to leave the container
* Run `docker run --rm -ti -v "$PWD":/var/www -w /var/www node yarn install` to install webpack
* Run `docker run --rm -ti -v "$PWD":/app -w /app node yarn encore prod` to create JS/CSS files\
* Navigate to http://localhost to view the app and/or to http://localhost:88 to read all intercepted emails.