<?php
include_once '../includes/includes.php';

global $config;

if(session_start() !== null){
    if (isset($_SESSION['PageUserID'])) {
        $pageUser = new user($_SESSION['PageUserID']);
    } else {
        session_abort();
    }
}

?>

<!DOCTYPE html>
<html lang="English">
<head>
    <script src="<?php echo $config['system_url']?>js/environment.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" href="images/person-running-solid.svg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>MUDA</title>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="#">Features</a>
            <a class="nav-item nav-link" href="#">Pricing</a>
            <a class="nav-item nav-link disabled" href="#">Disabled</a>
        </div>
    </div>
</nav>

