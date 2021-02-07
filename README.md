# race
Race REST API

# Code distribution

* migrations in src/database/migrations
* routes in src/routes/web.php
* controllers in src/app/Http/Controllers
* request validations in src/app/Http/Requests
* models in src/app/Models
* services in src/app/Services
* unit tests in src/tests/Unit

# How to run

* install docker
* install docker-compose
* git clone git@github.com:lhsantosazs/race.git
* cp .env.example .env
* cd src
* docker-compose build
*./console migrate
* docker-compose start
