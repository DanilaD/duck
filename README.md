# Living, Breathing, Walking Duck

This is a sample Laravel application simulating a living, breathing, walking duck. The project demonstrates the use of Laravel 10, PHP 8.2, MongoDB, job queues, and the Strategy Design Pattern.

## Features:

- Simulate duck behaviors (walking, breathing, quacking).
- Store and manage duck data in MongoDB.
- Efficiently handle and query large collections.
- Quick search functionality with various parameters.
- Delete and update duck records using jobs.
- Use of console commands to update duck data.
- Caching to improve performance.

## Setup Instructions:

### Clone the repository:

```sh
git clone git@github.com:DanilaD/duck.git
cd <repository_folder>
```

### Install dependencies:

```sh
composer install
npm install
```

### Setup environment variables:

```sh
php artisan migrate
php artisan db:seed --class=DucksSeeder
```

### Compile assets:

```sh
npm run mix
``` 

### Start the application:

```sh
php artisan serve
```

### Run the job queue:

```sh
php artisan queue:work
```

## Usage:

- Access the application at http://localhost:8000.
- Manage ducks and simulate behaviors.
- Use the search functionality to find ducks based on different criteria.
- Update duck data and behaviors using the provided forms.

## Testing:

### Run the unit tests using PHPUnit:

```sh
php artisan test
```

### Code Coverage:

To generate a code coverage report, you can use the following command:

```sh
./vendor/bin/phpunit --coverage-html coverage
```
