<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="post">
        <label>Quantity</label>
        <input type="text" name="quantity">

        <input type="submit" value="submit">
    </form>
</body>

</html>

<?php
$item = "apple";
$price = 160.45;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = $_POST['quantity'];

    // Check if the quantity is numeric
    if (!is_numeric($quantity)) {
        echo "Please enter a valid numeric quantity.";
    } else {
        // Calculate and display the total
        $total = $price * $quantity;
        echo "The total price of apple is \${$total} <br>";
        $total = round($total, 1);
        echo "The total is {$total}";

        // Now, you can proceed to store the data in the database
        // ... (Add your database code here)
    }
}
?>
