<?php
include ("database.php");
$nameError = "";
$emailError = "";
$passwordError = "";
$phoneError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $date = $_POST["date"];
  $address = $_POST["address"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  if (empty($username)) {
    $nameError = "Name is required";
  } else {
    $username = trim($username);
    $username = htmlspecialchars($username);
    if (!preg_match("/^[a-zA-Z ]+$/", $username)) {
      $nameError = "Name should contain characters and whitespace";
    }
  }

  // Validate email
  if (empty($email)) {
    $emailError = "Email is required";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email format";
    } elseif (substr_count($email, '.com') !== 1) {
      $emailError = "Email should contain '.com' exactly once";
    }
  }

  // Validate password
  if (empty($password)) {
    $passwordError = "Password is required";
  } else {
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
      $passwordError = "Password should contain at least one uppercase letter, one lowercase letter, one digit, one symbol, and be at least 8 characters long";
    }
  }

  // Validate date
  if (empty($date)) {
    $dateError = "Date of Birth is required";
  } else {
    $currentDate = date("Y-m-d");
    if (strtotime($date) > strtotime($currentDate)) {
      $dateError = "Date of Birth should be in valid format. Please Enter correct date";
    }
  }

  if (!($nameError) && !($emailError) && !($passwordError) && !($dateError)) {
     // connection of the database 
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $conn->prepare("INSERT INTO users (username, date, address, email, password) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
      $stmt->bind_param("sssss", $username, $date, $address, $email, $password);

      if ($stmt->execute()) {
        header("Location:login.php");
      } else {
        echo "Error executing statement: " . $stmt->error;
      }

      $stmt->close();
    } else {
      echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    form {
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      width: 400px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    button {
      background-color: #4caf50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    h1 {
      text-align: center;
      color: red;
    }
  </style>
  <title>Registration Form</title>
</head>

<body>
  <form method="post" >

    <h1>Registration Form </h1>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">

    <span style="color:red;"> <?php echo $nameError ?> </span>
    <br>

    <label for="date">DOB</label>
    <input type="date" id="date" name="date" required value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '' ?>">
    <span style="color:red;"> <?php echo $dateError ?> </span>
    <br>

    <label for="address">Address</label>
    <input type="address" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
    <span style="color:red;"> <?php echo $emailError ?> </span>
    <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>">
    <span style="color:red;"> <?php echo $passwordError ?> </span>

    <br>
    <!-- <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required> -->

    <button type="submit" name="submit">Login</button>
  </form>
  </div>
</body>

</html>