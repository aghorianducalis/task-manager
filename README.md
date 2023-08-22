# Task Management System

## Overview

The Task Management System is a web application built with Laravel that allows users to manage their tasks. The goal of this project is to create a user-friendly interface for creating, editing, deleting, and viewing tasks. Users can create, edit, delete, and view tasks. Each task includes a title, description, status, and due date.

## Features

- User Registration and Authentication
- Create, Edit, Delete, and View Tasks
- Task Status (Not Started, In Progress, Completed)
- Validation for Task Creation and Updates
- Authorization: Users can only manage their tasks
- API Controller (Temporarily using Blade Templates)

## Installation

1. Requirements
   
Before starting work on the project, ensure that you have the following components installed:
- PHP
- Composer
- Node.js and npm
- MySQL
- Laravel
- Vite

2. Clone the repository to your local machine:
```shell
git clone https://github.com/aghorianducalis/task-manager.git
cd task-management-system
```
3. Install composer dependencies:
```shell
composer install
```
4. Init the environment

Copy the .env.example file and rename it to .env:
```shell
cp .env.example .env
```
Configure database access and other necessary parameters. Set up your database in the `.env` file:
```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
Generate an application key:
```shell
php artisan key:generate
```
5. Run database migrations:
```shell
php artisan migrate
```
6. Install JavaScript dependencies:
```shell
npm install
```
In another terminal, run Vite for frontend development:
```shell
npm run dev
```
7. Set up Laravel authentication:
```shell
php artisan make:auth
```
8. Start the development server:
```shell
php artisan serve
```

Now, you can open a web browser and navigate to http://localhost:8000 to view your project.


## Usage

Once you have started the Artisan development server, your application will be accessible in your web browser at http://localhost:8000.

After installing and configuring the project, you can:

Register, log in, and log out.
Add new tasks with mandatory fields: title, description, status, and deadline.
View a list of all tasks with the ability to edit or delete each task.
Set task statuses to: Not Started, In Progress, Completed.

## Authentication

The Task Management System includes user registration and authentication. Users can sign up, log in, and log out. Only authenticated users can create, edit, delete, and view their tasks.

## Testing

The application includes PHPUnit tests to ensure functionality and authorization are working as expected. Run the tests with the following command:

## Security Vulnerabilities

If you discover a security vulnerability within application, please send an e-mail to developer via [aghorianducalis@gmail.com](mailto:aghorianducalis@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
