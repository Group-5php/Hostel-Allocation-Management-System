# Hostel Allocation Management System

## Objective
A PHP and MySQL-based web system that helps manage student hostel room allocation efficiently.  
It allows registration of students, allocation of available rooms based on capacity, transfer between rooms, and vacating rooms when students leave.

## Project Features
1. **Student Registration** – Register new students with their details.  
2. **Room Allocation** – Assign students to available rooms based on capacity.  
3. **Transfer Room** – Move a student from one room to another automatically updating both rooms’ statuses.  
4. **Vacate Room** – Remove a student from a room and free up that room for new allocations.  
5. **Reports** – View current room allocations and statuses.  

## Database Design
**Database Name:** `hostel_allocation_management`

### Tables Used

#### students
| Column | Type | Description |
|--------|------|-------------|
| matric_no | VARCHAR(50) | Primary key, unique student ID |
| name | VARCHAR(100) | Student full name |
| department | VARCHAR(100) | Student department |
| gender | VARCHAR(20) | Male/Female |

#### rooms
| Column | Type | Description |
|--------|------|-------------|
| room_num | VARCHAR(50) | Primary key, room identifier (e.g. A1, B2) |
| capacity | INT | Maximum number of students allowed |
| status | TINYINT(1) | 1 = available, 0 = occupied |

#### allocations
| Column | Type | Description |
|--------|------|-------------|
| id | INT (AUTO_INCREMENT) | Primary key |
| matric_no | VARCHAR(50) | Student identifier (foreign key) |
| room_num | VARCHAR(50) | Allocated room (foreign key) |
| date_allocated | DATE | Date of allocation |
| allocation_status | VARCHAR(20) | active or inactive |

## Main Project Files

| File Name | Description |
|------------|-------------|
| `index.php` | Homepage with navigation buttons to all system functions |
| `db_connect.php` | Database connection file (MySQL connection setup) |
| `register.php` | Form for registering new students |
| `allocate.php` | Logic for assigning students to rooms with capacity checks |
| `transfer.php` | Allows students to move between rooms, updates status automatically |
| `vacate.php` | Frees up a student’s room and updates availability |
| `report.php` | Displays all allocations in a report format |
| `style.css` | Contains all design and styling rules for UI |

## How It Works

### Step 1: Register Students
Go to `register.php`, fill in the form, and submit.  
The student is saved in the **students** table.

### Step 2: Add Rooms
In phpMyAdmin, run this SQL (or insert manually):
```sql
INSERT INTO rooms (room_num, capacity, status) VALUES
('A1', 2, 1),
('A2', 2, 1),
('B1', 6, 1);
```

### Step 3: Allocate Room
Open `allocate.php`, select a student and room, then click **Allocate**.  
- The system checks if the room is full.  
- If not, the allocation is saved.  
- Once full, the room’s status becomes **occupied (0)**.

### Step 4: Transfer Room
Open `transfer.php`, select a student and a new room, then click **Transfer**.  
- The student’s current allocation updates.  
- The old room becomes available if not full anymore.  
- The new room becomes occupied if it reaches capacity.

### Step 5: Vacate Room
It will mark the student’s room as available again.

## Database Connection Setup

In `db_connect.php`:
```php
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "hostel_allocation_management";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

**For MAMP users (MacBook):**
- Host: `localhost`
- Port: `8889`
- Username: `root`
- Password: `root`

## UI Styling (style.css)
All forms are centered with green buttons and simple styling for clarity:
- `.form-container` → wraps each form neatly.  
- `button` → green background, white text.  
- `select` and `input` → styled with padding and border radius.  

## Grading Criteria Covered
- Functionality (40%) – All features work correctly with DB integration.  
- Code Quality (25%) – Clean, readable PHP with modular functions.  
- User Interface (15%) – Neat and responsive HTML/CSS.  
- Documentation (10%) – Detailed README with setup guide.  
- Collaboration (10%) – Clear roles and logical project flow.

## Team Role Distribution
| Role | Team Members | Responsibilities |
|------|---------------|------------------|
| Project Lead | Sodolamu Ayomide | Oversees workflow, testing, and presentation |
| Backend Developers | Sodolamu Ayomide, Onyeji Johnpaul, Sobowale Joshua | Handle PHP logic and MySQL queries |
| Frontend Developers | Olaiya Toni, Onilede Boluwatife | Design HTML/CSS forms and UI |
| Database Designer | Onyeji Johnpaul | Create tables and relationships |
| QA Tester | Sherif Yusuf | Test every page and feature |
| Documentation Lead | Chukwu Great | Write README and explain setup |
| Integration Lead | Ogunlana Satar | Ensure all PHP pages link and work together |

## How to Run
1. Copy your project folder (`hostel_allocation`) to MAMP’s `htdocs` directory.  
2. Start MAMP → launch Apache and MySQL.  
3. Go to phpMyAdmin → create database `hostel_allocation_management`.  
4. Import or create tables (`students`, `rooms`, `allocations`).  
5. Open browser → [http://localhost:8888/hostel_allocation/](http://localhost:8888/hostel_allocation/)

## Expected Output
- Students can register.  
- Rooms appear dynamically.  
- Allocations respect capacity.  
- Transfers and updates reflect instantly in database.  
- Interface is clean, clear, and easy to use.
