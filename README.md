# PHP Laravel Test Task - BRT (Blume Reserve Ticket) Management System

This repository contains the solution for the Blume Reserve Ticket (BRT) Management System, developed using the PHP Laravel framework. The task focuses on implementing key features like JWT authentication, real-time notifications, and managing BRTs (financial instruments within the Blume ecosystem).

## Objective

The goal of this project is to build a custom BRT Management System that allows users to securely authenticate and manage their BRTs, with features such as CRUD operations and real-time notifications.

## Key Features

1. **OAuth2 Authentication with Laravel Passport**:
   - Implemented Passport for secure API authentication via JWT tokens.

2. **Real-time Notifications with Laravel Echo and Pusher**:
   - Integrated real-time communication for broadcasting updates to users.

3. **JWT Authentication**:
   - Used the `tymon/jwt-auth` package for JSON Web Token (JWT) based authentication.

4. **BRT Management**:
   - Created models, migrations, and controllers for handling BRTs, including CRUD operations.

## Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/gloriousnetworker/BRT-Management-System-Udofot.git

   Navigate to the project directory:

bash
Copy code
cd BRT-Management-System-YourName
Install dependencies:

bash
Copy code
composer install
Set up the .env file:

Copy the .env.example file to .env:
bash
Copy code
cp .env.example .env
Generate the application key:

bash
Copy code
php artisan key:generate
Migrate the database:

bash
Copy code
php artisan migrate
Run the application:

bash
Copy code
php artisan serve
Testing
The application includes tests for CRUD operations on the BRT feature. To run the tests, use:

bash
Copy code
php artisan test
Challenges and Limitations
Due to time constraints, the real-time notifications and data analytics dashboard were not fully implemented, but the setups and configurations for these features are in place.
