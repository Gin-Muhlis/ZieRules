# Zie Rules

**Zie Rules** is a comprehensive admin panel designed to manage and monitor school data for SMK Negeri 1 Cianjur. Built with **Laravel 10** and **PHP 8+**, Zie Rules offers robust functionality for school administration and parent engagement, while also providing a REST API for student management applications.

## Features

### Admin Panel
1. **Student Management**  
   Easily manage student data, including enrollment, performance, and behavior records.
   
2. **Teacher Management**  
   Handle teacher information and monitor their performance.
   
3. **Violation Management**  
   Keep track of student violations and generate reports to ensure proper monitoring.
   
4. **Achievement Management**  
   Record and track student achievements in both academic and non-academic areas.
   
5. **Attendance Management**  
   Manage daily student attendance, generate attendance reports, and track attendance behavior.

6. **Attendance and Behavior Reports**  
   Generate detailed reports on student attendance and behavioral trends.

7. **Multi-User and Role-Based Access**  
   Support for multiple user types, including administrators, teachers, and parents, with role-based access control to ensure data security and proper access levels.

### Parent Portal
Zie Rules also provides a dedicated portal for parents to monitor their child's:
- **Attendance**  
- **Violations**  
- **Achievements**  

Parents can access up-to-date information about their children’s school activities, allowing for better engagement and support.

### REST API
Zie Rules includes a powerful **REST API** that can be used to integrate student management functionality into other applications. This API allows external systems to access and manipulate data related to:
- Student records
- Attendance
- Violations
- Achievements
- Teacher data

## Requirements

- **PHP 8.0+**
- **Laravel 10**
- **MySQL or PostgreSQL Database**

## Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/Gin-Muhlis/ZieRules.git

2. Masuk ke direktori project:
   ```bash 
   cd Juragan-Event

3. Install dependencies:
   ```bash 
   composer install

4. Atur file environment:
   ```bash
   - Duplikat file .env.example menjadi .env.
   - Ubah detail konfigurasi di file .env sesuai dengan pengaturan database dan konfigurasi lainnya.

5. Jalankan migrasi database:
   ```bash 
   php artisan migrate --seed

6. Jalankan server development:
   ```bash 
   php artisan serve
