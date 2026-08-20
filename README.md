# CICTE Classroom Management System

A web-based **Classroom Management and Availability Monitoring System** developed for the **College of Information, Communication Technology and Engineering (CICTE) in Western Leyte College of Ormoc**.

The system is designed to centralize classroom and academic information while helping administrators and authorized users manage users, schedules, classrooms, subjects, courses, and other academic resources.

---

## 📌 About the Project

The **CICTE Classroom Management System** is a web-based platform developed to support the academic and classroom management operations of the **College of Information, Communication Technology and Engineering (CICTE)**.

The system provides different modules for administrators, teachers, students, and registrar personnel. It allows authorized users to manage academic information, classroom schedules, users, rooms, subjects, courses, and student records through a centralized system.

One of the key features of the system is **Classroom Availability Monitoring**, which allows authorized users to check classroom schedules and determine whether a classroom is currently occupied or available based on the scheduled classes.

The project aims to reduce manual processes, improve organization, minimize scheduling conflicts, and make classroom and academic information easier to manage and access.

---

# ✨ Features

## 🔐 User Authentication & Role Management

The system provides role-based authentication for different types of users.

Supported roles include:

* Administrator
* Teacher
* Student
* Registrar Office

Authentication features include:

* Secure login
* Password hashing
* Password verification
* Session-based authentication
* Role-based access control
* Logout functionality
* Protected role-specific pages

---

## 👨‍💼 Administrator Module

The Administrator has access to the main management functions of the system.

Administrators can manage:

* Student accounts
* Teacher accounts
* Registrar Office accounts
* Classes
* Courses
* Subjects
* Rooms
* Sections
* Grades
* Class schedules
* System settings
* Messages and inquiries

The Administrator also has access to classroom and schedule information for monitoring and management.

---

## 👨‍🏫 Teacher Module

Teachers can access information related to their teaching responsibilities.

Features include:

* Teacher dashboard
* Teacher profile
* Assigned schedules
* Class information
* Student information
* Subject information
* Course information
* Room information
* Schedule viewing

---

## 👨‍🎓 Student Module

Students can access their academic and classroom-related information.

Features include:

* Student dashboard
* Student profile
* Class schedules
* Course information
* Subject information
* Room information
* Section information
* Academic information

---

## 🏫 Registrar Office Module

The Registrar Office module provides functionality for managing student-related academic records.

Features include:

* Student management
* Student registration
* Student search
* Student information viewing
* Academic information management
* Student record access

---

## 🏢 Classroom & Room Management

The system allows administrators to manage classrooms and other available rooms within the institution.

Features include:

* Add classrooms
* Edit classroom information
* Delete classrooms
* View registered rooms
* Manage classroom information
* Associate rooms with class schedules

---

## 🟢 Classroom Availability Monitoring

One of the important features of the system is **Classroom Availability Monitoring**.

The system uses classroom schedules to help authorized users determine whether a classroom is occupied or available.

Features include:

* View registered classrooms
* View classroom schedules
* Monitor scheduled classes
* Check classroom availability
* Identify occupied classrooms
* Identify available classrooms
* Check room availability based on schedules
* Help prevent classroom scheduling conflicts

This feature is intended to make it easier for administrators and authorized users to determine which classrooms are available without manually checking every classroom.

---

## 📅 Class Scheduling

The system provides classroom scheduling functionality.

Schedule information includes:

* Instructor
* Course
* Subject
* Room
* Section
* Year level
* Day
* Start time
* End time

The scheduling module helps organize classroom assignments and provides the information needed for classroom availability monitoring.

---

## 📚 Course & Subject Management

Administrators can manage academic course and subject information.

### Courses

Administrators can:

* Add courses
* Edit courses
* Delete courses
* View available courses

### Subjects

Administrators can:

* Add subjects
* Edit subjects
* Delete subjects
* View available subjects
* Manage subject codes

---

## 🎓 Grade & Academic Information Management

The system includes functionality for managing academic information such as:

* Grade levels
* Sections
* Student records
* Student scores
* Courses
* Subjects

This helps centralize academic information within the system.

---

## 📩 Contact & Messaging

The public website includes a contact form that allows users to send inquiries.

The system provides functionality for administrators to:

* View messages
* Monitor inquiries
* Mark messages as read
* Manage submitted messages

---

# 🛠️ Technologies Used

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap 5.3.3

## Backend

* PHP
* PDO
* MySQL / MariaDB

## Development Environment

* XAMPP
* Apache
* MySQL / MariaDB
* phpMyAdmin

## Version Control

* Git
* GitHub

---

# 📂 Project Structure

