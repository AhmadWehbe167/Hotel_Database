<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET Request; if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Limit Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM department ORDER BY dno LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records so they can be displayed.
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of employees
$num_departments = $pdo->query('SELECT COUNT(*) FROM department')->fetchColumn();
?>

<?=template_header('Current Departments')?>

<div class="content read">
	<h2>Current Employees</h2>
	<a href="add-department.php" class="add-employee">Add Department</a>
	<table>
        <thead>
            <tr>
                <td>Department #</td>
                <td>Department</td>
                <td>Location</td>

                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $dept): ?>
            <tr>
                <td><?=$dept['dno']?></td>
                <td><?=$dept['dname']?></td>
                <td><?=$dept['dlocation']?></td>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="departments.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_departments): ?>
		<a href="departments.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>