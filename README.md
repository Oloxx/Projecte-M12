<p align="center"><img src="https://agora.xtec.cat/ies-carles-vallbona/wp-content/uploads/usu2364/2023/01/icon-iescv.png" width="100" alt="IES Carles Vallbona Logo">
<h2 align="center">IES Carles Vallbona Organization Manager</h2></p>

### Development enviroment

#### Requirements

- php ^8.1
- node ^18.15
- mySQL

#### Build project

1. Download.
* Clone github repository:
  * HTTPS: `git clone https://github.com/Oloxx/Projecte-M12.git`
  * SSH: `git clone git@github.com:Oloxx/Projecte-M12.git`
* Open the cloned respository: 
  * `cd Projecte-M12`

2. Set up environment.
* Install Composer:
  * `composer install`
* Install Node:
  * `npm install`
* .env file:
  * Copy the .env.example and rename it to .env
  * Add your mySQL user and password
* Create Database & Run Laravel migrations and seeders:
  * `yes | php artisan migrate`
  * `php artisan db:seed`

#### Run project

1. Start environment.
* Run Node:
  * `npm run dev`
* Run Laravel:
  * `php artisan serve`
2. Open your browser and go to `localhost:8000`