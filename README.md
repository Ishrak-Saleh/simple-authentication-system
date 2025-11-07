# Authboard - Social Feed Extension

**PHP version**: 8.2+  
**Original Repository**: [nkb-bd/metro_wb_lab](https://github.com/nkb-bd/metro_wb_lab)

This is a continuation and enhancement of the original Metro Web Lab assignment that transforms a basic authentication system into a full-featured social platform with feed functionality.

## Enhanced Features
### Core Authentication System (Original)
- User registration & login with validation
- Secure session management
- Password hashing with bcrypt
- Email sending integration (Mailtrap + PHPMailer)

### Social Feed Extension (New)
- **Post Creation**: Users can create text posts with optional images
- **Image Upload**: Support for JPG, PNG, GIF, WebP (up to 10MB)
- **Social Timeline**: View posts from all users in chronological order
- **User Engagement**: Posts display author names and creation timestamps
- **File Management**: Secure image upload and storage system

## Tools Used
- **Backend**: PHP 8.2+ with MVC architecture
- **Database**: MySQL with PDO prepared statements
- **Frontend**: HTML, CSS, PHP Templates
- **Routing**: Custom PHP router
- **Dependencies**: Composer, PHPMailer

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
- **MVC Architecture** with proper separation of concerns
- **Authentication System** with secure password handling
- **Session Management** across page requests
- **File Upload** with validation and security measures
- **Social Feed** with multi-user content display
- **Database Operations** using PDO with prepared statements
- **Email Integration** for user notifications

## Security Implementation
- Password hashing with `password_hash()`
- SQL injection prevention via PDO prepared statements
- XSS protection with `htmlspecialchars()`
- File upload validation (type, size, security)
- Session-based authentication middleware
