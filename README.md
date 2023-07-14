# ArtifactInk: 3D eCommerce for African craftwork
## Description

This is basically a 3D eCommerce website for selling African craftwork. The difference between this and regular eccomerce websites is that it incorporates 3D models of the products to increase user interactibility with the product in display thus the user gets a full scope of how the product looks like before purchase 



## Features

- **Product Catalog** 
Browse a wide range of 3D models, animations, textures, and more, organized into different categories for easy navigation.
- **User Accounts**
Create an account to save favorite products, track order history, and manage personal information
- **Shopping Cart**
Add desired products to the shopping cart, modify quantities, and proceed to checkout. 
- **Secure Payments**
Enjoy a secure and seamless payment process using the MPESA payment gateway.
- **Responsive Design**
 Experience a visually appealing and user-friendly interface that adapts to various screen sizes and devices


## Installation

 1. clone the repository ( https://github.com/jesse1234/csproject )
 2. Setup the backend in cmd ( https://nodejs.org )
```bash
   npm install -g npm
```
 3. From your terminal of choice e.g. Command Prompt. Run the codes below
```bash
  cd my-project
  npm install && npm run build
```
4. Configure the database connection in the .env file where it says DB_DATABASE = . 
 5. Start the backend server: npm run start Set up the frontend: 
 6. Install XAMPP and start the Apache and MySQL services.
    ```bash
    curl -O https://www.apachefriends.org/xampp-files/{version}/xampp-{version}-installer.dmg
    ```
 7. Place the frontend files in the appropriate directory preferably where you saved Xampp program files ( C:\xampp\htdocs). Set up the database: Open PHPMyAdmin (usually accessible at http://localhost/phpmyadmin). Create a new database and import the provided SQL dump file. 
 8. Set up authentication: Install Laravel Breeze: composer require laravel/breeze --dev Generate authentication scaffolding: php artisan breeze:install Install dependencies: npm install && npm run dev ( https://laravel.com/docs/10.x/starter-kits )
 9. Configure the payment gateway: Sign up for an MPESA account and obtain the required API credentials. Configure the MPESA credentials in the appropriate files.
    
## Technologies used
 - **Frontend**: HTML, CSS, JavaScript 
 - **Backend**: Node.js 
 - **Database**: XAMPP (MySQL) 
 - **Authentication**: Laravel Breeze 
 - **Payment Gateway**: MPESA 

We welcome contributions to the 3DCommerce Website project! If you'd like to contribute, please follow these guidelines

Thank you for visiting the 3DCommerce Website repository. Happy exploring and shopping for 3D products!

