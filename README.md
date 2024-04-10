# Installation Steps

1.  Clone the repository
    ```bash
    git clone https://github.com/h3mantD/EmployeeOps.git
    ```
2.  Change the working directory
    ```bash
    cd EmployeeOps
    ```
3.  Install dependencies
    ```bash
    composer install
    npm install
    ```
4.  Create a copy of your .env file
    ```bash
    cp .env.example .env
    ```
5.  Generate an app encryption key
    ```bash
    php artisan key:generate
    ```
6.  Add database configurations in .env

    ```bash
    # sqlite db details
    DB_CONNECTION=sqlite
    DB_DATABASE=/your-full-path/EmployeeOps/database/EmployeeOps.sqlite

    # mysql db details
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=root
    DB_PASSWORD=password
    ```

7.  Run the database migrations
    ```bash
    php artisan migrate
    ```
8.  Create super admin by executing the following command
    ```bash
    php artisan app:create-super-admin
    ```
9.  Build the frontend assets
    ```bash
    npm run build
    ```
10. Start the local development server
    ```bash
    php artisan serve
    ```
11. You can now access the server at http://127.0.0.1:8000
12. Login with the super admin credentials and now you can create employees and projects.
