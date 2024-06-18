# UEX FULL STACK DEVELOPER TEST

This application is a simple Contact manager with Google Maps and Via CEP Api, built with Laravel, Vue.js and Tailwind. Enjoy it!

Stacks: Laravel, PHP 8.3, Node 20, Vue.js 3, Vite, Docker, Laravel Sail, Mysql.

# Running

Requirements: Docker

<ol>
<li>Download and navigate to the project's path</li>
<li>On bash, run `./docker-setup.sh`</li>
<li>On bash, run `./vendor/bin/sail up` (it may take a while the first time)</li>
<li>Its alive! Go to [http://localhost](http://localhost) and see it🎉</li>
<li>There are a simple api documentation on [http://localhost:8000/docs/api](http://localhost:8000/docs/api) </li>
<li>This docker compose comes with mailpit: a simple mailbox for development environment. You can see the app e-mails on [http://localhost:8025](http://localhost:8025)</li>
</ol>

# Running without Docker

Requirements: PHP 8.3, composer, npm, mysql

<ol>
<li>Download and navigate to the project's path</li>
<li>On bash, run `composer install`</li>
<li>On bash, run `npm install && npm run build`</li>
<li>On bash, run `php artisan migrate --seed`</li>
<li>On bash, run `php artisan serve`</li>
<li>Its alive! Go to [http://localhost:8000](http://localhost:8000) and see it🎉</li>
<li>There are a simple api documentation on [http://localhost:8000/docs/api](http://localhost:8000/docs/api) </li>
</ol>

# Testing

The application is covered by automated tests

Testing Laravel:

-   Simple run: `./vendor/bin/sail artisan test`
