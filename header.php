<?php
include_once 'includes/includes.php';

global $config;

if(session_start() !== null){
    if (isset($_SESSION['PageUserID'])) {
        $pageUser = new user($_SESSION['PageUserID']);
    } else {
        session_abort();
    }
}

?>

<script>

    function seasonCreated(){
        $('#seasonCreatedSuccess').show();
        setTimeout(function() {
            $('#seasonCreatedSuccess').slideUp(1000);
        }, 4000);
    }

    function loggedIn(){
        $('#loggedIn').show();
        setTimeout(function() {
            $('#loggedIn').slideUp(1000);
        }, 4000);
    }

</script>

<style>
    .loginlogout:hover{
        cursor: pointer;
        color: rgba(0,0,0,.9) !important;
    }

    .links {
        font-size: 20px;
    }

    .success-alert {
        position: absolute !important;
        z-index: 1;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        width: 25%;
        height: 10%;
        font-size: 24px;
        top: 90px;
        display: flex;
        justify-content: center;
        align-items: center;
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

<div id="seasonCreatedSuccess" class="alert alert-success success-alert" role="alert" style="display:none;">
    New season created successfully!
</div>

<div id="loggedIn" class="alert alert-success success-alert" role="alert" style="display:none;">
    Logged in successfully!
</div>

<?php if ($_SERVER['REQUEST_URI'] !== '/MUDA/login.php') { ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00b2a9; height: 80px;">
        <img src="images/muda_logo_black_horizontal.png" width="18%" style="position:relative;">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link links" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link links" href="teams.php">Teams</a>
                </li>
                <?php if (isset($pageUser)) { ?>
                    <li class="nav-item">
                        <a class="nav-link links" href="playerpage.php">Players</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link links" href="draft.php">Draft</a>
                    </li>
                <?php } ?>
                <?php if (isset($pageUser) && $pageUser->getUserRole() == "admin" || isset($pageUser) && $pageUser->getUserRole() == "adminPlaying") { ?>
                    <li class="nav-item">
                        <a class="nav-link links" href="new_season.php">New Season</a>
                    </li>
                <?php } ?>
            </ul>

            <?php if (!isset($pageUser)) { ?>
                <span class="navbar-text loginlogout links" onclick="window.location='login.php'" style="padding-right: 40px; color: rgba(0,0,0,.5);">Login</span>
            <?php } else { ?>
                <span class="navbar-text links" style="margin-right: 20px;">Welcome <?php echo $pageUser->getNickname(); ?></span>
                <span class="navbar-text loginlogout links" onclick="window.location='logout.php'" style="padding-right: 40px; color: rgba(0,0,0,.5);">Logout</span>
            <?php } ?>
        </div>
    </nav>
<?php } ?>

