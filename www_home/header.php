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
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>MUDA</title>
</head>


<?php if ($_SERVER['REQUEST_URI'] !== '/MUDA/www_home/login.php') { ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand nav-link" href="index.php"> MUDA <span class="sr-only">(current)</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="draft.php">Draft</a>
            <a class="nav-item nav-link" href="">Teams</a>
            <a class="nav-item nav-link" href="">Another Webpage</a>
            <?php if (!isset($pageUser)) { ?>
                <a class="nav-item nav-link" href="login.php">Login</a>
            <?php } else { ?>
                <a class="nav-item nav-link" href="logout.php">Log out</a>
            <?php } ?>
        </div>
    </div>
</nav>
<?php } ?>

