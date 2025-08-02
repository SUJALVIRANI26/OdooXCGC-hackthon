# 🎫 QuickDesk - Modern Help Desk System

A comprehensive, modern help desk solution built with PHP, MySQL, and Bootstrap. QuickDesk provides an intuitive interface for managing customer support tickets, user management, and performance analytics.

![QuickDesk Dashboard](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

## 🌟 Features

### 🎯 Core Functionality
- **Ticket Management** - Create, assign, track, and resolve support tickets
- **User Management** - Multi-role system (Admin, Agent, User)
- **Category System** - Organize tickets by categories with color coding
- **Priority Levels** - Urgent, High, Medium, Low priority handling
- **Status Tracking** - Open, In Progress, Resolved, Closed statuses
- **Comment System** - Internal and public comments on tickets
- **File Attachments** - Upload and manage ticket attachments

### 👥 User Roles & Permissions
- **Admin** - Full system access, user management, system configuration
- **Agent** - Ticket management, customer interaction, reporting
- **User** - Create tickets, view own tickets, communicate with agents

### 📊 Analytics & Reporting
- **Live Statistics** - Real-time dashboard with key metrics
- **Performance Metrics** - Average resolution time, satisfaction rates
- **Category Analytics** - Ticket distribution and resolution rates
- **Time-based Reports** - Daily, weekly, monthly statistics
- **User Activity** - Track user engagement and productivity

### 🔐 Security Features
- **Password Reset System** - Secure token-based password recovery
- **Input Validation** - Comprehensive client and server-side validation
- **SQL Injection Protection** - Prepared statements throughout
- **Session Management** - Secure user authentication
- **Role-based Access Control** - Granular permission system

### 🎨 User Experience
- **Responsive Design** - Mobile-first, works on all devices
- **Modern UI** - Clean, intuitive interface with Bootstrap 5
- **Real-time Updates** - Dynamic content loading
- **Search & Filtering** - Advanced ticket filtering options
- **Demo System** - Try different user roles instantly

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

### Installation

1. **Clone the repository**
   \`\`\`bash
   git clone https://github.com/yourusername/quickdesk.git
   cd quickdesk
   \`\`\`

2. **Database Setup**
   - Create a MySQL database named `quickdesk`
   - Import the database schema:
   \`\`\`bash
   mysql -u your_username -p quickdesk < database/setup.sql
   \`\`\`

3. **Configuration**
   - Update database credentials in `config/database.php`:
   \`\`\`php
   private $host = 'localhost';
   private $db_name = 'quickdesk';
   private $username = 'your_username';
   private $password = 'your_password';
   \`\`\`

4. **File Permissions**
   \`\`\`bash
   chmod 755 uploads/
   chmod 644 uploads/.htaccess
   \`\`\`

5. **Access the Application**
   - Open your web browser and navigate to your domain
   - The system will automatically create tables and sample data


## 📁 Project Structure

\`\`\`
quickdesk/
├── assets/
│   ├── css/
│   │   ├── style.css          # Main application styles
│   │   └── home.css           # Homepage styles
│   └── js/
│       ├── main.js            # Core JavaScript
│       └── home-animations.js # Homepage animations
├── classes/
│   ├── User.php               # User management
│   ├── Ticket.php             # Ticket operations
│   ├── Category.php           # Category management
│   ├── Comment.php            # Comment system

├── config/
│   ├── database.php           # Database configuration
│   └── config.php             # Application settings
├── pages/
│   ├── login.php              # Login page
│   ├── register.php           # User registration
│   ├── dashboard.php          # Main dashboard
│   ├── tickets.php            # Ticket listing
│   ├── ticket-detail.php      # Ticket details
│   ├── create-ticket.php      # New ticket form
│   ├── users.php              # User management
│   ├── categories.php         # Category management
│   ├── profile.php            # User profile
│   ├── forgot-password.php    # Password recovery
│   └── reset-password.php     # Password reset
├── uploads/                   # File attachments
├── database/
│   └── setup.sql              # Database schema
├── index.php                  # Homepage
├── dashboard.php              # Application entry point
└── README.md                  # This file
\`\`\`

## 🔧 Configuration

### Database Configuration
Edit `config/database.php` to match your database settings:

\`\`\`php
class Database {
    private $host = 'localhost';
    private $db_name = 'quickdesk';
    private $username = 'your_username';
    private $password = 'your_password';
}
\`\`\`

### File Upload Settings
Configure file upload limits in `config/config.php`:

\`\`\`php
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);
\`\`\`

## 📊 Database Schema

### Core Tables
- **users** - User accounts and authentication
- **tickets** - Support tickets and metadata
- **categories** - Ticket categorization
- **comments** - Ticket comments and communication
- **attachments** - File uploads and attachments

### Relationships
- Users can create multiple tickets
- Tickets belong to categories
- Tickets can have multiple comments
- Tickets can have multiple attachments
- Agents can be assigned to tickets

## 🎯 Usage Examples

### Creating a Ticket (User)
1. Login as a user
2. Navigate to "Create Ticket"
3. Fill in title, description, select category and priority
4. Optionally attach files
5. Submit ticket

### Managing Tickets (Agent)
1. Login as an agent
2. View assigned tickets in dashboard
3. Update ticket status and priority
4. Add comments for communication
5. Resolve tickets when complete

### System Administration (Admin)
1. Login as admin
2. Manage users and roles
3. Create and manage categories
4. View system-wide statistics
5. Configure system settings

## 📈 Statistics & Analytics

QuickDesk provides comprehensive analytics:

- **Ticket Metrics** - Total, open, resolved, closed counts
- **Performance Data** - Average resolution time, satisfaction rates
- **User Analytics** - Active users, role distribution
- **Category Insights** - Ticket distribution by category
- **Time-based Reports** - Daily, weekly, monthly trends

## 🔒 Security Features

- **Input Validation** - All user inputs are validated and sanitized
- **SQL Injection Protection** - Prepared statements used throughout
- **Password Security** - Bcrypt hashing for password storage
- **Session Security** - Secure session management
- **File Upload Security** - Restricted file types and sizes
- **CSRF Protection** - Token-based form protection

## 🎨 Customization

### Themes
- Modify `assets/css/style.css` for application styling
- Update `assets/css/home.css` for homepage appearance
- Bootstrap 5 classes available throughout

### Categories
- Add custom categories with color coding
- Configure category-specific workflows
- Set category permissions and restrictions

### User Roles
- Extend existing roles or create new ones
- Modify permissions in user management
- Customize dashboard views per role

## 🚀 Deployment

### Production Checklist
- [ ] Update database credentials
- [ ] Set secure file permissions
- [ ] Configure SSL certificate
- [ ] Enable error logging
- [ ] Set up automated backups
- [ ] Configure email settings
- [ ] Update default passwords

### Recommended Server Configuration
```apache
# .htaccess for Apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
