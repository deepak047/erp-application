## Running locally
* Download or clone this repo.    
* In terminal, cd into the project directory.    
* Create a .env file by copying the .env.example file.    
`cp .env.example .env`
* Setup Database connection.    
* Install composer dependencies.    
`composer install`    
* Generate an app key    
`php artisan key:generate`
`php artisan migrate:fresh --seed`    
* Serve    
`php artisan serve`    
Now the project will be running on your localhost. http://localhost:8000
