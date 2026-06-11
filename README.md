# Clinic Management System

**Group:** Aphrodite

**Course:** BIIT 2305 Web Application and Development - Section 02

## 👨‍💻 Team Members
| Name                                     | Matric No | Role                            |
|------------------------------------------|-----------|---------------------------------|
| Putri Aimi Batrisyia Binti Muhammad Yusri|  2320206  | Dashboard, Billing & Integration|
| Niesa Batrisyia Binti Nor Hisham         | 2419714   | Appointment & Queue             |
| Nurin Sofina Binti Yusdi                 | 2221372   | Patient Management              |
| Nurul Aida Fatini Binti Mohd Rosli       | 2410416   | Authentication & Security       |
| Nur Adawiyah Binti Zakaria               | 2417438   |  Prescriptions & Medications    |

---

## 🚀 Project Description
The clinic management system is a web-based solution to improve the efficiency and organisation of daily healthcare operations. The system helps healthcare institutions manage patient records, appointments, prescriptions, medication inventory, and billing through a more centralised digital platform. It also provides role-based access for administrators, doctors, nurses, and receptionists to ensure secure and efficient system management. This web application adheres to Shariah principles such as transparency and justice by ensuring accurate medical data.

## Project's Features
1. Dashboard Overview
2. User Roles & Security (Can only be accessed by Admins)
3. Patient Management
4. Appointment & Scheduling
5. Prescriptions & Medication
6. Billing & Payments (Can only be accessed by Admins and Receptionists)

## Technologies Used
- **Framework:** Laravel 12
- **Language:** PHP 8.2
- **Database:** MySQL
- **Frontend:** Blade Templating
- **Build Tool:** Vite
- **Version Control:** Github

## Roles and Permissions
|        Module      | Admin | Doctor | Nurse | Receptionist |
|--------------------|-------|--------|-------|--------------|
| Dashboard          |  ✅  |   ✅   |   ✅ |       ✅     |
| Patient Management |  ✅  |   ✅   |   ✅ |       ✅     |
| Appointments       |  ✅  |   ✅   |   ✅ |       ✅     |
| Prescriptions      |  ✅  |   ✅   |   ❌ |       ❌     |
| Billing & Invoices |  ✅  |   ❌   |   ❌ |       ✅     |
| User Management    |  ✅  |   ❌   |   ❌ |       ❌     |

---

## Setup and Installation

## Requirements
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Steps

1. Clone the repository
   ```bash
   git clone ...
```
   cd Aphrodite-Web-Clinic-Management-System
2. Install dependencies 
    --bash
   composer install
   npm install
3. Set up the environment
    --bash
   cp .env.example .env
   php artisan key: generate
4. Configure database open '.env' and set:
    DB_DATABASE=clinic_db
    DB_USERNAME=root
    DB_PASSWORD=
5. Run migrations
    --bash
   php artisan migrate
6. Start the Server
    --bash
   php artisan serve
   npm run dev
7. Visit 'http://127.0.0.1:8000'

---

## Screenshots

## ERD
<img width="1048" height="2171" alt="ERDWEBPROJECT drawio" src="https://github.com/user-attachments/assets/461cbab0-4cc6-43f4-b4e5-aedee6576029" />





  
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
