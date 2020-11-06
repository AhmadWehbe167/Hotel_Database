<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    if(isset($_POST['custID']) && isset($_POST['cname']) && isset($_POST['gender']) && isset($_POST['address']) &&
        isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['status'])){

            $custID = $_POST['custID'];
            $cname = $_POST['cname'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            $address = $_POST['address'];
            $amount = 100;
            $Invoice = 6;

            $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : NULL;

            // Insert new record into the 'customer' table
            $stmt = $pdo->prepare('INSERT INTO customer VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$custID, $cname, $gender, $email, $address, $phone]);

            // Insert new record into the 'invoice' table
            $stmt = $pdo->prepare('INSERT INTO invoice(customerID, Description, TotalAmount) VALUES (?, ?, ?)');
            $stmt->execute([$custID, $status, $amount]);

            // Insert new record into the 'facilities' table
            $stmt = $pdo->prepare('INSERT INTO facilities VALUES (?, ?, ?)');
            $stmt->execute([$facilities, $custID, $amount]);


            // Output message
            $msg = 'Customer Added Successfully!';
    }
    else{
        $msg = 'Something went wrong!';
    }

}
?>

<?=template_header('Add Customer')?>

<div class="content update">
    <h2>Add a New Customer</h2>
    <form action="add-customer.php" method="post">

        <label for="custID">Customer ID</label>
        <label for="cname">Name</label>
        <input type="text" name="custID" placeholder="123" id="custID" required="true">
        <input type="text" name="cname" placeholder="John Doe" id="cname" required="true">
        <label for="gender">Gender</label>
        <label for="address">Address</label>
        <input type="text" name="gender" placeholder="Male" id="gender" required="true">
        <input type="text" name="address" placeholder="Beirut" id="address" required="true">
        <label for="email">Email</label>
        <label for="phone">Phone Number</label>
        <input type="text" name="email" placeholder="example@email.com" id="email" required="true">
        <input type="number" name="phone" placeholder="03123456" id="phone" required="true">
        <label for="facilities">Facilities</label>
        <label for="status">Status</label>
        <input type="text" name="facilities" placeholder="Gym" id="facilities">
        <input type="text" name="status" placeholder="not paid" id="status" required="true">
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>