# Fruits Project

## Introduction

This is a project for managing fruit inventory. The project uses Symfony and Vue.js.

## Setup Instructions

To get started with the Fruits project, follow these steps:

1. Check System Requirements
    - Before proceeding with the setup, make sure that your system meets the [Symfony Technical Requirements](https://symfony.com/doc/current/setup.html).

2. Install Dependencies
    - You will need to install the following dependencies:
        - [Node.js and npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
        - [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
        - [Symfony CLI](https://symfony.com/download) (optional, if you prefer to use a virtual host, skip this step)

3. Clone the Project
    - Clone the project by running the following command in your terminal:
        ```
        git clone GIT_PROJECT_CLONE_URL fruits
        ```

4. Install Dependencies
    - Move to the project directory by running:
        ```
        cd fruits
        ```
    - Next, install PHP and Symfony dependencies by running:
        ```
        composer install
        ```
    - And then install Vue.js dependencies by running:
        ```
        npm install
        ```

5. Configure Environment Variables
    - Copy the `.env` file to `.env.local` and update the database credentials. You can do this by running:
        ```
        cp .env .env.local
        ```
    - Open the `.env.local` file and update the `DATABASE_URL` variable with your database credentials.

6. Create the Database
    - Create the database by running:
        ```
        php bin/console doctrine:database:create
        ```

7. Run Migrations
    - Run the database migrations by running:
        ```
        php bin/console doctrine:migrations:migrate
        ```

8. Fetch Fruits from API
    - Run the command to fetch fruits from the API:
        ```
        php bin/console fruits:fetch
        ```

9. Start the Server
    - Start the server by running:
        ```
        symfony server:start
        ```
    - In another terminal tab, run:
        ```
        npm run dev-server
        ```

10. Access the Application
    - Finally, open your browser and navigate to `http://127.0.0.1:8000/` to access the application.

Enjoy using the Fruits project!
