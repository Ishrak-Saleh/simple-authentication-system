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

### Social Feed Extension (Enhanced)
- **Post Management**: Create, edit, and delete posts with rich text content and image support
- **Image Upload**: Multi-format support (JPG, PNG, GIF, WebP) with 25MB file size limit
- **Social Timeline**: Multi-user content feed with chronological ordering and real-time updates
- **User Engagement**: AJAX-powered like/unlike system with instant UI feedback
- **User Profiles**: Comprehensive profile system with bio sections and public profile views
- **Profile Pictures**: Custom avatar uploads with image validation and management
- **File Management**: Secure file upload system with type validation and storage organization

### Advanced Features (Enhanced)
- **Real-time Interactions**: AJAX-powered like system with optimistic UI updates
- **User Analytics**: Comprehensive dashboard with post statistics and engagement metrics
- **Profile System**: Bio editing with character limits and real-time saving
- **Public Profiles**: Limited-access user profiles with activity statistics
- **Dynamic Routing**: URL parameter support for user profile links (/profile/user/{id})
- **Theme System**: Complete dark/light mode toggle with system preference detection
- **Theme Persistence**: localStorage-based theme saving with automatic OS detection
- **Password Visibility**: Toggle show/hide functionality with proper SVG icons

### User Interface & Experience
- **Responsive Design**: Mobile-first approach with Tailwind CSS breakpoints
- **Visual Feedback**: Loading states, success/error messages, and hover effects
- **Accessibility**: Proper ARIA labels, keyboard navigation, and semantic HTML
- **Consistent Design**: Unified header system across all application pages
- **Modal System**: Create and edit post modals with image preview capabilities
- **Navigation**: Intuitive header navigation with profile picture integration

## Tools & Technologies
- **Backend**: PHP 8.2+ with custom MVC architecture and RESTful routing
- **Database**: MySQL with PDO prepared statements and foreign key constraints
- **Frontend**: Tailwind CSS, vanilla JavaScript (ES6+), responsive grid layouts
- **Routing**: Custom PHP router with dynamic parameter support and RESTful endpoints
- **File Handling**: Secure upload system with MIME type validation and size limits
- **Session Management**: Custom session handler with user state persistence
- **Dependencies**: Composer, PHPMailer for email functionality, PDO MySQL driver
- **Development Stack**: XAMPP, phpMyAdmin, Git version control with feature branching
- **Theme Engine**: Tailwind CSS dark mode class strategy with JavaScript persistence layer
- **AJAX Integration**: Fetch API for real-time interactions without page reloads

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
