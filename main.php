<?php
session_start();

// Database Configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "data00";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
<?php

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$hospital_id = $_SESSION['hospital_id'];

// Fetch hospital details
$sql = "SELECT * FROM hospitals WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hospital_id);
$stmt->execute();
$result = $stmt->get_result();
$hospital = $result->fetch_assoc();
$stmt->close();
?>
<?php
// Save blood inventory data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bloodGroup']) && isset($_POST['quantity'])) {
    $bloodGroup = htmlspecialchars($_POST['bloodGroup']);
    $quantity = intval($_POST['quantity']);

    $sql = "INSERT INTO blood_inventory (hospital_id, blood_group, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $hospital_id, $bloodGroup, $quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Blood inventory updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating inventory!');</script>";
    }
    $stmt->close();
}
?>

<?php
// Save hospital details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hospitalName']) && isset($_POST['hospitalEmail']) && isset($_POST['hospitalLocation'])) {
    $hospitalName = htmlspecialchars($_POST['hospitalName']);
    $hospitalEmail = htmlspecialchars($_POST['hospitalEmail']);
    $hospitalLocation = htmlspecialchars($_POST['hospitalLocation']);

    $sql = "UPDATE hospitals SET name = ?, email = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $hospitalName, $hospitalEmail, $hospitalLocation, $hospital_id);

    if ($stmt->execute()) {
        echo "<script>alert('Hospital details updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating hospital details!');</script>";
    }
    $stmt->close();
}
?>

<?php
// Fetch blood inventory data
$data = [];
if (isset($_GET['fetchData'])) {
    $sql = "SELECT blood_group, SUM(quantity) AS quantity 
            FROM blood_inventory 
            WHERE hospital_id = ? 
            GROUP BY blood_group";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
    echo json_encode($data);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!-- Logout Button -->
        <button class="logout-btn" onclick="window.location.href='login.php'">Logout</button>

        <!-- Hospital Info Section -->
        <section class="user-info">
            <h1>Welcome, <?php echo htmlspecialchars($hospital['name']); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($hospital['email']); ?></p>
            <p>Location: <?php echo htmlspecialchars($hospital['location']); ?></p>
        </section>

        <!-- Hospital Details Entry Form -->
        <section class="hospital-details">
            <h2>Update Hospital Details</h2>
            <form method="POST">
                <label for="hospitalName">Hospital Name:</label>
                <input type="text" id="hospitalName" name="hospitalName" value="<?php echo htmlspecialchars($hospital['name']); ?>" required>

                <label for="hospitalEmail">Hospital Email:</label>
                <input type="email" id="hospitalEmail" name="hospitalEmail" value="<?php echo htmlspecialchars($hospital['email']); ?>" required>

                <label for="hospitalLocation">Location:</label>
                <input type="text" id="hospitalLocation" name="hospitalLocation" value="<?php echo htmlspecialchars($hospital['location']); ?>" required>

                <button type="submit">Save Details</button>
            </form>
        </section>

        <!-- Blood Inventory Section -->
        <section class="blood-group">
            <h2>Blood Inventory</h2>
            <form id="bloodForm" method="POST">
            <section class="blood-group">
    <h2>Blood Inventory</h2>
    <form id="bloodForm" method="POST">
        <label for="bloodGroup">Blood Group:</label>
        <select id="bloodGroup" name="bloodGroup" required>
            <option value="">Select Blood Group</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>
        
</section>

                
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
                
                <button type="submit">Save</button>
            </form>

            <h3>Statistics</h3>
            <canvas id="bloodChart"></canvas>
        </section>
    </div>

    <script>
        async function fetchBloodData() {
            const response = await fetch('?fetchData=1');
            const data = await response.json();

            const labels = data.map(item => item.blood_group);
            const quantities = data.map(item => item.quantity);

            const ctx = document.getElementById('bloodChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Blood Group Quantities',
                        data: quantities,
                        backgroundColor: 'rgba(106, 17, 203, 0.5)',
                        borderColor: 'rgba(106, 17, 203, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        fetchBloodData();
    </script>
</body>
<style>
:root {
    --blood-primary: #8B0000; /* Deep red for blood-related theme */
    --blood-secondary: #DC143C; /* Crimson accent */
    --blood-background: #F8F0F0; /* Light pale pink background */
    --blood-text-dark: #2C3E50; /* Dark text for contrast */
    --blood-white: #FFFFFF;
    --blood-shadow: rgba(139, 0, 0, 0.15);
}

body {
    font-family: 'Roboto', 'Arial', sans-serif;
    background-color: var(--blood-background);
    color: var(--blood-text-dark);
    line-height: 1.6;
}

.container {
    background-color: var(--blood-white);
    border-left: 6px solid var(--blood-primary);
    box-shadow: 0 4px 15px var(--blood-shadow);
    padding: 2rem;
    border-radius: 10px;
}

/* Buttons with blood-themed styling */
button {
    background-color: var(--blood-primary);
    color: var(--blood-white);
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-weight: 600;
    padding: 10px 20px; /* Added padding for better touch targets */
}

button:hover {
    background-color: var(--blood-secondary);
    transform: translateY(-3px) scale(1.05); /* Slight scaling on hover */
}

.logout-btn {
    background-color: #C0392B;
}

.logout-btn:hover {
    background-color: #A93226;
}

/* Form Styling */
form {
    background-color: #FFF5F5;
    border: 1px solid rgba(139, 0, 0, 0.1);
    border-radius: 8px;
    padding: 1.5rem;
}

/* Input and Select Styling */
input, select {
    border: 1px solid var(--blood-primary);
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Added box-shadow transition */
}

input:focus, select:focus {
    border-color: var(--blood-secondary);
    box-shadow: 0 0 8px rgba(220, 20, 60, 0.2); /* Enhanced focus effect */
}

/* Blood Inventory Section */
.blood-group {
    background-color: #FEF4F4;
    border-radius: 10px;
    padding: 1.5rem;
}

/* Chart Styling */
#bloodChart {
    background-color: var(--blood-white);
    border: 1px solid rgba(139, 0, 0, 0.1);
    border-radius: 10px;
    box-shadow: 0 4px 10px var(--blood-shadow);
}

/* User Info Section */
.user-info {
    background-color: #FFF0F0;
    border-left: 4px solid var(--blood-secondary);
    border-radius: 8px;
}

.user-info h1 {
    color: var(--blood-primary);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .container {
        padding: 1rem;
        margin-bottom: 20px; /* Added margin for spacing on small screens */
        border-radius: 5px; /* Reduced radius for smaller screens */
    }
}

/* Optional Blood Drop Cursor */
body {
   cursor:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 24 24" fill="%238B0000"><path d="M12 2.247c-4.777 5.445-8 8.753-8 12.8c0 4.632 3.52 7.953 8 7.953s8-3.321 8-7.953c0-4.047-3.223-7.355-8-12.8z"/></svg>'), auto; 
}

/* Scrollbar Customization */
::-webkit-scrollbar {
   width: 8px;
}

::-webkit-scrollbar-track {
   background:#FFF0F0;
}

::-webkit-scrollbar-thumb {
   background-var(--blood-primary);
   border-radius:4px;
}
</style>