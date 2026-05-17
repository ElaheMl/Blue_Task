# BlueTask 💙

BlueTask is a modern full-stack task management app built with Vue.js, PHP, and MySQL.

## Features

* Create tasks
* Read tasks from database
* Update task completion status
* Delete tasks
* Modern responsive UI
* Real-time frontend/backend communication

---

## Tech Stack

### Frontend

* Vue.js
* Vite

### Backend

* PHP
* REST-like API

### Database

* MySQL

---

## Project Structure

```bash
blue-task/
│
├── frontend/
│   └── Vue application
│
├── backend/
│   ├── api/
│   ├── config/
│   └── database connection
```

---

## Setup

### 1. Clone the repository

```bash
git clone <your-repo-url>
```

---

### 2. Frontend setup

```bash
cd frontend
npm install
npm run dev
```

---

### 3. Backend setup

Start WAMP/XAMPP and run:

```bash
cd backend
php -S localhost:8000
```

---

### 4. Database setup

Create a MySQL database named:

```bash
blue_task_db
```

Then run:

```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## API Endpoints

| Method | Endpoint             | Description        |
| ------ | -------------------- | ------------------ |
| GET    | /api/tasks.php       | Get all tasks      |
| POST   | /api/create_task.php | Create a task      |
| POST   | /api/update-task.php | Update task status |
| POST   | /api/delete_task.php | Delete a task      |

---

## Author

Built with ❤️ using Vue, PHP, and MySQL.
