# Project Setup Instructions

Follow these steps to set up the Laravel application locally.

## Prerequisites

Before setting up the project, ensure you have the following installed:
- **PHP** (version 8.2)
- **Composer** (latest version recommended)
- **MySQL**
- **Laravel12** (version 12)

Additionally, ensure your system meets Laravel’s [server requirements](https://laravel.com/docs/11.x/deployment#server-requirements).


## Installation Steps

1. **Install Laravel Dependencies**  
   Run the following command to install the required PHP dependencies:  
   ```bash
   composer update

2. **Create a Copy of the .env File**  
   Copy the example environment file to create your own .env file:  
   ```bash
   cp .env.example .env

3. **Generate an Application Key**  
   Generate a unique application key for your Laravel app: 
   ```bash
   php artisan key:generate

4. **Run Database Migrations and Seed Data (Optional)**  
   Copy the example environment file to create your own .env file:  
   ```bash
   php artisan migrate:fresh --seed
b seyha oy do