```text
CICTE-Classroom-Management/
│
├── admin/
│   ├── data/
│   ├── inc/
│   ├── req/
│   └── ...
│
├── RegistrarOffice/
│   ├── data/
│   ├── req/
│   └── ...
│
├── Student/
│   ├── data/
│   ├── inc/
│   ├── req/
│   └── ...
│
├── Teacher/
│   ├── data/
│   ├── inc/
│   ├── req/
│   └── ...
│
├── img/
│
├── req/
│   ├── DB_connection.php
│   ├── contact.php
│   └── login.php
│
├── index.php
├── home.php
├── login.php
├── logout.php
├── style.css
├── navbar-php.css
├── .gitignore
└── README.md
```

---

# 💻 Requirements

To run the project locally, you will need:

* Windows, Linux, or macOS
* XAMPP
* Apache
* MySQL / MariaDB
* PHP 8.2 or later
* Web browser
* Git

---

# 🚀 Installation

## 1. Install XAMPP

Install XAMPP with Apache, PHP, and MySQL/MariaDB.

Start the following services from the XAMPP Control Panel:

```text
Apache
MySQL
```

---

## 2. Clone the Repository

Clone the GitHub repository:

```bash
git clone https://github.com/JhosDev4/CICTE-Classroom-Management.git
```

Move the project into your XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\
```

The final project location should be:

```text
C:\xampp\htdocs\System_Project
```

---

## 3. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
sms_db
```

Import the database SQL file if a database backup is included with the project.

---

## 4. Configure the Database Connection

Open:

```text
req/DB_connection.php
```

The default local configuration is:

```php
$sName = "localhost";

$uName = "root";

$pass = "";

$db_name = "sms_db";
```

If your MySQL configuration is different, update the connection values accordingly.

---

## 5. Run the System

Open your browser and visit:

```text
http://localhost/System_Project/
```

The CICTE Classroom Management System homepage should now be displayed.

---

# 🔑 Authentication & Password Security

The system uses PHP's password hashing functionality to protect user passwords.

Passwords should be created using:

```php
password_hash()
```

and verified using:

```php
password_verify()
```

Example:

```php
if (password_verify($pass, $password)) {
    // Login successful
}
```

Passwords should **never be stored as plain text** in the database.

---

# 🔒 Security

The system currently implements several security mechanisms, including:

* Password hashing
* Password verification
* Session-based authentication
* Role-based access control
* Prepared SQL statements using PDO
* Protected role-specific pages
* Input validation
* Login authentication

> ⚠️ Because this project is still under development, additional security improvements and testing are planned before production deployment.

---

# 📊 Development Status

## Current Status

🚧 **ACTIVE DEVELOPMENT**

The system currently contains core modules for:

* User authentication
* Administrator management
* Teacher management
* Student management
* Registrar Office management
* Course management
* Subject management
* Room management
* Classroom management
* Section management
* Grade management
* Class scheduling
* Classroom availability monitoring
* Messaging and contact management
* System settings

However, the system is **not yet fully finished**.

Some features may still require:

* Additional testing
* Bug fixing
* UI improvements
* Security improvements
* Performance optimization
* Additional functionality

---

# 🗺️ Future Improvements

The following improvements may be added as development continues:

* [ ] Improve overall UI/UX
* [ ] Improve mobile responsiveness
* [ ] Improve classroom availability interface
* [ ] Add real-time classroom availability monitoring
* [ ] Add advanced schedule filtering
* [ ] Add schedule conflict detection
* [ ] Add more dashboard statistics
* [ ] Improve notification functionality
* [ ] Improve reporting features
* [ ] Improve student record management
* [ ] Improve teacher management
* [ ] Improve security
* [ ] Improve error handling
* [ ] Perform additional system testing
* [ ] Fix remaining bugs
* [ ] Optimize system performance
* [ ] Prepare the system for production deployment

---

# 🎯 Project Goals

The main goals of the CICTE Classroom Management System are to:

1. **Centralize academic information**
2. **Improve classroom management**
3. **Monitor classroom availability**
4. **Reduce classroom scheduling conflicts**
5. **Improve access to academic records**
6. **Reduce manual administrative processes**
7. **Provide role-based access to system resources**
8. **Improve the efficiency of classroom and academic operations**

---

# 👨‍💻 Developer

**Jhoshua Concepcion Laurito**

College of Information, Communication Technology and Engineering (CICTE)

---

# 📜 License

This project is currently intended for **educational and development purposes**.

License terms may be added or updated when the project reaches its final release.

---

# ⚠️ Disclaimer

This repository represents a project that is currently under active development.

The system is **not yet considered a fully completed or production-ready application**.

Features, database structures, user interfaces, and system functionality may change as development continues.

Additional testing, security improvements, bug fixes, and feature development are still required before the system can be considered production-ready.

---

# 🙏 Acknowledgment

This project was developed as an ongoing effort to provide a centralized classroom and academic management solution for the **College of Information, Communication Technology and Engineering (CICTE)**.

Thank you for visiting this project and following its development.

---

## ⭐ Project Status

**CICTE Classroom Management System**

> 🚧 **Still under development — more features, improvements, testing, and refinements are coming.**
