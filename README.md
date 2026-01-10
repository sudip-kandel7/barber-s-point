# 💈 Barber's Point

> A comprehensive web application connecting customers with barber shops, featuring real-time queue management, booking systems, and reviews.

**Live Demo:** [https://barber-point.kesug.com](https://barber-point.kesug.com)

![Barber's Point Banner](./path-to-banner-image.png)

---

## 📋 Table of Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
  - [Windows Installation](#windows-installation)
  - [Linux Installation](#linux-installation)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Default Admin Credentials](#default-admin-credentials)
- [Contributing](#contributing)
- [Team](#team)
- [License](#license)

---

## ✨ Features

### For Customers

- 🔍 Search and browse barber shops by location
- 📊 View real-time queue status and wait times
- 📅 Book appointments with multiple services
- ⭐ Read and write shop reviews
- ❤️ Save favorite shops
- 📱 Responsive mobile-friendly interface

### For Barbers

- 🏪 Create and manage shop profile
- 💇 Manage services and pricing
- 👥 Real-time queue management
- ✅ Start and complete customer services
- 📊 Track daily earnings
- 🕐 Set shop hours (open/close)

### For Admins

- ✅ Approve/reject new barber shop registrations
- 👮 Manage users and shops (suspend/delete)
- 📝 Handle complaints and feedback
- 📊 View platform statistics
- 🔍 Monitor reviews


## 🛠️ Tech Stack

- **Frontend:** HTML5, Tailwind CSS, JavaScript (Vanilla)
- **Backend:** PHP 
- **Database:** MySQL 
- **Server:** Apache (via XAMPP)
- **Version Control:** Git & GitHub

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **Git:** Download from [git-scm.com](https://git-scm.com/)
- **XAMPP:** Download from [apachefriends.org](https://www.apachefriends.org/)
  - Includes: Apache, MySQL, PHP
- **Text Editor:** VS Code, Sublime Text, or any code editor

---

## 🚀 Installation Guide

### Windows Installation

#### 1. Install XAMPP

1. Download XAMPP from [apachefriends.org](https://www.apachefriends.org/download.html)
2. Run the installer (`.exe` file)
3. Choose installation directory (default: `C:\xampp`)
4. Select components:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin
5. Complete the installation
6. Open **XAMPP Control Panel**

#### 2. Clone the Repository

```bash
# Open Git Bash or Command Prompt
# Navigate to htdocs folder
cd C:\xampp\htdocs

# Clone the repository
git clone https://github.com/sudip-kandel7/barber-s-point.git

# Navigate into project directory
cd barber-s-point
```

#### 3. Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should show green "Running" status

#### 4. Create Database

1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click **New** in the left sidebar
3. Database name: `barber_point`
4. Collation: `utf8mb4_general_ci`
5. Click **Create**

#### 5. Import Database Schema

1. Click on `barber_point` database
2. Click **Import** tab
3. Click **Choose File**
4. Select `barberpoint.sql` from project folder
5. Click **Go** at the bottom
6. Wait for success message

#### 6. Access the Application

Open browser and visit:

- **Homepage:** `http://localhost/barber-s-point`
- **Admin Login:** `http://localhost/barber-s-point/admin.php`

---

### Linux Installation

#### 1. Install XAMPP

```bash
# Download XAMPP
cd ~/Downloads
wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.2.12/xampp-linux-x64-8.2.12-0-installer.run

# Make installer executable
chmod +x xampp-linux-x64-8.2.12-0-installer.run

# Run installer
sudo ./xampp-linux-x64-8.2.12-0-installer.run

# Start XAMPP
sudo /opt/lampp/lampp start
```

#### 2. Clone the Repository

```bash
# Navigate to htdocs
cd /opt/lampp/htdocs

# Clone repository
sudo git clone https://github.com/sudip-kandel7/barber-s-point.git

# Set permissions
sudo chmod -R 755 barber-s-point
sudo chown -R daemon:daemon barber-s-point
```

#### 3. Create Database

```bash
# Access MySQL
sudo /opt/lampp/bin/mysql -u root

# Create database
CREATE DATABASE barber_point;
exit;

# Import SQL file
sudo /opt/lampp/bin/mysql -u root barber_point < /opt/lampp/htdocs/barber-s-point/barberpoint.sql
```

#### 4. Access the Application

- **Homepage:** `http://localhost/barber-s-point`
- **Admin:** `http://localhost/barber-s-point/admin.php`

---

## 🗄️ Database Setup

### Database Schema

The `barberpoint.sql` file creates the following tables:

```sql
-- Users Table
CREATE TABLE users (
    uid INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('customer', 'barber', 'admin') NOT NULL DEFAULT 'customer',
    status ENUM('active', 'suspended') DEFAULT 'active',
    name VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15),
    passwrd VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Shops Table
CREATE TABLE shop (
    sid INT PRIMARY KEY AUTO_INCREMENT,
    sname VARCHAR(100) NOT NULL,
    saddress VARCHAR(50) NOT NULL,
    photo TEXT NOT NULL,
    uid INT NOT NULL,
    status ENUM('pending', 'open', 'closing', 'closed', 'suspended') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    approved_at DATETIME NULL,
    approved_by INT NULL,
    FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE
);

-- Queue Table
CREATE TABLE queue (
    sid INT PRIMARY KEY,
    current_queue INT NOT NULL DEFAULT 0,
    total_wait_time TIME NOT NULL DEFAULT '00:00:00',
    FOREIGN KEY(sid) REFERENCES shop(sid) ON DELETE CASCADE
);

-- Bookings Table
CREATE TABLE booking (
    bid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    sid INT NOT NULL,
    booking_number INT NOT NULL,
    status ENUM('waiting', 'in_service', 'completed', 'cancelled') DEFAULT 'waiting',
    total_duration INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    service_started_at DATETIME NULL,
    completed_at DATETIME NULL,
    FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE
);

-- Reviews Table
CREATE TABLE review (
    rid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    sid INT NOT NULL,
    review TEXT NOT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY(sid) REFERENCES shop(sid) ON DELETE CASCADE,
    UNIQUE (uid, sid)
);

-- Feedback/Complaints Table
CREATE TABLE feedback (
    fid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    sid INT NULL,
    type ENUM('feedback', 'complaint') NOT NULL,
    msg TEXT NOT NULL,
    status ENUM('pending', 'resolved') DEFAULT 'pending',
    responded_by INT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_resolved DATETIME NULL,
    FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY(sid) REFERENCES shop(sid) ON DELETE CASCADE,
    FOREIGN KEY(responded_by) REFERENCES users(uid) ON DELETE SET NULL
);

-- Services Table
CREATE TABLE services (
    services_id INT PRIMARY KEY AUTO_INCREMENT,
    services_name VARCHAR(100) NOT NULL UNIQUE
);

-- Shop Services (Junction Table)
CREATE TABLE shop_services (
    sid INT NOT NULL,
    services_id INT NOT NULL,
    price INT NOT NULL,
    duration INT NOT NULL,
    PRIMARY KEY (sid, services_id),
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE,
    FOREIGN KEY (services_id) REFERENCES services(services_id) ON DELETE CASCADE
);

-- Favorites Table
CREATE TABLE favorites (
    uid INT NOT NULL,
    sid INT NOT NULL,
    PRIMARY KEY(uid, sid),
    FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE
);
```

### Insert Default Admin (Optional)

```sql
-- Create default admin account
-- Email: admin@barberpoint.com
-- Password: admin123

INSERT INTO users (type, name, email, passwrd)
VALUES ('admin', 'System Admin', 'admin@barberpoint.com', '0192023a7bbd73250516f069df18b500');
```

---

## 📁 Project Structure

```
barber-s-point/
├── .github/
│   └── workflows/
│       └── deploy.yml
├── public/
│   ├── images/
│   │   ├── barber/          # Shop photos
│   │   └── web/             # UI icons & images
│   ├── js/
│   │   ├── dashboard.js
│   │   ├── login.js
│   │   ├── myshop.js
│   │   ├── profile.js
│   │   ├── register.js
│   │   ├── script.js
│   │   ├── shop_info.js
│   │   └── shops.js
│   └── style/
│       └── style.css
├── about.php
├── add_review.php
├── addfavorite.php
├── admin.php
├── barberpoint.sql          # Database schema
├── book_services.php
├── cancel_booking.php
├── contact.php
├── dashboard.php            # Admin dashboard
├── emailCheck.php
├── footer.php
├── header.php
├── home.php
├── index.php
├── login.php
├── logout.php
├── myshop.php               # Barber dashboard
├── navbar.php
├── pop_up.php
├── profile.php              # Customer profile
├── README.md
├── register.php
├── sessionCheck.php
├── shop_info.php
├── shopdetails.php
├── shops.php
├── update_profile.php
├── update_profile_process.php
├── update_queue.php
├── User.php
└── tailwind.config.js
```

---

## 💻 Usage

### For Customers

1. **Register/Login**

   - Visit homepage
   - Click "Register" or "Login"
   - Fill in details

2. **Browse Shops**

   - Use search bar
   - Filter by status
   - Sort by queue/wait time

3. **Book Appointment**

   - Click shop card
   - Select "View Details"
   - Choose services
   - Confirm booking

4. **Write Review**
   - Visit shop details
   - Click Reviews tab
   - Enter comment
   - Submit

### For Barbers

1. **Register Shop**

   - Register as "Barber Shop Owner"
   - Fill shop details
   - Upload shop photo
   - Add services & pricing
   - Wait for admin approval

2. **Manage Queue**

   - Login to My Shop
   - View waiting customers
   - Start service
   - Complete service

3. **Update Info**
   - Click "Update Info"
   - Edit personal/shop details
   - Add/remove services
   - Change pricing

### For Admins

1. **Login**

   - Visit `/admin.php`
   - Use admin credentials

2. **Approve Shops**

   - Go to "Pending Approvals"
   - Review shop details
   - Approve or Reject

3. **Handle Complaints**
   - Go to "Complaints" tab
   - View complaint details
   - Mark as Resolved
   - Or Delete if spam

---

## 🔐 Default Admin Credentials

After database setup, create admin manually or use:

**Email:** `admin@barberpoint.com`  
**Password:** `admin123`

**⚠️ Change these credentials immediately after first login!**

To create admin account:

```sql
INSERT INTO users (type, name, email, passwrd)
VALUES ('admin', 'Your Name', 'your-email@domain.com', MD5('your-password'));
```

---

## 🤝 Contributing

We welcome contributions! Here's how:

### Fork & Clone

```bash
# 1. Fork the repository on GitHub

# 2. Clone your fork
git clone https://github.com/YOUR-USERNAME/barber-s-point.git

# 3. Create a branch
git checkout -b feature/your-feature-name

# 4. Make changes and commit
git add .
git commit -m "Add: your feature description"

# 5. Push to your fork
git push origin feature/your-feature-name

# 6. Create Pull Request on GitHub
```

### Development Guidelines

- Follow existing code style
- Test thoroughly before PR
- Update README if needed
- Add comments for complex logic

---

## 👥 Team

### Developers

**Sudip Kandel**

- GitHub: [@sudip-kandel7](https://github.com/sudip-kandel7)
- Role: Full-stack Developer
- Email: sudip@example.com

**Kushal Pandit**

- GitHub: [@kushal-pandit](https://github.com/kushal-pandit)
- Role: Full-stack Developer
- Email: kushal@example.com

### Academic Details

- **Course:** BCA 4th Semester Project
- **Institution:** Birendra Multiple Campus, Bharatpur
- **Academic Year:** 2024-2025

---

## 📝 License

This project is created for educational purposes as part of BCA curriculum.

© 2025 Barber's Point - Sudip Kandel & Kushal Pandit

---

## 🐛 Troubleshooting

### Common Issues

**1. Cannot access localhost**

```bash
# Check if Apache is running
# In XAMPP Control Panel, Apache should be green
```

**2. Database connection error**

```php
// Check database credentials in PHP files
$conn = new mysqli("localhost", "root", "", "barber_point");
```

**3. Permission denied (Linux)**

```bash
sudo chmod -R 755 /opt/lampp/htdocs/barber-s-point
sudo chown -R daemon:daemon /opt/lampp/htdocs/barber-s-point
```

**4. Port 80 already in use**

```bash
# Stop conflicting service
sudo service apache2 stop  # If Apache2 is running
```

---

## 📞 Support

For issues and questions:

- **GitHub Issues:** [Create an issue](https://github.com/sudip-kandel7/barber-s-point/issues)
- **Email:** support@barberpoint.com

---

## 🎯 Roadmap

Future enhancements planned:

- [ ] SMS notifications for queue
- [ ] Payment gateway integration
- [ ] Mobile app (Android/iOS)
- [ ] Barber availability calendar
- [ ] Multi-language support
- [ ] Dark mode theme

---

## 🙏 Acknowledgments

- Birendra Multiple Campus for project guidance
- [Tailwind CSS](https://tailwindcss.com/) for UI framework
- [Font Awesome](https://fontawesome.com/) for icons
- Open source community

---

**⭐ If you find this project helpful, please star it on GitHub!**

[Back to Top](#-barbers-point)
