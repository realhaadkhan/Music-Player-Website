# Music Player Website

This website offers basic functionalities of Music Player System with some additional features like personal user library, audio visualizer for UI enhancement, songs statistic, etc.

## 📂 Features
- Basic implemetation of Music Player
- Personal User song Library
- Song Liking System
- Admin page (username: admin, password: admin123)
- Audio Visualizer

## 🛠️ Requirements
- XAMPP (or any other local server software with PHP, MySQL, and Apache)
- Browser (e.g., Google Chrome, Mozilla Firefox)
- Basic knowledge of PHPMyAdmin for database setup.

## 🚀 Installation and Setup Guide

### Clone or Download the Repository

- Clone the repository:
    ```bash
    git clone https://github.com/your-username/your-repository.git
    ```
- Or download the ZIP file:
    - Go to your GitHub repository.
    - Click **Code → Download ZIP**.
    - Extract the ZIP file.

### Move Project Files to XAMPP

- Copy the extracted project folder to the XAMPP htdocs directory:
    - Default path: `C:\xampp\htdocs\` (on Windows) or `/opt/lampp/htdocs/` (on Linux/Mac).

### Import the Database

- Open phpMyAdmin:
    - URL: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Create a new database:
    - Go to **Databases** → Enter a database name (e.g., `phpmicroproject`) → Click **Create**.
- Import the `.sql` file:
    - Select the newly created database.
    - Click **Import** → Choose the `.sql` file from the project directory → Click **Go**.

### Configure Database Connection (if necessary)

- Locate the database configuration file in your project i.e. dbConnect.php.
- Update the following values if needed:
    ```php
    $host = 'localhost';      // Database host
    $username = 'root';       // Database username (default: root)
    $password = '';           // Database password (default: empty)
    $dbname = 'phpmicroproject';   // Database name
    ```

### Run the Project

- Start the XAMPP server:
    - Open the XAMPP Control Panel.
    - Start **Apache** and **MySQL** services.
- Access the project in your browser:
    - URL: [http://localhost/your-project-folder](http://localhost/your-project-folder).

## 🧪 Testing the Application

- Use your browser to navigate to the project.
- Test the features as described in the documentation.

## 🤝 Contributing

- Fork the repository.
- Create your feature branch:
    ```bash
    git checkout -b feature-name
    ```
- Commit your changes:
    ```bash
    git commit -m "Add some feature"
    ```
- Push to the branch:
    ```bash
    git push origin feature-name
    ```
- Open a pull request.

## 📄 License

This project is licensed under the MIT License.

## 📞 Support

For issues, feel free to open an issue on GitHub or contact me at hkhan032004@gmail.com
