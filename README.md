# single-image-upload-from-database


**Technologies Used**
* HTML5
* CSS3
* PHP
* MySQL
* Bootstrap 5

**Folder Structure**

/project-folder
 * uploads/               # Stores uploaded images
 * config.php             # Database connection
 * upload.php             # Upload image + description form
 * view.php               # Displays uploaded image + description
 * edit.php               # Edit image and description
 * delete.php             # Delete image & DB record
 * README.md              # Project documentation

**Database Setup**
1. Create Database:
   CREATE DATABASE single_image_db;
2. Create Table:
   USE single_image_db;

CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


