# Authboard - Social Feed Extension

**PHP version**: 8.2+  
**Original Repository**: [nkb-bd/metro_wb_lab](https://github.com/nkb-bd/metro_wb_lab)

This is a continuation and enhancement of the original Metro Web Lab assignment that transforms a basic authentication system into a full-featured social platform with feed functionality.

## Enhanced Features
### Core Authentication System (Original)
- User registration & login with comprehensive validation
- Secure session management with persistent user state
- Password hashing with bcrypt algorithm
- Email sending integration (Mailtrap + PHPMailer)

### Social Feed Extension (New)
- **Post Management**: Create, edit, and delete posts with rich content
- **Image Upload**: Support for JPG, PNG, GIF, WebP formats (up to 25MB)
- **Social Timeline**: Multi-user content display in chronological order
- **User Engagement**: Real-time like system with AJAX interactions
- **User Distinction**: Color-coded profiles with visual identification
- **File Management**: Secure image upload, validation, and storage system
- **Activity Dashboard**: User statistics with post counts and like analytics

### Advanced Features (New)
- **Real-time Interactions**: AJAX-powered like/unlike without page refresh
- **User Analytics**: Dashboard with total posts and likes tracking
- **Visual Feedback**: Optimistic UI updates with fallback handling
- **Enhanced UI**: Dark/light theme consistency across all components
- **Password Visibility**: Toggle show/hide functionality with proper icons

## Tools Used
- **Backend**: PHP 8.2+ with MVC architecture and custom routing
- **Database**: MySQL with PDO prepared statements and foreign key constraints
- **Frontend**: Tailwind CSS, JavaScript (ES6+), responsive design
- **Routing**: Custom PHP router with RESTful endpoint handling
- **Dependencies**: Composer, PHPMailer, PDO MySQL driver
- **Development**: XAMPP, phpMyAdmin, Git version control


## Quick Setup
1. **Clone & Configure**
   ```bash
   git clone https://github.com/Ishrak-Saleh/simple-authentication-system.git
   cd simple-authentication-system
   cp .env.example .env
   # Edit .env with your database credentials
   ```
2. **Database Setup**
   ```sql
   CREATE DATABASE authboard;
   USE authboard;
   # Import sql/schema.sql
   ```
3. **Install Dependencies**
   ```bash
   composer install
   ```
4. **Run application**
   ```bash
   php -S localhost:8000 -t public
   ```
5. **Access**
   Visit http://localhost:8000/


## Key Features Demonstrated
- **MVC Architecture** with proper separation of concerns and organized code structure
- **Authentication System** with secure password handling and user session management
- **Session Management** across page requests with persistent user state
- **File Upload** with validation, security measures, and image processing
- **Social Feed** with multi-user content display, real-time interactions, and post management
- **Database Operations** using PDO with prepared statements and efficient query handling
- **Email Integration** for user notifications and system communications
- **Like System** with AJAX-powered real-time interactions and optimistic UI updates
- **User Dashboard** with activity statistics, post analytics, and engagement metrics
- **Responsive UI** with dark/light theme support and mobile-first design

## Security Implementation
- **Password Security**: Bcrypt hashing with `password_hash()` and `password_verify()`
- **SQL Injection Prevention**: PDO prepared statements with parameter binding
- **XSS Protection**: Comprehensive `htmlspecialchars()` output encoding
- **File Upload Security**: Type validation, size limits, and secure storage practices
- **Session-based Authentication**: Middleware protection for all restricted routes
- **CSRF Protection**: Form validation and session-based token verification
- **Input Sanitization**: Data validation and sanitization across all user inputs
- **Secure File Handling**: Proper file type verification and upload directory permissions
