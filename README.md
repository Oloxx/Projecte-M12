<p align="center"><img src="https://agora.xtec.cat/ies-carles-vallbona/wp-content/uploads/usu2364/2023/01/icon-iescv.png" width="100" alt="IES Carles Vallbona Logo">
<h2 align="center">IES Carles Vallbona Organization Manager</h2></p>

### Development environment

#### Requirements

- PHP ^8.1
- Node ^16.0
- MySQL

#### Build project

1. Download.
* Clone GitHub repository:
  * HTTPS: `git clone https://github.com/Oloxx/Projecte-M12.git`
  * SSH: `git clone git@github.com:Oloxx/Projecte-M12.git`
* Open the cloned repository: 
  * `cd Projecte-M12`

2. Set up environment.
* Install Composer:
  * `composer install`
* Install Node:
  * `npm install`
* .env file:
  * Copy the .env.example and rename it to .env
  * Add your MySQL user and password
* Generate App Key
  * `php artisan key:generate`
* Create Database & Run Laravel migrations and seeders:
> If you already created the database, you can simply run `php artisan migrate` without the `yes |`
  * `yes | php artisan migrate`
  * `php artisan db:seed`

#### Run project

1. Start environment.
* Run Node:
  * `npm run dev`
* Run Laravel:
  * `php artisan serve`
2. Open your browser and go to `localhost:8000`
