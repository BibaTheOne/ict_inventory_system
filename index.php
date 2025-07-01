<?php include 'security.php'; ?>
<?php include 'auth.php';
if (!is_logged_in() || (!is_ict() && !is_hod())) {
    header("Location: unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
                    <input type="text" id="searchUsers" placeholder="Search users..." class="search-bar" />
                    <button onclick="filterTable('searchUsers', 'usersTable', 'users')">Search</button>
                </div>
                <form id="addUserForm" method="POST" action="add_user.php">
                    <h3>Add User</h3>
                    <input type="text" name="username" placeholder="Username" required />
                    <input type="text" name="phone_number" placeholder="Phone Number" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <select name="building" id="building" required onchange="updateFloors()">
                        <option value="">Select Building</option>
                        <option value="Harambee Plaza">Harambee Plaza</option>
                        <option value="Ukulima Cooperative Sacco">Ukulima Cooperative Sacco</option>
                    </select>
                    <select name="floor" id="floor" required>
                        <option value="">Select Floor</option>
                    </select>
                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="ICT">ICT</option>
                        <option value="Finance">Finance</option>
                        <option value="HR">HR</option>
                        <option value="Procurement">Procurement</option>
                    </select>
                    <button type="submit" class="button">Add User</button>
                </form>
                <a href="export_users_excel.php" class="export-button" target="_blank">Export Users (.xlsx)</a>
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
                    <select id="filterType" onchange="filterEquipments()">
                        <option value="">All Types</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Printer">Printer</option>
                        <option value="Router">Router</option>
                        <option value="Desktop">Desktop</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Scanner">Scanner</option>
                    </select>
                    <select id="filterStatus" onchange="filterEquipments()">
                        <option value="">All Statuses</option>
                        <option value="Issued">Issued</option>
                        <option value="Returned">Returned</option>
                    </select>
                    <input type="text" id="searchEquipments" placeholder="Search equipments..." class="search-bar">
                    <button onclick="filterTable('searchEquipments', 'equipmentsTable')">Search</button>
                </div>
                <form id="addEquipmentForm" method="POST" action="add_equipment.php">
                    <h3>Add Equipment</h3>
                    <label for="equipment_type">Equipment Type</label>
                    <select name="equipment_type" id="equipment_type" required>
                        <option value="">-- Select Type --</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Printer">Printer</option>
                        <option value="Router">Router</option>
                        <option value="Desktop">Desktop</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Scanner">Scanner</option>
                    </select>
                    <input type="text" name="equipment_name" placeholder="Device Model (e.g., Dell Latitude 5420)" required />
                    <input type="text" name="serial_no" placeholder="Serial Number" required />
                    <input type="text" name="barcode_no" placeholder="Barcode Number" required />
                    <button type="submit" class="button">Add Equipment</button>
                </form>
                <a href="export_equipments_excel.php" class="export-button" target="_blank">Export Equipments (.xlsx)</a>
                <table id="equipmentsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Device Model</th>
                            <th>Serial No</th>
                            <th>Barcode No</th>
                            <th>Assigned To</th>
                            <th>Status</th>
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
                    <input type="text" id="searchAssignments" placeholder="Search assignments..." class="search-bar" />
                    <button onclick="filterTable('searchAssignments', 'assignmentsTable', 'assignments')">Search</button>
                </div>
                <form id="addAssignmentForm" method="POST" action="add_assignment.php" autocomplete="off">
                    <h3>Add Assignment</h3>
                    <input type="text" id="user_name" placeholder="Type user name..." required />
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="number" name="equipment_id" placeholder="Equipment ID" required />
                    <ul id="suggestions" class="autocomplete-suggestions"></ul>
                    <button type="submit" class="button">Add Assignment</button>
                </form>
                <a href="export_assignments_excel.php" class="export-button" target="_blank">Export Assignments (.xlsx)</a>
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