# SE-Lab Current Bill Management System

## Overview
The Current Bill Management System is a web-based application designed to manage electricity bills efficiently. It provides role-based access for admins, supervisors, and users to handle tasks such as bill generation, meter readings, and payments.

## Features
### Admin
- Register and manage supervisors and users.
- View and manage bills and meter readings.
- Access the admin dashboard.

### Supervisor
- Manage meter readings and generate bills.
- Oversee user-related data.
- Access the supervisor dashboard.

### User
- View and pay electricity bills.
- Access the user dashboard to view bill history.

## Technologies Used
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL

## Project Structure
```
current_bill_system.sql
admin/
    admin_dashboard.css
    admin_dashboard.php
    admin_reg.php
    reg_form.css
    supervisor_reg.php
    user_reg.php
connection/
    connect.php
    logout.php
home/
    form.css
    login.php
    start.css
    start.php
supervisor/
    bill.css
    bill.php
    read.css
    readings.php
    supervisor_dashboard.css
    supervisor_dashboard.php
users/
    pay_bill.php
    user_bills_data.css
    user_bills_data.php
    user_dashboard.css
    user_dashboard.php
```

## Database Schema
The database consists of the following tables:
- `admin`: Stores admin details.
- `admins`: Stores additional admin details.
- `bill`: Stores bill details including meter ID, units, amount, due date, and status.
- `login_details`: Manages login credentials for users.
- `meter`: Stores meter details linked to users.
- `meter_reading`: Stores meter readings linked to meters.
- `supervisor_admin_logins`: Manages login credentials for supervisors and admins.
- `supervisors`: Stores supervisor details.
- `user`: Stores user details.

## Installation
1. Clone the repository to your local machine.
2. Import the `current_bill_system.sql` file into your MySQL database.
3. Update the database connection details in `connection/connect.php`.
4. Start a local server (e.g., XAMPP) and navigate to the project directory.
5. Access the application via `http://localhost/SE/current_bills_sys/home/start.php`.

## Usage
1. **Admin Login**: Use the admin credentials to manage supervisors, users, and bills.
2. **Supervisor Login**: Use the supervisor credentials to manage meter readings and bills.
3. **User Login**: Use the user credentials to view and pay bills.

## License
This project is licensed under the MIT License.
