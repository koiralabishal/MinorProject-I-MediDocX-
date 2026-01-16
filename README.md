# MediDocX - Healthcare Management Solution

MediDocX is a comprehensive healthcare management platform designed to streamline coordination between patients, doctors, lab technicians, receptionists, and administrators. 

## 🚀 Features

- **Multi-Role Dashboards**: Specialized interfaces for Patients, Doctors, Lab Technicians, Receptionists, and Admins.
- **Appointment Management**: Seamless scheduling and tracking of patient visits.
- **Electronic Medical Records (EMR)**: Secure storage and management of patient history and visit details.
- **Laboratory Integration**: Request, track, and report laboratory tests efficiently.
- **Prescription Interface**: Digital prescription management and history.
- **Universal Connection**: Environment-aware database connection (works on Localhost & InfinityFree).
- **Email Verification**: Secure OTP-based authentication using PHPMailer.

## 🛠️ Technology Stack

- **Lanuage**: PHP
- **Database**: MySQL (MariaDB)
- **Styling**: Vanilla CSS (Modern, Responsive Design)
- **Libraries**: PHPMailer (Email/OTP), SweetAlert (Notifications)

## 📂 Project Structure

- `dashboards/`: Contains role-specific dashboard logic (Admin, Doctor, Lab, etc.).
- `auth/`: Login and Signup forms/logic.
- `config/`: Configuration files for database environment and connection.
- `assets/`: 
    - `css/`: Styling files.
    - `img/`: Hero images and avatars.
    - `sql/`: Database schema (`medidocx.sql`).
- `PHPMailer/`: Email library.

## ⚙️ Installation & Setup

### Localhost (XAMPP/WAMP)
1. **Clone the project** into your `htdocs` directory.
2. **Database Setup**:
   - Open phpMyAdmin.
   - Create a database named `medidocx`.
   - Import `assets/sql/medidocx.sql`.
3. **Configuration**:
   - The system auto-detects localhost, so no manual config is needed for the database.
   - Update `config/env.php` if you need to set up your own SMTP credentials for PHPMailer.
4. **Access**: Open `http://localhost/MinorProject-I-MediDocX-` in your browser.

### Remote (InfinityFree)
1. **Upload Files** to the `htdocs` or `public_html` folder via FTP.
2. **Database Setup**:
   - Create a MySQL database in your control panel.
   - Import `assets/sql/medidocx.sql` via phpMyAdmin.
3. **Update Environment**:
   - Open `config/env.php` and update the InfinityFree database credentials if they differ from the defaults.
4. **Access**: Visit your InfinityFree domain.

## 📸 Preview

![Hero Image](assets/img/2.jpg)

---
*MediDocX - Shaping the future of healthcare management.*
