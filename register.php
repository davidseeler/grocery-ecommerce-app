<?php
    include('database.php');
    session_start();

    $username = $password = $confirmation = $creditcard = $email = "";
    $usernameErr = $passwordErr = $confirmationErr = $creditCardErr = $emailErr = "";

    // Insert values into database once submit is entered
    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $confirmation = $_POST['passwordConfirmation'];
        $creditcard = $_POST['credit-card'];
        $email = $_POST['email'];
        $cartID = rand(1000, 9999); // check for duplicates
        $phone = $_POST['phone'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address1 = $_POST['address1'];
        $country = $_POST['country'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        // Username Validation
        if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
            $usernameErr = "Only alphanumeric characters allowed.";
        }

        // Check if username is taken
        $query = "SELECT * FROM account WHERE username='$username'";
        $usernameCheck = $db->query($query);
        $usernameCheck = $usernameCheck->fetch();

        if (!empty($usernameCheck)){
            $usernameErr = "Username already taken.";
        }

        // Password Validation
        if (strcmp($password, $confirmation) !== 0) {
            $confirmationErr = "Passwords must match. ";
        }
        if (!preg_match("/^[a-zA-Z0-9]*$/",$password)) {
            $passwordErr = "Only alphanumeric characters allowed.";
        }

        // Email Validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format.";
        }

        // Credit-Card Validation
        if (!preg_match('/^[0-9]+$/', $creditcard)) {
            $creditCardErr = "Only numbers allowed.";
        }

        // If no errors then account is created
        if (!empty($usernameErr) || !empty($confirmationErr) || !empty($passwordErr) || !empty($emailErr) || !empty($creditCardErr)) {

            $_POST['username'] = NULL;
            $_POST['password'] = NULL;
            $_POST['passwordConfirmation'] = NULL;
            $_POST['credit-card'] = NULL;
            $_POST['email'] = NULL;
            
        } else {

            $statement = "INSERT INTO account (username, hashed_password, cartID, creditCard, email, phone, firstName, lastName,
            address1, country, zipcode, city, state)
            VALUES ('$username', '$hashed_password', $cartID, '$creditcard', '$email', '$phone', '$firstName', '$lastName', '$address1',
            '$country', '$zipcode', '$city', '$state')";
            $db->exec($statement);

            // Create session variables
            $_SESSION['username'] = $username;
            $_SESSION['cartID'] = $cartID; 

            // Redirect to account details page
            header("Location: account.php");
        }
    }
?>

