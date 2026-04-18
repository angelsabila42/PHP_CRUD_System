#  Student Management System (PHP + MySQL)

##  Project Overview

This project is a **database-driven web application** built using **pure PHP and MySQL (PDO)**.
It allows users to manage student records through a simple interface that supports full **CRUD operations (Create, Read, Update, Delete)**.

The system demonstrates the use of **Object-Oriented PHP**, **secure database interaction**, and **structured application design** without relying on any external frameworks.

---

##  Objectives

* Apply PHP fundamentals in a real-world scenario
* Implement full CRUD functionality
* Use PDO for secure database communication
* Apply Object-Oriented Programming (OOP) principles
* Handle form data with validation and basic security

---

##  Technologies Used

* **PHP (Core PHP)**
* **MySQL**
* **PDO (PHP Data Objects)**
* HTML (for forms and structure)
* CSS (basic styling)

---

##  Project Structure

```
/config
    database.php        # Database connection using PDO

/classes
    Student.php         # OOP class handling CRUD operations

/helpers
    validation.php      # Input validation and sanitization

/public
    index.php           # Display all student records
    create.php          # Add new student
    edit.php            # Update student details
    delete.php          # Delete student

/assets
    styles.css          # Basic styling
```

---

##  Features

###  Create

* Add new student records through a form

###  Read

* View all students in a dynamic table

###  Update

* Edit existing student details

###  Delete

* Remove student records safely

---

##  Security Features

* Prepared statements using PDO (prevents SQL Injection)
* Input validation (empty fields, proper formats)
* Output sanitization using `htmlspecialchars()`
* Prevention of duplicate submissions (POST-Redirect-GET pattern)

---

##  Application Flow

1. User submits form data
2. Data is validated and sanitized
3. Request is processed using PHP logic
4. Database is updated via PDO
5. User is redirected to avoid duplicate submissions
6. Updated data is displayed

---

##  Setup Instructions

### 1. Clone the Repository (from GitHub)

```
git clone <your-repo-link>
cd <project-folder>
```

---

### 2. Create Database

* Open MySQL
* Create a database (e.g., `student_db`)

### Example Table:

```
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL
);
```

---

### 3. Configure Database Connection

Edit:

```
/config/database.php
```

Add your:

* Host
* Database name
* Username
* Password

---

### 4. Run the Project

* Place project in your server directory (e.g., `htdocs` for XAMPP)
* Start Apache & MySQL
* Open in browser:

```
http://localhost/project-folder/public/
```

---

##  Team Contributions

| Member   | Role                                 |
| -------- | ------------------------------------ |
| Member 1 | Database & PDO                       |
| Member 2 | Create & Read Operations             |
| Member 3 | Update & Delete Operations           |
| Member 4 | Validation & Security                |
| Member 5 | Request Handling & Application Logic |

---

##  Key Concepts Demonstrated

* Object-Oriented Programming in PHP
* Secure database access using PDO
* HTTP request handling (GET vs POST)
* Separation of concerns
* Basic web application architecture

---

##  Limitations

* No authentication system
* Basic UI (focus is on backend logic)
* No external frameworks used

---

##  Future Improvements

* Add user authentication (login system)
* Improve UI/UX design
* Add search and filtering
* Implement pagination

---

##  License

This project is for educational purposes only.

