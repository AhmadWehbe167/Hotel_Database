<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET Request; if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Limit Number of records to show on each page
// $records_per_page = 10;

$stmt = $pdo->prepare('SELECT * FROM STAFF');
$stmt->execute();

// Fetch the records so they can be displayed.
$Staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT Name, ID FROM StaffDayShift');
$stmt2->execute();

// Fetch the records so they can be displayed.
$StaffDayShift = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $pdo->prepare('SELECT Name, ID FROM StaffNIghtShift');
$stmt3->execute();

// Fetch the records so they can be displayed.
$StaffNIghtShift = $stmt3->fetch(PDO::FETCH_ASSOC);
// Get the total number of Staff
$num_Staff = $pdo->query('SELECT COUNT(*) FROM staff')->fetchColumn();
?>

<?=template_header('Staff')?>

<div class="content read">
    <h2>Staff</h2>
    <a href="add-staff.php" class="add-staff">Add staff</a>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Shift</td>
                <td>Phone Number</td>
                <td>Hotel Name</td>
                <td>Hotel Location</td>
                <td>Manager ID</td>
                <td></td>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($Staff as $Sta): ?>
            <tr>
                <td><?=$Sta['ID']?></td>
                <td><?=$Sta['Name']?></td>
                <td><?=$Sta['Shifts']?></td>
                <td><?=$Sta['PhoneNumber']?></td>
                <td><?=$Sta['Hotel_Name']?></td>
                <td><?=$Sta['Hotel_Location']?></td>
                <td><?=isset($Sta['ManagerID']) ? $Sta['ManagerID'] : "none" ?></td>

                <td class="actions">
                    <a href="update-staff.php?id=<?=$Sta['ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete-staff.php?id=<?=$Sta['ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Shifts</h2>
    <table>
        <thead>
            <tr>
                <td>Total Staff</td>
                <td>Day Shift</td>
                <td>Night Shift</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$num_Staff?></td>
                <td><?=$StaffDayShift['Day Shift']?></td>
                <td><?=$StaffNightShift['Night Shift']?></td>
            </tr>
        </tbody>
    </table>

</div>

<?=template_footer()?>

<?=template_header('Branches')?>

<div class="content read">
    <h2>Staff</h2>
    <a href="add-staff.php" class="add-staff">Add staff</a>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Shift</td>
                <td>Phone Number</td>
                <td>Hotel Name</td>
                <td>Hotel Location</td>
                <td>Manager ID</td>
                <td></td>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($Staff as $Sta): ?>
            <tr>
                <td><?=$Sta['ID']?></td>
                <td><?=$Sta['Name']?></td>
                <td><?=$Sta['Shifts']?></td>
                <td><?=$Sta['PhoneNumber']?></td>
                <td><?=$Sta['Hotel_Name']?></td>
                <td><?=$Sta['Hotel_Location']?></td>
                <td><?=isset($Sta['ManagerID']) ? $Sta['ManagerID'] : "none" ?></td>

                <td class="actions">
                    <a href="update-staff.php?id=<?=$Sta['ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete-staff.php?id=<?=$Sta['ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Shifts</h2>
    <table>
        <thead>
            <tr>
                <td>Total Staff</td>
                <td>Day Shift</td>
                <td>Night Shift</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$num_Staff?></td>
                <td><?=$StaffDayShift['Day Shift']?></td>
                <td><?=$StaffNightShift['Night Shift']?></td>
            </tr>
        </tbody>
    </table>

</div>

<?=template_footer()?>