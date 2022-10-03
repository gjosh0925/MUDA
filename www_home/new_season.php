<?php

include_once 'header.php';

$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'admin';
$admins = new user();
$admins = $admins->FindAllByParams($params);
error_log(print_r($admins, true));

?>

<script>
    $(function () {
        $("#upload").bind("click", function () {
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
            if (regex.test($("#fileUpload").val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var table = $("<table />");
                        var rows = e.target.result.split("\n");
                        for (var i = 0; i < rows.length; i++) {
                            var row = $("<tr />");
                            var cells = rows[i].split(",");
                            if (cells.length > 1) {
                                for (var j = 0; j < cells.length; j++) {
                                    var cell = $("<td />");
                                    cell.html(cells[j]);
                                    row.append(cell);
                                }
                                table.append(row);
                            }
                        }
                        $("#dvCSV").html('');
                        $("#dvCSV").append(table);
                    }
                    reader.readAsText($("#fileUpload")[0].files[0]);
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        });
    });
</script>

<style>
    .step{
        margin: 20px 40px 40px 40px;
        border: 3px solid #0c2340;
        border-radius: 5px;
        padding: 30px;
    }

    h3{
        margin: 50px 0px 0px 50px;
    }
</style>

<h1>Create New Season</h1>

<form id='seasonForm' action="new_season.php" method="post">

    <h3>Step 1: Season Info</h3>
    <div id="step1" class="step">
        <label>Season Name</label>
        <input class="form-control" type="text" name="season_name"><br>
        <label>Start Date</label>
        <input class="form-control" type="date" name="start_date"><br>
        <label>End Date</label>
        <input class="form-control" type="date" name="end_date"><br>
        <label>Playoff Date</label>
        <input class="form-control" type="date" name="playoff_date"><br>
        <label>Season Info</label>
        <input class="form-control" type="text" name="season_info"><br>
    </div>

    <h3>Step 2: Upload Players</h3>
    <div id="step2" class="step">

        <input type="file" id="fileUpload">
        <input type="button" id="upload" value="Upload">
        <hr />
        <div id="dvCSV"></div>
    </div>

    <h3>Step 3: Choose League Coordinators playing this season</h3>
    <div id="step3" class="step">
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Preference</label>
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected></option>
                <option value="1">Playing</option>
                <option value="2">Not Playing</option>
            </select>
        </div>
    </div>

    <h3>Step 4: Choose Captains</h3>
    <div id="step4" class="step">
        Please complete Step 3 first
    </div>

    <button type="submit" class="btn btn-secondary">Create Season</button>
</form>

<?php include_once 'footer.php'; ?>
