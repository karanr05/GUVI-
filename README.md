# User Management System

Welcome to the User Management System! This web application facilitates user registration, login, and profile updates. It employs a blend of HTML, CSS, JavaScript, and PHP for the frontend and backend. The MySQL database stores user data, while Redis and MongoDB manage user sessions.
## Features

- User registration with username, password, and email.
- User login and session management.
- User profile management, including phone number, date of birth, and address.
- Data stored in both MySQL and MongoDB databases.
- Session management using Redis.
- Strong password encryption using hashing algorithms such as bcrypt.
- Form validation and error handling to ensure data integrity.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- Web server (e.g., Apache, Nginx)
- PHP (version 7.4 or higher)
- MySQL or MariaDB
- MongoDB
- Redis
- Composer (for PHP package management)
- Node.js and npm (if you plan to modify the frontend)
- Git (for source code management)

## Installation on localhost

### Clone or Download

- Clone the repository or download the source code.

### Redis Setup

1. Install Composer and Predis in the PHP folder of the project directory.
2. Run the following command in the PHP folder via the terminal:
    ```bash
    composer require predis/predis
    ```

### Install MongoDB/Client

1. Install MongoDB/MongoDB Composer by running:
    ```bash
    composer require mongodb/mongodb
    ```
2. Alternatively, enable the MongoDB extension in your PHP configuration files.

### Create MySQL Database

- Set up a MySQL database for user data.

### Update Database Credentials

- Update your database credentials accordingly and ensure successful integration between Redis, MongoDB, PHP, and MySQL.

### Run Localhost Server

1. Execute the following command in the terminal:
    ```bash
    php -S localhost:8000
    ```
2. Make sure to navigate to the project directory.

## Usage

- **Register a new account**:
    - Visit the `/register` page and fill in the required details.
  
- **Log in**:
    - Visit the `/login` page and enter your credentials.
  
- **Manage your profile**:
    - Once logged in, navigate to the `/profile` page to update your personal details.

## Project is not yet deployed

- This project is currently not deployed. Please follow the instructions above to set it up on your localhost for testing and development purposes.

## Project Demo 
- **Video link**: https://drive.google.com/file/d/1Kk4Capys5Pxx-fE8Krm7R7D3Ml-3KlCF/view?usp=sharing

