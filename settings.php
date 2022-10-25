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

<script>
    function updateDraftOrder(elem){
        let input = $(elem).val();
        let clone = '';
        if (input < '1' || input > $(".order").length) {
            console.log('input too big or too small');
            $('.order input').each(function(i, val){
                $(val).val(i + 1);
            });
        } else {
            clone = $(elem).parent();
            $(elem).parent().remove();
            let newOrder = '';

            if (input == ($('.order').length + 1)) {
                $('#draftOrderDiv').append('<div class="order">' + $(clone).html() + '</div>');
            } else {
                $('#draftOrderDiv .order').each(function(i, val){
                    if ((i + 1) == input){
                        newOrder += '<div class="order" onclick="">' + $(clone).html() + '</div>';
                    }
                    newOrder += '<div class="order">' + $(val).html() + '</div>';
                });
                $('#draftOrderDiv').html(newOrder);
            }
            $('.order input').each(function(i, val){
                $(val).val(i + 1);
            });
        }
    }

    function submitDraftOrder(){

        let captainIDs = [];

        $('.order input').each(function(i){
           captainIDs.push($(this).attr('id'));
        });

        console.log(captainIDs);

        var datapacket = {
            TODO: 'submitDraftOrder',
            NewOrder: captainIDs
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,
            success: function(reply){
                if (reply.error === true){
                    console.log(reply.error);
                } else {
                    // seasonCreated();
                    $('#successBanner').html("Draft order updated successfully!");
                    showSuccessBanner();
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function submitSeasonInfo(){
        var datapacket = {
            TODO: 'submitSeasonInfo',
            SeasonID: '<?php echo $season->getID(); ?>',
            Name: $('input[name=season_name]').val(),
            StartDate: $('input[name=start_date]').val(),
            EndDate: $('input[name=end_date]').val(),
            PlayoffDate: $('input[name=playoff_date]').val(),
            Info: $('#seasonInfo').val()
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,
            success: function(reply){
                if (reply.error === true){
                    console.log(reply.error);
                } else {
                    console.log("hit");
                    $('#successBanner').html("Season information updated successfully!");
                    showSuccessBanner();
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }
</script>

<style>

    .section{
        border: 3px solid #0c2340;
        border-radius: 20px;
        margin: 20px;
    }

    .order{
        display:flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 3px solid #0c2340;
        border-radius: 10px;
        margin: 10px;
        background-color: #00b2a9;
        color: white;
    }

</style>

<h1 style="text-align:center;">Settings</h1>

<div style="display:flex; justify-content: space-around;">
    <div id="seasonInfo" class="section" style="width: 35%;">
        <h4 style="text-align:center;">Edit Season</h4>
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
            <textarea class="form-control" id="seasonInfo" name="info"><?php echo $season->getInfo(); ?></textarea>
        </form>
        <div style="display: flex; justify-content: center;">
            <button class="btn btn-secondary" onclick="submitSeasonInfo();" style="">Update Season</button>
        </div>
    </div>
    <div id="scheduleInfo" class="section" style="width: 50%;">
        <h4 style="text-align: center;">Edit Schedule</h4>
    </div>
    <div id="draftOrder" class="section" style="width: 15%; display:flex;  flex-direction: column; align-items: center;">
        <h4 style="text-align:center;">Edit Draft Order</h4>
        <div id="draftOrderDiv" style="display:flex; flex-direction: column;">
            <?php
            $draftOrder = '';
            foreach ($captains as $captain){
                $draftOrder .= '<div class="order"><input id="' . $captain->getID() . '" class="form-control" onchange="updateDraftOrder($(this));" style="width: 15%; height: 30px; text-align: center; padding: 0px !important;" value="' . $captain->getDraftOrder() . '"></input>' . $captain->getNickName() . '</div>';
            }

            echo $draftOrder;
            ?>
        </div>
        <button class="btn btn-secondary" style="margin-bottom: 10px;" onclick="submitDraftOrder();">Update Order</button>
    </div>
</div>
