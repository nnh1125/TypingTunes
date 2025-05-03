<?php

include "connect_db.php";

$success = false;
$attempt = false;
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attempt = true;
    $username = $_POST['username'];
    $password_entered = $_POST['password'];

    // searches for username in database
    $sql = "SELECT * FROM Users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $success = false;
    } else {
        while($row = $result->fetch_assoc()) 
        {
            // checks if the password entered matches the actual password
            $password_actual = $row['Password'];
            if ($password_entered == $password_actual) {
                $success = true;
            }

        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <title>Typing Tunes</title>
</head>

<body>
<header>
        <div class="history">
        </div>
        <h1>Typing Tunes</h1>
        <div class="rankings">
        </div>
    </header>
<main>
<section class="login">
<h1>Login</h1>
<form method="post" action="login.php" id="loginform">
            <div id="wrong_password" style="color:#B7472F; display:none">
                Incorrect username or password
                <br><br>
            </div>
                Don't have an account? Sign up <a href="signup.php">here</a> <br><br>
            <label>
                Username: <br />
                <input type="input" 
                    id="username-input"
                    name="username"
                    maxlength ="40"
                    required />
            </label> <br>
        
            <label>
                Password: <br />
                <input type="password" 
                    id="password-input"
                    name="password"
                    maxlength ="40"
                    required />
            </label> <br>

            <br />
            <div style="text-align: center" id="register_user">
                <button type="submit">Login</button>
            </div>
          </form>

          <form action="type.html" id="signup-success" style="display:none; text-align:center">
                Welcome back! <br><br>
                <input type="input" 
                        id="username-verified"
                        name="username"
                        style="display:none">
                <button type="submit">Start Typing!</button>
            </form>

          </section>


    
</main>

<footer>
       <div class="history">
       </div>
      <div>Typing Tunes</div>
       <div class="rankings">
       </div>
    </footer>

        <script>


        window.onload = function() {
            success = "<?php echo $success; ?>"
            username = "<?php echo $username; ?>"
            attempt = "<?php echo $attempt; ?>"
            // if username and password are in the database, let user proceed to type.html
            if (success) {
                document.getElementById('loginform').style.display = "none";
                document.getElementById('signup-success').style.display = "block";
                document.getElementById('username-verified').value = username;
            // if either username or password is incorrect, let user try again
            } else if (attempt) {
                document.getElementById('wrong_password').style.display = "block";
            }
    }

    /**
     * Callback function for when a user logs in. Adds their username to cookie
     * data.
     */
     const handleSubmit = (event) => {
      const formData = new FormData(document.getElementById("signup-success"));
      const username = formData.get("username");
      document.cookie = "username=" + username + "; SameSite=lax";

    }

    const form = document.getElementById("signup-success");
    form.addEventListener("submit", handleSubmit);
    
    

        
        </script>

</body>