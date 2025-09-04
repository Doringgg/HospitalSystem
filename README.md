# 🏥 HospitalSystem

HospitalSystem is a **REST API** built with **PHP** following the **MVC architecture** and a **JWT Token** for autentication.  
It includes a simple **front-end** and integrates with a **MySQL database** to manage hospital data.

## 🚀 Features
- Manage **doctors** (CRUD operations).
- Manage **patients** (CRUD operations).
- Many-to-many relationship between doctors and patients (via a junction table).
- RESTful endpoints for data access.
- Basic front-end to interact with the API.
- Autentication with JWT Token.

## 🛠️ Technologies
- **PHP**
- **MySQL**
- **MVC architecture**
- **HTML / CSS / JavaScript** (front-end)
- **JWT TOKEN**

## 📂 Database Structure
- `doctors` – stores doctor information  
- `patients` – stores patient information  
- `doctor_patient` – junction table to represent many-to-many relationship  
