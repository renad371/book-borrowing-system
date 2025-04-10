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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Book Borrowing System - Laravel

### Overview

This project is a Book Borrowing System developed using Laravel. It includes multiple features such as authentication, Blade components, AJAX functionality, data tables, PDF export, role and permission management, and morph relations for comments and ratings.

### Features and Implementation Details

1. **Authentication (Login & Registration)**

2. **Blade Components**
   - **alert**: Three distinct Blade components were created:
     - **Login and Register**: Used in the authentication section (resources/views/auth).
     - **Book Card**: Displays details of a book, such as title, author, and availability. Used in the book.blade.php view.
     - **Author Card**: Displays author details with a card layout, used in the author.blade.php view.
   - **Description**: Components were designed for reusable UI elements to ensure consistency and modularity across the project.

3. **AJAX Functionality**
   - **Where Implemented**:
     - **Borrowing Books**: Used AJAX to dynamically update the borrow status of books (book.blade.php).
     - **Editing and Updating Information**: Used AJAX for updating book and user information (Author-edit.blade.php, book-edit.blade.php).
     - **Evaluation**: AJAX is used to submit book ratings and feedback without reloading the page.
   - **Description**: AJAX was implemented to enhance user experience by dynamically updating the content without requiring a full page reload.

4. **Data Tables (AJAX)**
   - **Where Implemented**: Data tables are used to display lists of books, borrowings, and authors in different sections:
     - **Viewing Borrowings**: Data table for displaying borrow records in the admin panel (borrowings.index.blade.php).
     - **Books Management**: Data table for managing books and their details in the admin panel (books.index.blade.php).
     - **Authors Management**: Data table for viewing and managing author information in the admin panel (authors.index.blade.php).
   - **Description**: The data tables allow for sorting, searching, and pagination with dynamic data loading through AJAX.

5. **PDF Export**
   - **Where Implemented**: PDF export feature is implemented to export a list of books that the user has borrowed.
   - **Description**: This feature allows the user to export their borrowed books in PDF format using the Laravel DomPDF package. The export is triggered by clicking a button in the user’s profile or borrowings page.

6. **Role & Permission Management**
   - **Where Implemented**: Role and permission management is implemented using the Spatie/laravel-permission package.
   - **Description**: The system defines two primary roles:
     - **Admin**: Can add, edit, and delete books.
     - **User**: Books can be borrowed and authors and books can be evaluated.

7. **Morph Relations (Comments & Ratings)**
   - **Where Implemented**: The morph relation is used for comments and ratings, allowing users to comment or rate either a book or an author.
   - **Description**: This relationship makes it possible for users to dynamically comment on or rate books or authors. The comments and ratings are stored in a shared table with a morph relation linking to either the Book or Author models.

