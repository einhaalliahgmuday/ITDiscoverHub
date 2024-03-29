<?php
session_start();
include('../php_servers/admin_db_configuration.php');


if (!isset($_SESSION['admin_username'])) {
    header('location: admin.php');
    exit();
}

//execution for adding device and stored to database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_device'])) {
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $os = mysqli_real_escape_string($conn, $_POST['os']);
    $processor = mysqli_real_escape_string($conn, $_POST['processor']);
    $ram = mysqli_real_escape_string($conn, $_POST['ram']);
    $storage = mysqli_real_escape_string($conn, $_POST['storage']);
    $releaseDate = mysqli_real_escape_string($conn, $_POST['releaseDate']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "INSERT INTO tblLaptop (brand, model, os, processor, ram, storage, releaseDate, price) VALUES ('$brand', '$model', '$os', '$processor', '$ram', '$storage', '$releaseDate', '$price')";

    if ($conn->query($sql) === TRUE) {
        header('Location: adminLaptop.php');
        exit();
    } else {
        $conn->error;
    }
}

// execution for deleting device
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_device'])) {
    $brandDelete = mysqli_real_escape_string($conn, $_POST['brandToDelete']);
    $modelDelete = mysqli_real_escape_string($conn, $_POST['modelToDelete']);

    $sql = "DELETE FROM tblLaptop WHERE brand = '$brandDelete' AND model = '$modelDelete'";

    if ($conn->query($sql) === TRUE) {
        header('Location: adminLaptop.php');
        exit();
    } else {
        $conn->error;
    }
}


//check for existing laptop in database
$result = $conn->query("SELECT brand,model FROM tblLaptop");

if ($result->num_rows > 0) {
    $laptops = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $laptops = [];
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laptop | IT Discover Hub</title>
    <link rel="stylesheet" href="../css/adminLaptop.css" />
    <link rel="stylesheet" href=https://fonts.googleapis.com/css?family=Poppins:300,400,500,700 />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <img class="website-logo" src="../images/IDH-logo-1.png" alt="Logo of ITDiscoverHub" />

        <nav class="header-nav">
            <ul>
                <li>
                    <div class="sign-in"><a href="admin-logout.php">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span class="hidden-text">Log out</span>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="navigation">
            <div class="admin-name">
                <h3>Admin</h3>
                <p id="adminName">
                    <?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : ''; ?>
                </p>
            </div>
            <div class="nav">
                <h2><i class="fa-solid fa-circle-info"></i>General Details</h2>
                <a href="adminHome.php"><i class="fa-solid fa-gauge"></i>Dashboard</a>
                <a href="adminLaptop.php"><i class="fa-solid fa-laptop"></i>Laptop</a><br>
                <a href="adminSmartphone.php"><i class="fa-solid fa-mobile"></i>SmartPhone</a><br>
                <a href="adminTablet.php"><i class="fa-solid fa-tablet"></i>Tablet</a><br>
            </div>
        </div>
        <div class="dashboard">
            <div class="add-device">
                <button id="addDevice">Add Device</button>
            </div>
            <div class="container-device">
                <table>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    foreach ($laptops as $laptop) : ?>
                        <tr>
                            <td><?php echo $laptop['brand']; ?></td>
                            <td><?php echo $laptop['model']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="brandToDelete" value="<?php echo $laptop['brand']; ?>">
                                    <input type="hidden" name="modelToDelete" value="<?php echo $laptop['model']; ?>">
                                    <button type="submit" name="delete_device">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <!-- hidden modals -->
            <div class="overlay" id="overlay">
                <div class="modal">
                    <h2>Add Device</h2>
                    <form method="post" action="">
                        <label for="brand">Brand:</label>
                        <select name="brand" id="brand">
                            <option value="dell">Dell</option>
                            <option value="samsung">Samsung</option>
                            <option value="hp">HP</option>
                        </select>
                        <label for="model">Model:</label>
                        <input type="text" name="model" required><br>
                        <label for="os">OS:</label>
                        <select name="os" id="os">
                            <option value="windows">Windows</option>
                            <option value="macOS">macOS</option>
                        </select>
                        <label for="processor">Processor:</label>
                        <input type="text" name="processor" required><br>
                        <label for="ram">RAM:</label>
                        <input type="number" name="ram" required><br>
                        <label for="storage">Storage:</label>
                        <input type="number" name="storage" required><br>
                        <label for="releaseDate">Release Date (YYYY-MM-DD):</label>
                        <input type="text" name="releaseDate" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD" required><br>
                        <label for="price">Price:</label>
                        <input type="number" name="price" required><br>
                        <input type="submit" name="add_device" value="Add Device">
                    </form>
                    <button onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    function openModal() {
        const panel = document.getElementById('overlay');
        panel.style.display = 'flex';
    }

    function closeModal() {
        const panel = document.getElementById('overlay');
        panel.style.display = 'none';
    }

    document.getElementById('addDevice').addEventListener('click', function() {
        openModal();
    });
</script>

</html>