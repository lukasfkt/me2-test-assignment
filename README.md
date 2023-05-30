## ME2 Test assignment for backend
<p>Project developed for the backend test of the company ME2 softwares.</p>

## Requirements
<ul>
    <li>PHP 8.1 or newer</li>
    <li>Composer</li>
    <li>Docker</li>
</ul>

## Installing
Clone the repository

    git clone https://github.com/lukasfkt/me2-test-assignment.git

Switch to the repo folder

    cd me2-test-assignment

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:secret

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:80

# Available Endpoints

