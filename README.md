# Duck Behavior Simulation and Management

This repository provides a comprehensive system to simulate and manage duck behaviors using Laravel and MongoDB. Key features include:

## Features:

- **Simulate Duck Behaviors:** Generate realistic duck behaviors such as walking, breathing, and quacking using Faker for random data.
- **MongoDB Integration:** Store and manage duck data efficiently using MongoDB.
- **Efficient Data Handling:** Handle and query large collections of duck data with optimized performance.
- **Quick Search Functionality:** Implement quick search capabilities with various parameters to find specific duck records.
- **CRUD Operations Using Jobs:** Use Laravel jobs to delete, update, and manage duck records asynchronously, improving performance and scalability.
- **Console Commands:** Utilize console commands to trigger updates and manage duck data.
- **Automated Updates:** A console command runs every 5 minutes to randomly update duck information, ensuring dynamic and up-to-date data.
- **Caching for Performance:** Implement caching mechanisms to enhance query performance and reduce load times.
- **Unit Testing:** Write comprehensive unit tests to ensure the reliability and accuracy of the application.
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
