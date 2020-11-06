<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if location is not empty
if (!empty($_POST) && isset($_POST['dlocation'])) {
	$location = $_POST['dlocation'];
	$stmt = $pdo->prepare('
		SELECT ename, dname, dlocation, ejob, emgr, ehiredate, esalary, ecommission 
		FROM department JOIN employee 
		ON edno = dno
		WHERE dlocation = ' . '\'' . $location . '\''
		);
	$stmt->execute();

	// Fetch the records so they can be displayed.
	$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$msg = $employees;

	$stmtPro = $pdo -> prepare('CALL pro(?)');
	$stmtPro -> bindValue(1, $location, PDO::PARAM_STR);
	$stmtPro -> execute();

	$summary = $stmtPro->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?=template_header('Home')?>

<div class="content update">
	<h2>Home</h2>
	<p>Welcome to the home page! You can search for employees by department location:</p>
	<form action="index.php" method="post">
        <label>*Location</label>
        <input type="text" name="dlocation" placeholder="New York" id="dlocation" required="true">
        <input type="submit" value="Search">
    </form>

	<?php if ($msg): ?>
		<div class="content read">
			<h2>Search Results</h2>
			<table>
		        <thead>
		            <tr>
		                <td>Employee</td>
		                <td>Department</td>
		                <td>Location</td>
		                <td>Job</td>
		                <td>Manager #</td>
		                <td>Hire Date</td>
		                <td>Salary</td>
		                <td>Commission</td>

		                <td></td>
		            </tr>
		        </thead>
		        <tbody>
		            <?php foreach ($employees as $emp): ?>
		            <tr>
		                <td><?=$emp['ename']?></td>
		                <td><?=$emp['dname']?></td>
		                <td><?=$emp['dlocation']?></td>
		                <td><?=$emp['ejob']?></td>
		                <td><?=$emp['emgr']?></td>
		                <td><?=$emp['ehiredate']?></td>
		                <td><?=$emp['esalary']?></td>
		                <td><?=$emp['ecommission']?></td>

		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </tbody>
		    </table>

			<h2>Department Summary</h2>
			<table>
		        <thead>
		            <tr>
		                <td>Department</td>
		                <td>Number of Employees</td>
		                <td>Average Salary</td>
		                <td>Minimum Salary</td>
		                <td>Maximum Salary</td>

		                <td></td>
		            </tr>
		        </thead>
		        <tbody>
		            <?php foreach ($summary as $e): ?>
		            <tr>
		                <td><?=$e['dname']?></td>
		                <td><?=$e['COUNT(eno)']?></td>
		                <td><?=$e['AVG(esalary)']?></td>
		                <td><?=$e['MIN(esalary)']?></td>
		                <td><?=$e['MAX(esalary)']?></td>

		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </tbody>
		    </table>
		</div>
    <?php endif; ?>

</div>

<?=template_footer()?>