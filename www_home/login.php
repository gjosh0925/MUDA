<?php
 include_once 'header.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email)) {
        header("Location: login.php?error=Email is required");
        exit();
    }else if(empty($pass)){
        header("Location: login.php?error=Password is required");
        exit();
    }else{
        login();
    }
}

?>

<form action="login.php" method="post">
    <h2>LOGIN</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <label>Email</label>
    <input type="email" name="email" placeholder="Email"><br>
    <label>Password</label>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit">Login</button>
</form>


