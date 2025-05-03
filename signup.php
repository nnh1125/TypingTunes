<?php

include "connect_db.php";

$success = false;
$taken = false;
$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE username = '$username'";
    $result = $conn->query($sql);

    // checks if username is already taken
    if ($result->num_rows != 0) {
        $taken = true;
    } else {
        $success = true;
        $sqlinsert = "INSERT INTO `Users` (`UserId`, `Username`, `Password`) VALUES (NULL, '$username', '$password');";
        $conn->query($sqlinsert);
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
<h1>Sign up</h1>
<form method="post" action="signup.php" id="loginform">
            <div id="username-taken" style="color:#B7472F; display:none">
                This username has already been registered. Please choose a different one. 
                <br><br>
            </div>
            Already have an account? Log in <a href="login.php">here</a> <br><br>
        
            <label>
                Username: <br />
                <input type="input" 
                    id="username-input"
                    name="username"
                    maxlength ="10"
                    required />
                <div id="user-error" style="display:none; color:#B7472F"> Username must be alphanumeric<br></div>
            </label> <br>
        
            <label>
                Password: <br />
                <input type="password" 
                    id="password-input"
                    name="password"
                    maxlength ="40"
                    required />
            </label> <br>

            Your password must contain:
            <ul>
                <li id="characters">8 to 30 characters </li>
                <li id="uppercase">at least one uppercase letter </li>
                <li id="lowercase">at least one lowercase letter </li>
                <li id="numbers">at least one number </li>
                <li id="match">the two passwords must match </li>
            </ul>

            <label>
                Reenter Password: <br />
                <input type="password" 
                    id="password-input2"
                    name="password"
                    maxlength ="40"
                    required />
            </label> <br>
            <br />
            <div style="text-align: center; display:none" id="register_user">
                <button type="submit">Create Account</button>
            </div>
          </form>

          <form action="type.html" id="signup-success" style="display:none; text-align:center">
                Thank you for making an account! <br><br>
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

    valid_username = false;
    valid_password = false;

        window.onload = function() {
            document.getElementById('password-input').onkeyup = function() {checkPassword()}
            document.getElementById('password-input2').onkeyup = function() {checkPassword()}
            document.getElementById('username-input').onkeyup = function() {checkUsername()}
            success = "<?php echo $success; ?>"
            username = "<?php echo $username; ?>"
            taken = "<?php echo $taken; ?>"
            password = "<?php echo $password; ?>"
            // if registration is successful, lets user proceed to type.html
            if (success) {
                document.getElementById('loginform').style.display = "none";
                document.getElementById('signup-success').style.display = "block";
                document.getElementById('username-verified').value = username;
            }
            // if username is taken, lets user enter a different one
            if (taken) {
                document.getElementById('username-taken').style.display = "block";
                document.getElementById('password-input').value = password;
                document.getElementById('password-input2').value = password;
            }
            checkPassword();
    }

    //checkUsername
    //purpose: checks validity of the username entered by user
    //input: none
    //output: none
    function checkUsername() {
        username = document.getElementById('username-input').value
        // checks username is alphanumeric
        if (/^[a-zA-Z0-9_]*$/.test(username)) {
            valid_username = true;
            document.getElementById('user-error').style.display = "none";
        } else {
            valid_username = false;
            document.getElementById('user-error').style.display = "block";
        }
        displayButton()
    }
    
    //checkPassword
    //purpose: checks validity of the passwords entered by user
    //input: none
    //output: none
    function checkPassword() {
        valid_password = true;
        passw1 = document.getElementById('password-input').value
        passw2 = document.getElementById('password-input2').value
        if (/[A-Z]/.test(passw1)) {
            document.getElementById('uppercase').style.color = "#509C43"
        } else {
            document.getElementById('uppercase').style.color = "#B7472F"
            valid_password = false;
        }
        if (/[a-z]/.test(passw1)) {
            document.getElementById('lowercase').style.color = "#509C43"
        } else {
            document.getElementById('lowercase').style.color = "#B7472F"
            valid_password = false;
        }
        if ((passw1.length > 7) && (passw1.length < 31)) {
            document.getElementById('characters').style.color = "#509C43"
        } else {
            document.getElementById('characters').style.color = "#B7472F"
            valid_password = false;
        }
        if (/\d/.test(passw1)) {
            document.getElementById('numbers').style.color = "#509C43"
        } else {
            document.getElementById('numbers').style.color = "#B7472F"
            valid_password = false;
        }
        if (passw1 == passw2 && (passw1.length > 0)) {
            document.getElementById('match').style.color = "#509C43"
        } else {
            document.getElementById('match').style.color = "#B7472F"
            valid_password = false;
        }
        checkUsername()
    }

    // displays "Create Account" button if username and password are valid
    function displayButton() {
        if (valid_password && valid_username) {
            document.getElementById('register_user').style.display = "block";
        } else {
            document.getElementById('register_user').style.display = "none";
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