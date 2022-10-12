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

<style>
    #loginForm{
        display: flex;
        flex-direction: column;
        border: 3px solid #0c2340;
        width: 400px;
        padding: 30px;
        background-color: #00b2a9;
        border-radius: 30px;
    }

    .center{
        display: flex;
        flex-direction: column;
        align-content: center;
        align-items: center;
    }
</style>
<div class="center">
    <img style="width:700px; " src="images/muda_logo_black_horizontal.png">

    <form id='loginForm' action="login.php" method="post">
        <h2 style="padding:20px; text-align:center;">League Sign-In</h2>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>
        <label>Email</label>
        <input class="form-control" type="email" name="email"><br>
        <label>Password</label>
        <input class="form-control" type="password" name="password"><br>
        <button type="submit" class="btn btn-secondary">Sign-In</button>
    </form>
    <a href="index.php" style="padding:10px; color: #00b2a9;">Back to home page</a>
</div>


