<?php

include_once 'header.php';

$params = null;
$params['fld'] = 'Active';
$params['val'] = '1';
$season = new season();
$season = $season->FindByParams($params);

?>

<script>

    function generateSchedule(){

        let days = [];
        $('#daysCheckBox input').each(function(){
            if ($(this).is(':checked')){
                days.push($(this).val());
            }
        });

        var datapacket = {
            TODO: 'generateSchedule',
            Days: days,
            Fields: $('input[name=num_fields]').val(),
            Game1Time: $('input[name=start_time1]').val(),
            Game2Time: $('input[name=start_time2]').val(),
            SeasonID: '<?php echo $season->getID(); ?>'
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
                   //todo
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

<div>
    <button class="btn btn-secondary" style="float:left; margin: 20px;" onclick="window.location.href='settings.php'"><i class="fa-solid fa-arrow-left"></i>Back</button>
    <h1 style="text-align:center;">Create Schedule</h1>
</div>

<!--<form>-->
    <div style="display:flex; justify-content: space-evenly;">
        <div style="display:flex; flex-direction: column">
            <label>Start Date</label>
            <input class="form-control" type="date" name="start_date" value="<?php echo $season->getStartDate(); ?>"><br>
        </div>
        <div style="display:flex; flex-direction: column">
            <label>End Date</label>
            <input class="form-control" type="date" name="end_date" value="<?php echo $season->getEndDate(); ?>"><br>
        </div>
        <div style="display:flex; flex-direction: column">
            <label>Number of Fields</label>
            <input class="form-control" type="number" name="num_fields" min="1" max="10"><br>
        </div>
    </div>

    <h3 style="text-align:center;">Days of the Week</h3>
    <div id="daysCheckBox" style="display: flex;flex-wrap: nowrap;justify-content: space-evenly; padding: 20px;">
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="sunday" id="sunday">
            <p>Sunday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="monday" id="monday">
            <p>Monday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="tuesday" id="tuesday">
            <p>Tuesday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="wednesday" id="wednesday">
            <p>Wednesday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="thursday" id="thursday">
            <p>Thursday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="friday" id="friday">
            <p>Friday</p>
        </div>
        <div class="form-check">
            <input style="width: 20px; height: 20px;" class="form-check-input" type="checkbox" value="saturday" id="saturday">
            <p>Saturday</p>
        </div>
    </div>

    <h3 style="text-align:center;">Time of Day</h3>
    <div style="display:flex; justify-content: space-evenly;">
        <div style="display:flex; flex-direction: column">
            <label>Game 1 Start Time</label>
            <input class="form-control" type="time" name="start_time1"><br>
        </div>
        <div style="display:flex; flex-direction: column">
            <label>Game 2 Start Time</label>
            <input class="form-control" type="time" name="start_time2"><br>
        </div>
    </div>



<!--</form>-->
    <button class="btn btn-primary" onclick="generateSchedule();">Generate Schedule</button>

<?php include_once 'footer.php'; ?>