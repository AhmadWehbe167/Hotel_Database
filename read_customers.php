<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET Request; if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Limit Number of records to show on each page
// $records_per_page = 10;

$stmt = $pdo->prepare('SELECT C.ID, C.Name, C.Email, C.Address, C.PhoneNumber, I.Description, F.Type
                    FROM (customer C LEFT JOIN INVOICE I 
                    ON C.ID = I.CustomerID)
                    LEFT JOIN facilities F
                    ON C.ID = F.CustomerID');

$stmt->execute();

// Fetch the records so they can be displayed.
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT * FROM malecustomers');

$stmt2->execute();

// Fetch the records so they can be displayed.
$malecustomers = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $pdo->prepare('SELECT * FROM femalecustomers');

$stmt3->execute();

// Fetch the records so they can be displayed.
$femalecustomers = $stmt3->fetch(PDO::FETCH_ASSOC);
// Get the total number of customers
$num_customers = $pdo->query('SELECT COUNT(*) FROM customer')->fetchColumn();
?>

<?=template_header('Customers')?>

<div class="content read">
	<h2>Customers</h2>
	<a href="add-customer.php" class="add-customer">Add Customer</a>
	<table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Phone Number</td>
                <td>Facilities</td>
                <td>Status</td>

                <td></td>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $cust): ?>
            <tr>
                <td><?=$cust['ID']?></td>
                <td><?=$cust['Name']?></td>
                <td><?=$cust['Email']?></td>
                <td><?=$cust['Address']?></td>
                <td><?=$cust['PhoneNumber']?></td>
                <td><?=isset($cust['Type']) ? $cust['Type'] : "none" ?></td>
                <td><?=$cust['Description']?></td>

                <td class="actions">
                    <a href="update-customer.php?id=<?=$cust['ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete-customer.php?id=<?=$cust['ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Statistics</h2>
    <table>
        <thead>
            <tr>
                <td>Total Customers</td>
                <td>Male</td>
                <td>Female</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$num_customers?></td>
                <td><?=$malecustomers['Males']?></td>
                <td><?=$femalecustomers['Females']?></td>
            </tr>
        </tbody>
    </table>

</div>

<?=template_footer()?>