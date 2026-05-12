# Library Management System (Hybrid: Java Backend + PHP Frontend)

This project implements a Library Management System with a hybrid architecture:
- **Backend (75% Java Spring Boot)**: Provides RESTful APIs for managing books, members, and transactions. It handles all business logic and interacts directly with the MySQL database.
- **Frontend (25% PHP)**: A simple web interface that consumes the Java backend APIs to display data and allow user interactions.
- **Database (MySQL)**: Managed via XAMPP.

This setup allows for a robust backend while providing a simple, easy-to-deploy frontend on a standard XAMPP environment.

## Table of Contents
1.  [Prerequisites](#1-prerequisites)
2.  [Backend Setup (Java Spring Boot)](#2-backend-setup-java-spring-boot)
3.  [Database Setup (MySQL via XAMPP)](#3-database-setup-mysql-via-xampp)
4.  [Frontend Setup (PHP)](#4-frontend-setup-php)
5.  [Usage](#5-usage)

## 1. Prerequisites
Before you begin, ensure you have the following installed:
-   **XAMPP**: Includes Apache, MySQL, and PHP. Download from [Apache Friends](https://www.apachefriends.org/index.html).
-   **Java Development Kit (JDK)**: **Version 17 or higher** (required by Spring Boot 3.x). Download from [Oracle](https://www.oracle.com/java/technologies/downloads/) or [OpenJDK](https://openjdk.java.net/install/).
-   **Apache Maven**: For building the Java backend. Download from [Maven](https://maven.apache.org/download.cgi).
-   **A Code Editor/IDE**: Such as VS Code, IntelliJ IDEA, or Eclipse.

## 2. Backend Setup (Java Spring Boot)

1.  **Navigate to Backend Directory**:
    Open your terminal or command prompt and navigate to the `backend` directory of the project:
    ```bash
    cd /path/to/LibraryMS/backend
    ```
    (Replace `/path/to/LibraryMS` with the actual path where you extracted the project).

2.  **Build the Project**:
    Use Maven to build the Spring Boot application. This will compile the code and package it into a JAR file.
    ```bash
    mvn clean install
    ```

3.  **Run the Application**:
    After a successful build, you can run the application. The backend will start on `http://localhost:8080/api`.
    ```bash
    java -jar target/library-management-system-1.0.0.jar
    ```
    *(Note: The exact JAR file name might vary slightly based on the version in `pom.xml`.)*

    **Important**: Keep this terminal window open as long as you want the backend to be running.

## 3. Database Setup (MySQL via XAMPP)

1.  **Start XAMPP Control Panel**:
    Ensure that **Apache** and **MySQL** are running from your XAMPP Control Panel.

2.  **Access phpMyAdmin**:
    Open your web browser and go to `http://localhost/phpmyadmin`.

3.  **Create Database**:
    *   In phpMyAdmin, click on the "Databases" tab.
    *   Create a new database named `library_db`.

4.  **Import Schema and Sample Data**:
    *   Click on the `library_db` database you just created in the left sidebar.
    *   Go to the "SQL" tab.
    *   Open the `database.sql` file located in the `database` directory of your project (`/path/to/LibraryMS/database/database.sql`) with a text editor.
    *   Copy the entire content of `database.sql` and paste it into the SQL query box in phpMyAdmin.
    *   Click "Go" to execute the queries. This will create the necessary tables and insert sample data.

## 4. Frontend Setup (PHP)

1.  **Copy Frontend Files**:
    Copy the PHP files from the root of the `/path/to/LibraryMS/` directory (i.e., `config.php`, `index.php`, `books.php`, `members.php`, `transactions.php`, `login.php`, `logout.php`, `header.php`, `footer.php`, `style.css`) to your XAMPP `htdocs` folder inside a new subfolder named `libraryms`.
    Example path: `C:\xampp\htdocs\libraryms`

2.  **Verify Configuration**:
    Open `config.php` located in `C:\xampp\htdocs\libraryms\config.php`.
    Ensure `API_BASE_URL` is set correctly (default is `http://localhost:8080/api`). If your Java backend runs on a different port or context path, update this value.

3.  **Access the Frontend**:
    Open your web browser and go to `http://localhost/libraryms` (or whatever folder name you used in `htdocs`).

## 5. Usage

-   The PHP frontend will now communicate with the Java Spring Boot backend.
-   You can navigate through the dashboard, manage books, members, and transactions.
-   Ensure the Java backend is always running before accessing the PHP frontend.

Enjoy your Library Management System!

---

## 6. Desktop Application Mode (Windows)

You can run LibraryMS as a dedicated desktop application window without the browser address bar and tabs.

### How to use:
1.  **Ensure XAMPP is running** (Apache & MySQL).
2.  **Build the backend** once (if you haven't already):
    ```bash
    cd backend
    mvn clean install
    ```
3.  **Launch the App**:
    *   Navigate to the `desktop_launcher` folder.
    *   Double-click **`launch_silent.vbs`**.
    *   This will start the Java backend in the background and open the Library Management System in a dedicated window.

### Creating a Desktop Shortcut:
1.  Right-click on **`launch_silent.vbs`** in the `desktop_launcher` folder.
2.  Select **Send to** > **Desktop (create shortcut)**.
3.  Go to your desktop, right-click the new shortcut > **Properties**.
4.  Click **Change Icon...** and browse to a library-related icon if you have one.
5.  Rename the shortcut to **"Library Management System"**.

### Stopping the App:
*   Double-click **`stop_app.bat`** in the `desktop_launcher` folder to shut down the background Java process.
