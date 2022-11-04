<?php
   include 'connection.php';
  include 'template/header.php';
  
?>
<?php  
$passwordErr = $emailErr = $invalidData = "";
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      }
    $email = $_POST["email"];
    $password = $_POST["password"];
    

    $sql = sprintf(
        "SELECT * FROM user
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"])
    );

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["rank"] = $user["usertype"];
            $_SESSION["Uname"] = $user["name"];

            header("Location: index.php");
            if($user["usertype"] === "admin") {
                header("Location: admin.php");
                exit;
            }
            
        } 
    }

 }
 
?>
<form class="forms" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <!-- Email input -->
  <h1>Login</h1>
  <br>
  <div class="form">
    <input type="email"  class="form-control" name="email" placeholder="Email"/>
    <span class="error"> <?php echo $emailErr;?></span>
</div>
   <br>
  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" class="form-control" name="password" placeholder="password" />
  </div>

  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
        <label class="form-check-label"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div>

  <!-- Submit button -->
  <button type="submit" 
  class="btn btn-primary btn-block mb-4">Login</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="registration.php">Register</a></p>
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