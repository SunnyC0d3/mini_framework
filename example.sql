-- Create Customers table
CREATE TABLE Customers (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(20),
    RegistrationDate DATE,
    CONSTRAINT CHK_RegistrationDate CHECK (RegistrationDate <= CURRENT_DATE)
) ENGINE=InnoDB;

-- Create Orders table
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    INDEX IDX_OrderDate (OrderDate),
    INDEX IDX_TotalAmount (TotalAmount)
) ENGINE=InnoDB;

-- Create Authors table
CREATE TABLE Authors (
    AuthorID INT PRIMARY KEY,
    AuthorName VARCHAR(100) NOT NULL
);

-- Create Books table with a foreign key constraint and cascading delete
CREATE TABLE Books (
    BookID INT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    AuthorID INT,
    CONSTRAINT FK_Author FOREIGN KEY (AuthorID)
        REFERENCES Authors(AuthorID)
        ON DELETE CASCADE
);