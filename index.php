<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <a href="logout.php" style="float:right; margin-right: 10px;">Logout</a>
            <h1>Inventory Management System</h1>
            <nav>
                <ul class="menu">
                    <li><a href="#users" class="active"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="#equipments"><i class="fas fa-tools"></i> Equipments</a></li>
                    <li><a href="#assignments"><i class="fas fa-clipboard-list"></i> Assignments</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <!-- USERS SECTION -->
            <section id="users" class="content">
                <h2>Users List</h2>
                <div class="search-container">
                    <input type="text" id="searchUsers" placeholder="Search users..." class="search-bar">
                    <button onclick="filterTable('searchUsers', 'usersTable', 'users')">Search</button>
                </div>
                <form id="addUserForm" method="POST" action="add_user.php">
                    <h3>Add User</h3>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="text" name="phone_number" placeholder="Phone Number" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="building" placeholder="Building" required>
                    <input type="text" name="floor" placeholder="Floor" required>
                    <input type="text" name="department" placeholder="Department" required>
                    <button type="submit">Add User</button>
                </form>
                <a href="export_users.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" class="cta-button" target="_blank">Export to CSV</a>
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'fetch_users.php'; ?>
                    </tbody>
                </table>
            </section>

            <!-- EQUIPMENTS SECTION -->
            <section id="equipments" class="content" style="display:none;">
                <h2>Equipments List</h2>
                <div class="search-container">
                    <input type="text" id="searchEquipments" placeholder="Search equipments..." class="search-bar">
                    <button onclick="filterTable('searchEquipments', 'equipmentsTable', 'equipments')">Search</button>
                </div>
                <form id="addEquipmentForm" method="POST" action="add_equipment.php">
                    <h3>Add Equipment</h3>
                    <input type="text" name="equipment_type" placeholder="Equipment Type" required>
                    <input type="text" name="equipment_name" placeholder="Equipment Name" required>
                    <input type="text" name="serial_no" placeholder="Serial Number" required>
                    <input type="text" name="barcode_no" placeholder="Barcode Number" required>
                    <button type="submit">Add Equipment</button>
                </form>
                <a href="export_equipments.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" class="cta-button" target="_blank">Export to CSV</a>
                <table id="equipmentsTable">
                    <thead>
                        <tr>
                            <th>Equipment ID</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Serial No</th>
                            <th>Barcode No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'fetch_equipments.php'; ?>
                    </tbody>
                </table>
            </section>

            <!-- ASSIGNMENTS SECTION -->
            <section id="assignments" class="content" style="display:none;">
                <h2>Assignments List</h2>
                <div class="search-container">
                    <input type="text" id="searchAssignments" placeholder="Search assignments..." class="search-bar">
                    <button onclick="filterTable('searchAssignments', 'assignmentsTable', 'assignments')">Search</button>
                </div>
                <form id="addAssignmentForm" method="POST" action="add_assignment.php">
                    <h3>Add Assignment</h3>
                    <input type="number" name="equipment_id" placeholder="Equipment ID" required>
                    <input type="number" name="user_id" placeholder="User ID" required>
                    <input type="date" name="date_issued" required>
                    <button type="submit">Add Assignment</button>
                </form>
                <a href="export_assignments.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" class="cta-button" target="_blank">Export to CSV</a>
                <table id="assignmentsTable">
                    <thead>
                        <tr>
                            <th>Assignment ID</th>
                            <th>Equipment ID</th>
                            <th>User ID</th>
                            <th>Date Issued</th>
                            <th>Return Status</th>
                            <th>Return Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'fetch_assignments.php'; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="scripts.js"></script>
</body>

</html>