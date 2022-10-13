<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$teams = new teams();
$teams = $teams->FindAllByParams($params);

?>

<style>

    h1 {text-align: center;}

    code {
        font-family: Consolas,"courier new";
        color: crimson;
        background-color: #f1f1f1;
        padding: 2px;
        font-size: 105%;
    }

    table, th, td {
        border: 1px solid black;
        border-radius: 10px;

        padding-top: 10px;
        padding-bottom: 20px;
        padding-left: 30px;
        padding-right: 40px;
        border-spacing: 100px;

        color: white;
        font-size: 105%;
    }

    tr{
        style: width:150%;
        style: height:200px;
    }

    table.center {
        margin-left: auto;
        margin-right: auto;
    }

    .teamNames {
        border: 4px solid #0c2340;
        border-radius: 20px;
        padding: 40px 0 40px 0;
        margin: 50px;
        font-size: 24px;
        background-color: #00b2a9;
        color: white;
        text-align: center;
        width: 15%;
    }

</style>

<?php if (!isset($_GET['teamid'])) { ?>
    <h1>League's Teams</h1>

    <div style="display:flex; flex-wrap: wrap; justify-content: space-evenly; padding: 100px;">
        <?php foreach($teams as $team) {
            $teamDiv = '<div class="teamNames" onclick="window.location.href = \'teams.php?teamid=' . $team->getID() . '\'">' . $team->getName() . '</div>';
            echo $teamDiv;
            echo $teamDiv;
            echo $teamDiv;
        } ?>
    </div>

<?php } else { ?>
    <?php $team = new teams($_GET['teamid']); ?>
    <div>
        <button class="btn btn-secondary" style="float:left; margin: 20px;" onclick="window.location.href='teams.php'"><i class="fa-solid fa-arrow-left"></i>Back</button>
        <h1>Team <?php echo $team->getName(); ?></h1>
    </div>
<?php } ?>


<!--<table class="center"; style= "width:100%;">-->
<!--    <tr style = "height:200px;">-->
<!--        <th style="background-color:Crimson;"><a href="">Team Red</a></th>-->
<!--        <th style="background-color:DodgerBlue"><a href="">Team Blue</a></th>-->
<!--        <th style="background-color:ForestGreen;"><a href="">Team Green</a></th>-->
<!--    </tr>-->
<!--    <tr style = "height:200px;">-->
<!--        <th style="background-color:DarkOrange;"><a href="">Team Orange</a></th>-->
<!--        <th style="background-color:Yellow;"><a href="">Team Yellow</a></th>-->
<!--        <th style="background-color:Purple;"><a href="">Team Purple</a></th>-->
<!--    </tr>-->
<!--</table>-->

<!--<h3 onclick="window.location.href = 'teams.php?teamid=1234'">Test Team</h3>-->


<?php include_once 'footer.php'; ?>

