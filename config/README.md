# Configuration Guide

## Database Configuration

The application uses environment variables for database configuration. You can set these in your server environment or create a `.env` file:

```
DB_HOST=localhost
DB_NAME=docunest
DB_USER=root
DB_PASS=your_password_here
```

## Security Features

- CSRF protection on all forms
- Input sanitization and validation
- Secure password hashing
- Session timeout protection
- SQL injection prevention with prepared statements

## File Structure

- `includes/` - Core PHP classes and functions
- `processes/` - Form processing scripts
- `css/` - Stylesheets
- `js/` - JavaScript files
- `assets/` - Images and static files

## Setup Instructions

1. Create a MySQL database named `docunest`
2. Set up your database credentials in environment variables
3. Ensure PHP sessions are enabled
4. Make sure the `uploads/` directory is writable (if using file uploads)