<html lang="en" id="homeHTML">
    <head>
        <meta charset="UTF-8">
        <title>NED's Grocery</title>
        <link rel="shortcut icon" href="images/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="slider.css">
        <link rel="stylesheet" href="style.css">
        <script>
            var registerSubmit = function() {

                var username = $("username").value;
                var password = $("password").value;
                var passwordConfirmation = $("passwordConfirmation").value;
                var creditCard = $("credit_card").value;
                var email = $("email").value;
                var phone = $("phone").value;
                var firstName = $("firstName").value;
                var lastName = $("lastName").value;
                var address1 = $("address1").value;
                var address2 = $("address2").value;
                var country = $("country").value;
                var zipcode = $("zipcode").value;
                var city = $("city").value;
                var state = $("state").value;

                var errorMessage = "";

                if (username == "" || password == "" || passwordConfirmation == "" || creditCard == "" || email == "" 
                    || phone == "" || firstName == "" || lastName == "" || address1 == "" || 
                    country == "" || zipcode == "" || city == "" || state == "") {

                errorMessage = "All Fields must be filled in!";
                }

                if (errorMessage == "") {
                $("register_form").submit();
                } else {
                alert(errorMessage);
                }
            };

            window.onload = function() {
                $("registerSubmit").onclick = registerSubmit;
            };
        </script>
    </head>
    <body id="homeBody">
        <form method="POST" action="search.php">
            <header>
                <nav id="homeNav">
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <a href="account.php">Account</a>
                        <a href="search.php">Search</a>
                        <a href="search.php">Department</a>
                        <a href="checkout.php">Checkout</a>
                        <a href="contact.php">Contact</a>
                    </div>
                    <span id="menuButton" onclick="openNav()">&#9776;</span>
                    <a href="home.php"><img id="logo" src="images/logo.png"></a>
                    <div id="searchForm">
                            <input id="searchBar" type=text placeholder="Search Products" name="search">
                            <button id="searchButton" type=submit><i class="fa fa-search"></i></button>
                    </div>
                    <div id="accountBox">
                        <a id="accountLink" href="account.php"><image id="accountIcon" src="images/accountIcon.png"></image>Account</a> 
                    </div>
                    <div id="cartBox">
                        <a id="cartLink" href="cart.php"><image id="cartIcon" src="images/shoppingCartIcon.png"></image>Shopping Cart</a>
                        <span id="itemCount">
                            <?php
                                if (!isset($_SESSION['cartID'])){
                                    echo "";
                                }
                                else if ($itemCount['SUM(quantity)'] == NULL){
                                    echo "(0)";
                                }
                                else{
                                    echo "(".$itemCount['SUM(quantity)'].")";
                                } 
                                ?>
                        </span>
                    </div>
                </nav>
            </header>
        </form>
        <main id="homeMain">
            <div id="container_register">
                <img id="registerImg" src="images/logo.png">
                <form method="POST" id="register_form">
                    <p><span class="error">* All Fields Required</span></p>
                    <div id="LeftRegister">
                        <ul id="registrationList"> <!-- validate data first and put text restrictions on input-->
                            <li>
                                <label>Username: <span class="error">* <?php echo $usernameErr;?></span></label><br>
                                <input class="registerField" name="username" id="username" type="text" value="<?php echo $username;?>"><br>
                            </li>
                            <li>
                                <label>Password: <span class="error">* <?php echo $passwordErr;?></span></label><br>
                                <input class="registerField" name="password" id="password" type="password" value="<?php echo $password;?>"><br>
                            </li>
                            <li>
                                <label>Password Confirmation: <span class="error">* <?php echo $confirmationErr;?></span></label><br>
                                <input class="registerField" name="passwordConfirmation" id="passwordConfirmation" type="password" value="<?php echo $confirmation;?>"><br>
                            </li>
                            <li>
                                <label>Credit Card: <span class="error">* <?php echo $creditCardErr;?></span></label><br>
                                <input class="registerField" name="credit-card" id="credit_card" type="text" value="<?php echo $creditcard;?>"><br>
                            </li>
                            <li>
                                <label>Email: <span class="error">* <?php echo $emailErr;?></span></label><br>
                                <input class="registerField" name="email" id="email" type="text" value="<?php echo $email;?>"><br>
                            </li>
                            <li>
                                <label>Phone: <span class="error">*</span></label><br>
                                <input class="registerField" name="phone" id="phone" type="text"><br>
                            </li>
                    </div>    
                    <div id="rightRegister">
                        <form method="POST">
                            <ul id="rightRegisterList">
                                <li>
                                    <label>Shipping Address:</label>
                                    <span class="error">*</span><br>
                                    <input class="registerField" name="firstName" id="firstName" type="text" placeholder="First Name*"><br>
                                    <input class="registerField" name="lastName" id="lastName" type="text" placeholder="Last Name*"><br>
                                    <input class="registerField" name="address1" id="address1" type="text" placeholder="Address 1*"><br>
                                    <input class="registerField" name="address2" id="address2" type="text" placeholder="Address 2"><br>
                                    <input class="registerField" name="country" id="country" type="text" placeholder="Country / Region*"><br>
                                    <input class="registerField" name="zipcode" id="zipcode" type="text" placeholder="Zipcode*"><br>
                                    <input class="registerField" name="city" id="city" type="text" placeholder="City*"><br>
                                    <input class="registerField" name="state" id="state" type="text" placeholder="State*"><br>
                                    <label id="sameAddressLabel">Same as billing address?</label>
                                    <input id="sameAddressBox" name="sameAddress" type="checkbox">
                                </li>
                            </ul>
                        </form>
                    </div>
                    </ul>
                    <input id="registerSubmit" type="submit">
                </form>
            </div>
        </main>
        <script src="index.js"></script>  
    </body>
    <footer id="homeFooter">
        <p>&copy; 2020 NED's Grocery</p>
    </footer>
</html>