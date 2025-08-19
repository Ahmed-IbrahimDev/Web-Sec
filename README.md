# WebSec230200064 - Laravel Web Application

This is a secure Laravel web application that includes user authentication, product management, role-based access control, and various utility features.

## Features

- User Authentication (Login, Register, Logout)
- Product Management (CRUD operations)
- Product Catalog
- Dashboard with Statistics
- Role-Based Access Control
- Permission Management
- Utility Features (Even Numbers Generator, Multiplication Table)

## Security Features

- CSRF Protection
- SQL Injection Prevention
- XSS Protection
- Input Validation and Sanitization
- Role-Based Access Control
- Secure Password Hashing

## Installation

1. Clone the repository
2. Navigate to the project directory
3. Install dependencies:
   ```
   composer install
   ```
4. Create a copy of the `.env.example` file and rename it to `.env`
5. Generate an application key:
   ```
   php artisan key:generate
   ```
6. Configure your database settings in the `.env` file
7. Run migrations and seed the database:
   ```
   php artisan migrate --seed
   ```
8. Start the development server:
   ```
   php artisan serve
   ```

## Default Users

After seeding the database, the following user will be available:

- Admin User
  - Email: admin@example.com
  - Password: password

## Roles and Permissions

The application includes three default roles:

1. **Admin**: Full access to all features
2. **Manager**: Can manage products and view users
3. **User**: Basic access to view products

## Database Structure

- **Users**: Stores user information
- **Products**: Stores product information
- **Roles**: Defines user roles
- **Permissions**: Defines available permissions
- **Role_User**: Maps users to roles
- **Permission_Role**: Maps permissions to roles

## Routes

- `/`: Welcome page
- `/login`: User login
- `/register`: User registration
- `/products`: Product listing and management
- `/catalog`: Product catalog
- `/dashboard`: Application dashboard
- `/permissions`: Role and permission management
- `/even-numbers`: Even numbers generator
- `/multiplication`: Multiplication table generator

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
