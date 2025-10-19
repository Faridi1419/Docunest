# 📚 DocuNest

A modern, secure digital library and document management system built with PHP. DocuNest allows users to store, organize, and access their documents with a beautiful, responsive interface.

## ✨ Features

- 🔐 **Secure Authentication** - User registration and login with password hashing
- 📁 **Document Management** - Upload, organize, and manage your documents
- 🛡️ **Security First** - CSRF protection, input sanitization, and SQL injection prevention
- 📱 **Responsive Design** - Modern, mobile-friendly interface
- 🎨 **Beautiful UI** - Clean and intuitive user experience
- ⚡ **Fast & Lightweight** - Optimized for performance

## 🚀 Quick Start

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (optional, for dependency management)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Faridi1419/Docunest.git
   cd Docunest
   ```

2. **Set up the database**
   ```sql
   CREATE DATABASE docunest;
   ```

3. **Configure environment variables**
   Create a `.env` file in the root directory:
   ```env
   DB_HOST=localhost
   DB_NAME=docunest
   DB_USER=your_username
   DB_PASS=your_password
   ```

4. **Set up the database tables**
   Run the SQL script to create the necessary tables:
   ```sql
   -- Users table
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       email VARCHAR(255) UNIQUE NOT NULL,
       password_hash VARCHAR(255) NOT NULL,
       first_name VARCHAR(100) NOT NULL,
       last_name VARCHAR(100) NOT NULL,
       user_type ENUM('student', 'teacher', 'admin') DEFAULT 'student',
       university VARCHAR(255),
       major VARCHAR(255),
       year_of_study VARCHAR(50),
       profile_picture VARCHAR(255),
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

5. **Set permissions**
   ```bash
   chmod 755 uploads/
   chmod 644 config/database.php
   ```

6. **Start your web server**
   ```bash
   # Using PHP built-in server (for development)
   php -S localhost:8000
   ```

7. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

## 📁 Project Structure

```
Docunest/
├── assets/                 # Images and static files
│   ├── icons/             # Application icons
│   └── pictures/          # User images
├── config/                # Configuration files
│   ├── database.php      # Database configuration
│   └── README.md         # Configuration guide
├── css/                   # Stylesheets
│   ├── log-in.css        # Login page styles
│   ├── sign-up.css       # Registration page styles
│   ├── vault.css         # Main application styles
│   └── ...
├── includes/              # Core PHP classes
│   ├── auth.php          # Authentication class
│   ├── session.php       # Session management
│   └── functions.php     # Utility functions
├── js/                    # JavaScript files
├── processes/             # Form processing scripts
│   ├── login_process.php # Login handler
│   ├── signup_process.php # Registration handler
│   └── logout.php        # Logout handler
├── index.html            # Landing page
├── log-in.php           # Login page
├── sign-up.php          # Registration page
├── vault.php            # Main application
└── README.md            # This file
```

## 🔧 Configuration

### Database Configuration

The application uses environment variables for database configuration. Set these in your server environment or create a `.env` file:

```env
DB_HOST=localhost
DB_NAME=docunest
DB_USER=your_username
DB_PASS=your_password
```

### Security Settings

- **CSRF Protection**: Enabled on all forms
- **Session Timeout**: 1 hour (configurable)
- **Password Hashing**: Uses PHP's `password_hash()` with `PASSWORD_DEFAULT`
- **Input Sanitization**: All user inputs are sanitized

## 🛡️ Security Features

- ✅ **CSRF Protection** - All forms protected against cross-site request forgery
- ✅ **SQL Injection Prevention** - Prepared statements used throughout
- ✅ **XSS Protection** - Input sanitization and output escaping
- ✅ **Secure Sessions** - Session regeneration and timeout
- ✅ **Password Security** - Secure password hashing
- ✅ **Input Validation** - Comprehensive input validation

## 🎨 User Interface

- **Landing Page** - Beautiful welcome page with feature highlights
- **Authentication** - Clean login and registration forms
- **Dashboard** - Modern vault interface for document management
- **Responsive Design** - Works on desktop, tablet, and mobile

## 📝 Usage

1. **Registration**: Create a new account with your details
2. **Login**: Access your personal vault
3. **Document Management**: Upload and organize your documents
4. **Library**: Browse and manage your document collection

## 🔧 Development

### Adding New Features

1. Create new PHP files in appropriate directories
2. Follow the existing security patterns (CSRF, input sanitization)
3. Update the database schema if needed
4. Test thoroughly before deployment

### Code Standards

- Use prepared statements for all database queries
- Sanitize all user inputs
- Include CSRF tokens in all forms
- Follow PSR-12 coding standards

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check your database credentials
   - Ensure MySQL is running
   - Verify the database exists

2. **Session Issues**
   - Check PHP session configuration
   - Ensure session directory is writable

3. **File Upload Issues**
   - Check upload directory permissions
   - Verify PHP upload settings

### Debug Mode

For development, you can enable debug mode by setting:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Arash Bashiri**
- GitHub: [@Faridi1419](https://github.com/Faridi1419)

## 🙏 Acknowledgments

- PHP community for excellent documentation
- Contributors who helped improve the project
- Users who provided valuable feedback

---

**DocuNest** - Your personal digital library, secure and beautiful. 📚✨
