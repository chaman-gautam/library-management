-- If the table exists, drop it
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'librarian', 'member') NOT NULL
);

ALTER TABLE users
ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE users
ADD COLUMN role ENUM('admin', 'librarian', 'member') NOT NULL AFTER password;
UPDATE users SET role = 'librarian' WHERE username = 'existing_librarian_username';
UPDATE users SET role = 'member' WHERE username = 'existing_member_username';

-- Create the books table
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_year INT,
    available_copies INT DEFAULT 0
);

-- Create the transactions table
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    borrow_date DATETIME,
    return_date DATETIME,
    due_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Example to insert data into users
INSERT INTO users (username, password, role) VALUES ('admin', 'hashed_password', 'admin');
INSERT INTO users (username, password, role) VALUES ('librarian', 'hashed_password', 'librarian');
INSERT INTO users (username, password, role) VALUES ('member', 'hashed_password', 'member');