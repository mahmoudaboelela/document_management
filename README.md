# Document Management System API

This is a **Document Management System** built with **Laravel 11**. It provides functionality for creating, updating, deleting, and managing versions of documents. The API uses **Laravel Sanctum** for authentication and **Spatie Laravel Permission** for managing roles and permissions.

## Table of Contents
- [Installation](#installation)
- [Environment Setup](#environment-setup)
- [Authentication](#authentication)
- [Roles and Permissions](#roles-and-permissions)
- [API Endpoints](#api-endpoints)
- [Running Tests](#running-tests)
- [License](#license)

## Installation

Follow these steps to get the application up and running:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/document-management-api.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd document-management-api
    ```

3. **Install dependencies**:
    ```bash
    composer install
    ```

4. **Set up environment variables**:
    Copy the example `.env` file to create your own `.env`:
    ```bash
    cp .env.example .env
    ```

5. **Generate the application key**:
    ```bash
    php artisan key:generate
    ```

6. **Run the migrations**:
    ```bash
    php artisan migrate
    ```

7. **Seed the database with default roles and permissions**:
    ```bash
    php artisan db:seed
    ```

---

## Environment Setup

Make sure to set the following environment variables in your `.env` file:

- **Database**: Configure your database settings for MySQL or another database type:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

    ```

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

### Login

To login, send a `POST` request to `/api/login` with the required data:

**Request Body**:
```json
//User
{
    "email": "user@test.com",
    "password": "12345678",
}

//Admin
{
    "email": "admin@test.com",
    "password": "12345678",
}

//Viewer
{
    "email": "viewer@test.com",
    "password": "12345678",
}
