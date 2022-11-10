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

    function showSuccessBanner(){
        $('#successBanner').show();
        setTimeout(function() {
            $('#successBanner').slideUp(1000);
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

    .show{
        padding:20px 0px 20px 40px;
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

<div id="successBanner" class="alert alert-success success-alert" role="alert" style="display:none;">

</div>

<?php if (!str_contains($_SERVER['REQUEST_URI'],'/MUDA/login.php')) { ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00b2a9; height: 80px; z-index:1;">
        <img src="images/muda_logo_black_horizontal.png" width="18%" style="position:relative;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" style="background-color: #00b2a9" id="navbarSupportedContent">
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
                <?php if (isset($pageUser) && $pageUser->getUserRole() == "admin" || isset($pageUser) && $pageUser->getUserRole() == "adminPlaying" || isset($pageUser) && $pageUser->getUserRole() == "adminCaptain") { ?>
                    <li class="nav-item">
                        <a class="nav-link links" href="new_season.php">New Season</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link links" href="settings.php">Settings</a>
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