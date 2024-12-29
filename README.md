# Laravel Backend API Starter Kit for Mojura Architecture

This starter kit provides a fully implemented backend solution based on the **Mojura Architecture** concepts, designed to speed up your development process. It includes robust features for **authentication**, **authorization**, **user management**, and **security**, making it a comprehensive starting point for building scalable applications.

### Key Features:

1. **Authentication**
   - **Login**: Secure user authentication with token-based login.
   - **Logout**: Options for logging out from a single session or all active sessions.
   - **Profile Management**: Retrieve and update user profile information.

2. **Authorization**
   - **Authorize Middleware**: Enforce role-based access control (RBAC) with flexible permission management.
   - **UserCheck Middleware**: Additional checks for user-specific access control.
   - **Role & Abilities Management**: Manage roles and permissions using **ICRUD** (Interface-based CRUD operations).
   - **CASL Compatibility**: Seamless integration with [CASL](https://casl.js.org), a powerful JavaScript library for frontend authorization.

3. **User Management**
   - **ICRUD-based User Management**: Full support for user creation, updating, deletion, and listing, following the ICRUD principles.

4. **Snowflake ID Integration**
   - Generate unique IDs for entities, ensuring distributed, collision-free identifiers across the application.

5. **Telescope Integration**
   - Integrated with Laravel Telescope, providing powerful debugging and monitoring tools, secured with web-based authentication for access control.

This starter kit ensures you can quickly build secure, scalable, and manageable applications with ease while adhering to the best practices laid out by **Mojura Architecture**.  <br><br>

---

### ICRUD Resources Management

This system follows the **ICRUD** (Interface-based CRUD) principles for efficient and flexible management of resources. The main operations include:

1. **Index**: A comprehensive mechanism for bulk resource retrieval via a single endpoint, with support for:
   - **Listing**: Fetch a list of resources.
   - **Filtering**: Filter resources based on specified criteria.
   - **Searching**: Search resources using keywords or advanced queries.
   - **Sorting**: Sort resources by one or more fields.
   - **Pagination**: Paginate results for efficient data handling.

2. **Create**: Add a new resource to the system.

3. **Read**: Retrieve detailed information for a specific resource.

4. **Update**: Modify an existing resource.

5. **Delete**: Remove a resource from the system.


## Setup
### 1. Framework
```
composer install
cp .env.example .env #Don't forget to configure your .env file

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

php artisan vendor:publish --tag=mojura-config
php artisan vendor:publish --tag=mojura-stubs
```
### 2. JWT Authentication  
```
php artisan jwt:keys
```
- You may need to install 'openssl' when using windows command prompt. If you are using GitBash or Linux Shell, it won't be a problem.
- The folder `storage/app/private/jwt`  is pre-created in starter kit to store generated private and public key files.

### 3. Telescope
```
php artisan telescope:install
```

## Run in Development Environment
```
# run dev server
php artisan serve
```

### API Documentation
https://documenter.getpostman.com/view/11315502/2sAYJ6DLBs
