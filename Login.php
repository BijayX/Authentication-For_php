<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: exp.php.html");
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
            height: 500px;
            
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            width: 400px;
            
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 70%;
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
        h1{
         text-align: center;
         color: red;
        }
        .error {
            color: red;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .alert {
           color: red;
           margin-top: -10px;
           margin-bottom: 10px;
        }

        .alert-danger {
          background-color: #f8d7da;
          border-color: #f5c6cb;
          color: #721c24;
        }

    </style>
    <title>Login</title>
</head>
<body>
    <div class="container">
    <?php
       $emailError = "";
       $passwordError = "";
       if(isset($_POST["submit"])){
        $email=$_POST["email"];
        $password=$_POST["password"];
        if (empty($email)) {
            $emailError = "Email is required";
          } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $emailError = "Invalid email format";
            } elseif (substr_count($email, '.com') !== 1) {
              $emailError = "Email should contain '.com' exactly once";
            }
          }
        
        if (empty($password)) {
            $passwordError = "Password is required";
        } else {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
              $passwordError = "Password should contain at least one uppercase letter, one lowercase letter, one digit, one symbol, and be at least 8 characters long";
            }
          }
        if (!($emailError) && !($passwordError) ){

        require_once "database.php";
        $sql="SELECT * FROM users WHERE email = '$email'";
        $result=mysqli_query($conn , $sql);
        $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            if ($user && $password == $user["password"]) {
                    session_start();
                    $_SESSION["users"] = "yes";
                    header("Location:exp.php");
                    die();
            }
            else{
                echo  "<div class ='alert alert-danger'>Password Doesnot match </div>";
            }
        }
        else {
            echo  "<div class ='alert alert-danger'>Email Doesnot match </div>";
        }

       }
    }
    ?>
    <form  action="login.php" method="post" >

        <h1>Login </h1>
       
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" >
        <br>
        <span style="color:red;"> <?php echo $emailError ?> </span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" >
        <br>
        <span style="color:red;"> <?php echo $passwordError ?> </span>

    
        <br>
        <button type="submit" name="submit" >Login</button>

        <a href="registration.php">Register Now</a>
    </form>
    </div>
     
</body>
</html>

