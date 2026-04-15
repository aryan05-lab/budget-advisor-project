# 💰 BudgetPro – Personal Finance Management System

## 📌 Project Overview

BudgetPro is a web-based personal finance management system developed using PHP and MySQL. The main objective of this project is to help users track their daily expenses, manage financial data, and analyze their spending habits in a simple and organized way.

In real life, many individuals struggle to keep track of their expenses, which leads to poor financial planning. This system solves that problem by providing a centralized platform where users can add, view, and delete their expenses easily through a clean and user-friendly interface.

---

## 🏗️ System Architecture / Design

The system follows a three-tier architecture consisting of:

- **Frontend (Presentation Layer):**  
  Built using HTML and CSS. Responsible for displaying the user interface and taking input from users.

- **Backend (Application Layer):**  
  Developed using PHP. Handles business logic, processes form data, and interacts with the database.

- **Database (Data Layer):**  
  Managed using MySQL. Stores user data and expense records in structured tables.

### 🔁 Data Flow:

User Input → HTML Form → PHP Processing → SQL Query → MySQL Database  
→ Data Retrieved → PHP → Display on UI

---

## 📂 Modules Description

### 1. User Authentication Module
Handles user registration and login functionality. Stores user credentials in the database and uses session management to maintain login state.

### 2. Dashboard Module
Acts as the main interface of the system. Displays total expenses, number of transactions, and recent expense records.

### 3. Expense Management Module
Allows users to:
- Add expenses (amount, category, date)
- View expenses
- Delete expenses

### 4. Navigation Module
Provides smooth navigation between pages using a reusable navbar across the application.

### 5. Informational Pages
Includes pages like “How It Works”, “Resources”, and “Advisor” to enhance user experience and completeness.

---

## ⚙️ APIs Used

No external APIs are used in this project.  
All functionalities are implemented using PHP and MySQL.

---

## ⚠️ Challenges Faced

- Maintaining consistent UI design across multiple pages  
- Connecting frontend forms with backend PHP scripts  
- Managing user sessions for authentication  
- Debugging SQL queries and database errors  
- Handling multi-page navigation efficiently  

---

## 👨‍💻 Team Contributions

(Dhruva Pimpale roll no.-451), (Vaishnavi Patil roll no.-450)- Designed and developed frontend using HTML and CSS  
(Aryan Rakesh roll no.-453)- Implemented backend logic using PHP  
(Aryan Rakesh roll no.-453)- Designed and managed MySQL database  
(Dhruva Pimpale roll no.-451)- Integrated frontend with backend  
(Vaishnavi Patil roll no.-450)- Tested and debugged the application  

---

## 📸 Screenshots

### 🏠 Home Page
<img width="1920" height="1008" alt="Screenshot 2026-04-15 044343" src="https://github.com/user-attachments/assets/3f33e543-6828-4dc9-b7c7-b7518d442606" />


### 🔐 Login Page
<img width="1920" height="1008" alt="Screenshot 2026-04-15 044418" src="https://github.com/user-attachments/assets/9dbb7156-4b3c-41eb-aa9c-58651a2580ed" />


### 📊 Dashboard
<img width="1920" height="1008" alt="Screenshot 2026-04-15 044445" src="https://github.com/user-attachments/assets/8d2471ad-4223-4d6c-87c8-ee0e4d2bda6e" />


### ➕ Add Expense Page
<img width="1920" height="1008" alt="Screenshot 2026-04-15 044455" src="https://github.com/user-attachments/assets/f1521cf6-ca24-412d-beed-be628158a51c" />



---

## 🚀 How to Run the Project

1. Install XAMPP  
2. Place the project folder inside `htdocs/`  
3. Start Apache and MySQL  
4. Open phpMyAdmin and create a database named `budget_app`  
5. Import tables or create them manually  
6. Run the project in browser:

http://localhost/budget_app/

---

## 💡 Future Improvements

- Edit/Update expense feature  
- Graphical data visualization (charts)  
- Mobile responsive design  
- User-specific dashboards  
- Deployment on cloud server  

---

## 📜 Conclusion

BudgetPro is a complete web-based application that demonstrates full-stack development using PHP and MySQL. It provides a simple and effective solution for managing personal finances. The system integrates frontend design, backend logic, and database management to create a functional and user-friendly application.

---
(Dhruva Pimpale roll no.-451)
(Vaishnavi Patil roll no.-450)
(Aryan Rakesh roll no.-453)
