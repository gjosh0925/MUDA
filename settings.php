<?php

include_once 'header.php';

$params = null;
$params['fld'] = 'Active';
$params['val'] = '1';
$season = new season();
$season = $season->FindByParams($params);

$params = null;
$params['fld'] = 'DraftOrder';
$params['opp'] = '!=';
$params['val'] = '-1';
$captains = new user();
$captains = $captains->FindAllByParams($params, 'DraftOrder');

?>

<style>

    .section{
        border: 3px solid #0c2340;
        border-radius: 20px;
        margin: 20px;
    }

    .order{
        display:flex;
        gap: 15px;
        padding: 15px;
        border: 3px solid #0c2340;
        border-radius: 10px;
        margin: 10px;
        background-color: #00b2a9;
    }

</style>

<h1 style="text-align:center;">Settings</h1>

<div style="display:flex; justify-content: space-around;">
    <div id="seasonInfo" class="section" style="width: 35%;">
        <h4 style="text-align:center;">Season</h4>
        <form style="padding: 20px;">
            <label>Season Name</label>
            <input class="form-control" type="text" name="season_name" value="<?php echo $season->getName(); ?>"><br>
            <div style="display:flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="display:flex; flex-direction: column">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="start_date" value="<?php echo $season->getStartDate(); ?>"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>End Date</label>
                    <input class="form-control" type="date" name="end_date" value="<?php echo $season->getEndDate(); ?>"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>Playoff Date</label>
                    <input class="form-control" type="date" name="playoff_date" value="<?php echo $season->getPlayoffDate(); ?>"><br>
                </div>
            </div>
            <label>Season Info</label>
            <textarea class="form-control" id="" name="info"><?php echo $season->getInfo(); ?></textarea>
            <button id="" type="submit" class="btn btn-secondary" style="">Update Season</button>
        </form>
    </div>
    <div id="scheduleInfo" class="section" style="width: 50%;">
        <h4 style="text-align: center;">Schedule</h4>
    </div>
    <div id="draftOrder" class="section" style="width: 15%;">
        <h4 style="text-align:center;">Draft Order</h4>
        <div>
            <?php
            $draftOrder = '';
            foreach ($captains as $captain){
                $draftOrder .= '<div class="order"><div>' . $captain->getDraftOrder() . '</div>' . $captain->getNickName() . '</div>';
            }

            echo $draftOrder;
            ?>
        </div>
    </div>
</div>
