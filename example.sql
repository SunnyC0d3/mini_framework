-- Create Customers table
CREATE TABLE Customers (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(20),
    RegistrationDate DATE,
    CONSTRAINT CHK_RegistrationDate CHECK (RegistrationDate <= CURRENT_DATE)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Orders table
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    INDEX IDX_OrderDate (OrderDate),
    INDEX IDX_TotalAmount (TotalAmount)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Authors table
CREATE TABLE Authors (
    AuthorID INT PRIMARY KEY,
    AuthorName VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Books table with a foreign key constraint and cascading delete
CREATE TABLE Books (
    BookID INT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    AuthorID INT,
    CONSTRAINT FK_Author FOREIGN KEY (AuthorID)
        REFERENCES Authors(AuthorID)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert fake data into the Customers table
INSERT INTO Customers (FirstName, LastName, Email, Phone, RegistrationDate)
VALUES
    ('John', 'Doe', 'johndoe@email.com', '555-123-4567', '2023-09-15'),
    ('Alice', 'Smith', 'alice@email.com', '555-987-6543', '2023-09-14'),
    ('Bob', 'Johnson', 'bob@email.com', '555-555-5555', '2023-09-13'),
    ('Eve', 'Williams', 'eve@email.com', '555-111-2222', '2023-09-12'),
    ('Charlie', 'Brown', 'charlie@email.com', '555-333-4444', '2023-09-11');

-- Insert fake data into the Orders table
INSERT INTO Orders (CustomerID, OrderDate, TotalAmount)
VALUES
    (1, '2023-09-15 08:30:00', 100.50),
    (2, '2023-09-14 12:15:00', 75.25),
    (3, '2023-09-13 16:45:00', 220.00),
    (4, '2023-09-12 10:00:00', 45.75),
    (5, '2023-09-11 14:20:00', 300.99);

-- Insert fake data into the Authors table
INSERT INTO Authors (AuthorID, AuthorName)
VALUES
    (1, 'John Smith'),
    (2, 'Alice Johnson'),
    (3, 'Bob Brown'),
    (4, 'Eve Williams'),
    (5, 'Charlie Davis');

-- Insert fake data into the Books table
INSERT INTO Books (BookID, Title, AuthorID)
VALUES
    (101, 'The Great Novel', 1),      -- John Smith
    (102, 'Mystery Thriller', 2),     -- Alice Johnson
    (103, 'Adventure Quest', 3),      -- Bob Brown
    (104, 'Sci-Fi Odyssey', 1),       -- John Smith
    (105, 'Romantic Dreams', 4);      -- Eve Williams