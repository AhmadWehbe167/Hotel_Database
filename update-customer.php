<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the customer id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $custID = isset($_POST['custID'])? $_POST['custID'] : '';
        $cname = isset($_POST['cname'])? $_POST['cname'] : '';
        $gender = isset($_POST['gender'])? $_POST['gender'] : '';
        $phone = isset($_POST['phone'])? $_POST['phone'] : '';
        $email = isset($_POST['email'])? $_POST['email'] : '';
        $status = isset($_POST['status'])? $_POST['status'] : '';
        $address = isset($_POST['address'])? $_POST['address'] : '';
        $facilities = isset($_POST['facilities'])? $_POST['facilities'] : '';
        $amount = 100;

        // Update the record in customer table
        $stmt = $pdo->prepare('UPDATE customer SET ID = ?, Name = ?, Gender = ?, Email = ?, Address = ?, PhoneNumber = ? WHERE ID = ?');
        $stmt->execute([$custID, $cname, $gender, $email, $address, $phone, $_GET['id']]);

         // Update the record in invoice table
        $stmt = $pdo->prepare('UPDATE invoice SET CustomerID = ?, Description = ?, TotalAmount = ? WHERE CustomerID = ?');
        $stmt->execute([$custID, $status, $amount, $_GET['id']]);

         // Update the record in facilities table
        $stmt = $pdo->prepare('UPDATE facilities SET Type = ?, CustomerID = ?, Price = ? WHERE CustomerID = ?');
        $stmt->execute([$facilities, $custID, $amount, $_GET['id']]);


        $msg = 'Updated Successfully!';
    }
    // Get the customer from the customers table
    $stmt = $pdo->prepare('SELECT C.ID, C.Name, C.Gender, C.Email, C.Address, C.PhoneNumber, I.Description, F.Type
                    FROM (customer C LEFT JOIN INVOICE I 
                    ON C.ID = I.CustomerID)
                    LEFT JOIN facilities F
                    ON C.ID = F.CustomerID
                    WHERE C.ID = ?');
    $stmt->execute([$_GET['id']]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$customer) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Customer')?>

<div class="content update">
	<h2>Update Customer #<?=$customer['ID']?></h2>
    <form action="update-customer.php?id=<?=$customer['ID']?>" method="post">
        <label for="custID">Customer ID</label>
        <label for="cname">Name</label>
        <input type="text" name="custID" placeholder="123" id="custID" required="true" value="<?=$customer['ID']?>">
        <input type="text" name="cname" placeholder="John Doe" id="cname" required="true" value="<?=$customer['Name']?>">
        <label for="gender">Gender</label>
        <label for="address">Address</label>
        <input type="text" name="gender" placeholder="Male" id="gender" required="true" value="<?=$customer['Gender']?>">
        <input type="text" name="address" placeholder="Beirut" id="address" required="true" value="<?=$customer['Address']?>">
        <label for="email">Email</label>
        <label for="phone">Phone Number</label>
        <input type="text" name="email" placeholder="example@email.com" id="email" required="true" value="<?=$customer['Email']?>">
        <input type="number" name="phone" placeholder="03123456" id="phone" required="true" value="<?=$customer['PhoneNumber']?>">
        <label for="facilities">Facilities</label>
        <label for="status">Status</label>
        <input type="text" name="facilities" placeholder="Gym" id="facilities" value="<?=$customer['Type']?>">
        <input type="text" name="status" placeholder="not paid" id="status" required="true" value="<?=$customer['Description']?>">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>