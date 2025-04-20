# Library Management System

This is a web-based Library Management System designed to manage books, users, and transactions efficiently. The system allows users to search, view, borrow, and return books, while administrators and librarians can manage users and books.

## Features

- **User Management**: Register, login, and manage user roles (Admin, Librarian, Member, User).
- **Book Management**: Add, edit, delete, view, and search books.
- **Transaction Management**: Borrow and return books with due date tracking.
- **Role-Based Access**: Different dashboards and functionalities based on user roles.

## Project Structure

- **books/**: Contains scripts for managing books, including adding, editing, viewing, and searching books.
  - [manage_books.php](file:///C:/xampp1/htdocs/library-management/books/manage_books.php): Script for managing book records.
  - [search_books.php](file:///C:/xampp1/htdocs/library-management/books/search_books.php): Script for searching books by title or author.
  - [view_books.php](file:///C:/xampp1/htdocs/library-management/books/view_books.php): Script for viewing all books.

- **users/**: Contains scripts for managing users.
  - [manage_users.php](file:///C:/xampp1/htdocs/library-management/users/manage_users.php): Script for adding, editing, and deleting users.
  - [view_users.php](file:///C:/xampp1/htdocs/library-management/users/view_users.php): Script for viewing all users.

- **transactions/**: Contains scripts for handling book transactions.
  - [borrow_book.php](file:///C:/xampp1/htdocs/library-management/transactions/borrow_book.php): Script for borrowing books.
  - [return_book.php](file:///C:/xampp1/htdocs/library-management/transactions/return_book.php): Script for returning books.

- **CSS Files**: Stylesheets for different pages.
  - [manage_books.css](file:///C:/xampp1/htdocs/library-management/books/manage_books.css)
  - [search_books.css](file:///C:/xampp1/htdocs/library-management/books/search_books.css)
  - [view.css](file:///C:/xampp1/htdocs/library-management/books/view.css)
  - [dashboard.css](file:///C:/xampp1/htdocs/library-management/dashboard.css)
  - [styles.css](file:///C:/xampp1/htdocs/library-management/styles.css)

- **Database Connection**: 
  - [db.php](file:///C:/xampp1/htdocs/library-management/db.php): Contains the database connection setup using MySQLi and PDO.

- **Authentication**:
  - [login.php](file:///C:/xampp1/htdocs/library-management/login.php): User login script.
  - [register.php](file:///C:/xampp1/htdocs/library-management/register.php): User registration script.
  - [logout.php](file:///C:/xampp1/htdocs/library-management/logout.php): User logout script.

## Installation

1. Clone the repository to your local machine.
2. Set up a MySQL database and import the provided SQL file to create the necessary tables.
3. Update the database connection details in [db.php](file:///C:/xampp1/htdocs/library-management/db.php).
4. Start your local server (e.g., XAMPP) and navigate to the project directory.

## Usage

- Access the application through the `index.php` file.
- Register as a new user or log in with existing credentials.
- Navigate through the dashboard based on your user role to manage books and users.

## License

This project is licensed under the MIT License.

## Acknowledgments

- Thanks to all contributors and open-source libraries used in this project.

