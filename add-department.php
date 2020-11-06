<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    if(isset($_POST['dno']) && isset($_POST['dname']) && isset($_POST['dlocation'])){

            $dno = $_POST['dno'];
            $dname = $_POST['dname'];
            $dlocation = $_POST['dlocation'];

            // Insert new record into the 'department' table
            $stmt = $pdo->prepare('INSERT INTO department VALUES (?, ?, ?)');
            $stmt->execute([$dno, $dname, $dlocation]);
            // Output message
            $msg = 'Department Added Successfully!';
    }
    else{
        $msg = 'Something went wrong!';
    }

}
?>

<?=template_header('Add Department')?>

<div class="content update">
    <h2>Add a New Department</h2>
    <form action="add-department.php" method="post">
        <label for="dno">*Department #</label>
        <label for="dname">*Name</label>
        <input type="text" name="dno" placeholder="10" id="dno" required="true">
        <input type="text" name="dname" placeholder="Accounting" id="dname" required="true">
        <label for="dlocation">*Location</label>
        <input type="text" name="dlocation" placeholder="New York" id="dlocation" required="true">
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>