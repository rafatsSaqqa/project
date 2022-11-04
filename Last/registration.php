<?php
   include 'connection.php';
  include 'template/header.php';
  
?>
<?php  
$emailErr = $nameErr = $passErr ="";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
if (empty($_POST["name"])) {
  $nameErr ="Name is required";
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}


if ($_POST["password"] !== $_POST["confirmPassword"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    if ($mysqli->error == 1062) {
        die("email already taken");
    } else {
        // die($mysqli->error . " " . $mysqli->errno);
    }
}
}
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <!-- Email input -->
  <h1>Registar</h1>
  <br>
  <div class="form-outline mb-4">
    <input type="text" class="form-control" name="name" placeholder="Name" />
  </div> <?php echo $nameErr ;?>
    
  <div class="form">
    <input type="email"  class="form-control" name="email" placeholder="Email"/>
    <span class="error"> <?php echo $emailErr;?></span>
</div>
   <br>
  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" class="form-control" name="password" placeholder="Password" />
  </div>

  <div class="form-outline mb-4">
    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password" />
  </div>
    
  </div>

  <!-- Submit button -->
  <button type="submit" 
  class="btn btn-primary btn-block mb-4">Sign up</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>A member? <a href="login.php">Login</a></p>
    <p>or sign up with:</p>



    
    <button type="button" class="btn btn-link btn-floating mx-1">
      <i class="fab fa-facebook-f"></i>
    </button>

    <button type="button" class="btn btn-link btn-floating mx-1">
      <i class="fab fa-google"></i>
    </button>

    <button type="button" class="btn btn-link btn-floating mx-1">
      <i class="fab fa-twitter"></i>
    </button>

    <button type="button" class="btn btn-link btn-floating mx-1">
      <i class="fab fa-github"></i>
    </button>
  </div>
</form>


<?php

include 'template/footer.php';


?>