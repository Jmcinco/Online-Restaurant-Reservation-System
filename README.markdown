# Online Restaurant Reservation System

This is an Online Restaurant Reservation System that allows users to make reservations at a restaurant through a web-based interface.

## Prerequisites

To use this system, you must have the following application installed:

- **XAMPP** (Any version)

## Installation Steps

1. **Download XAMPP**:
   - Visit the XAMPP website: [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Download the appropriate version for your operating system.

2. **Install XAMPP**:
   - Run the downloaded XAMPP installer and follow the on-screen instructions to complete the installation.

3. **Clone the Project**:
   - Clone this repository to your local machine using:
     ```bash
     git clone https://github.com/your-username/Online-Restaurant-Reservation-System.git
     ```

4. **Move Project to XAMPP Directory**:
   - Move the cloned project folder to the `htdocs` directory in your XAMPP installation. This is typically located at:
     ```
     C:\xampp\htdocs
     ```

5. **Import the Database**:
   - Open your web browser and navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Click on the **Import** tab in the phpMyAdmin interface.
   - Locate the SQL file in the `piggywings/server` directory of the project.
   - Select the SQL file and click **Go** to import the database.

   ![phpMyAdmin Import](https://github.com/user-attachments/assets/79e088da-1ffb-4473-a167-b88537de93f2)

6. **Run the Application**:
   - Ensure XAMPP is running (start the Apache and MySQL modules).
   - Open your browser and go to [http://localhost/Online-Restaurant-Reservation-System](http://localhost/Online-Restaurant-Reservation-System) to access the system.

## Troubleshooting

- Ensure that Apache and MySQL services are running in the XAMPP Control Panel.
- Verify that the project folder is correctly placed in the `htdocs` directory.
- Check that the SQL file is properly imported into phpMyAdmin.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.