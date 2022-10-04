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

<style>
    .loginlogout:hover{
        cursor: pointer;
        color: rgba(0,0,0,.9) !important;
    }

    a, span {
        font-size: 20px;
    }

</style>

<!DOCTYPE html>
<html lang="English">
<head>
    <script src="<?php echo $config['system_url']?>js/environment.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" href="images/person-running-solid.svg">
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>MUDA</title>
</head>


<?php if ($_SERVER['REQUEST_URI'] !== '/MUDA/www_home/login.php') { ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00b2a9; height: 80px;">
        <img src="images/muda_logo_black_horizontal.png" width="18%" style="position:relative;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Teams <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="draft.php">Draft <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <?php if (!isset($pageUser)) { ?>
                <span class="navbar-text loginlogout" onclick="window.location='login.php'" style="padding-right: 40px; color: rgba(0,0,0,.5);">Login</span>
            <?php } else { ?>
                <span class="navbar-text loginlogout" onclick="window.location='logout.php'" style="padding-right: 40px; color: rgba(0,0,0,.5);">Logout</span>
            <?php } ?>
        </div>
    </nav>
<?php } ?>

