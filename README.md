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

## Get Started

To start using the api, you will first need to register.

* Register End Point: http://your-domain/api/register

> Params to be sent in the body
`name(string)`, `email(string)` and  `password(string)`
Return Value: `User Object or Reponse Status 400`

After registering the user, you will need to login to authenticate.

* Login End Point: http://your-domain/api/login

> Params to be sent in the body
`email(string)` and  `password(string)`
Return Value: `Object with token or Reponse Status 401`

The only public routes are registration and login. For the others, it will be necessary to use the Authorization header with the token returned by the login route.

## Available Endpoints

### Collaborators
Base URL: http://your-domain/api/collaborators

#### GET END POINTS:

* List collaborators: `/list`

> Return Value: `Array of Collaborators Object`

* Search for a specific collaborator: `/search`

> Parameters that can be sent in the query (all optional)
`name(string)`, `registration(string)`, `cpf(string)` and `schedule_id(int)`
Return Value: `Array of Collaborators Object`

