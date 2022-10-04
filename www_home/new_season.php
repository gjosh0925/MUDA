<?php

include_once 'header.php';

//getting all of the admins
$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'admin';
$params['val2'] = 'adminPlayer';
$admins = new user();
$admins = $admins->FindAllByParams($params);

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
        margin: 20px 100px 40px 100px;
        border: 3px solid #0c2340;
        border-radius: 5px;
        padding: 30px;
    }

    h3{
        margin: 50px 0px 0px 110px;
    }

    .progressSteps{
        position:relative;
        left:35%;
        padding-bottom: 80px;
    }

    .check{
        position: relative;
        top: 45px;
        right: 45px;
    }
</style>

<!--<div style="display:flex;">-->
    <div id="progressDiv" style="background: #0c2340; width: 20%; color: white; position:fixed; top: 0; height: 100%; z-index: -1;padding-top:50px;">
        <div class="progressSteps" style="padding-top: 30px;">
            <i class="fa-2x fa-regular fa-circle-check check" style="background:#00b2a9; border-radius: 100%;"></i><h1>Step 1</h1>
        </div>
        <div class="progressSteps">
            <i class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 2</h1>
        </div>
        <div class="progressSteps">
            <i class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 3</h1>
        </div>
        <div class="progressSteps">
            <i class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 4</h1>
        </div>
    </div>

    <form id='seasonForm' action="new_season.php" method="post" style="position: absolute; width:80%; left: 20%;">
        <h1 style="text-align:center;">Create New Season</h1>
        <h3>Step 1: Season Info</h3>
        <div id="step1" class="step">
            <label>Season Name</label>
            <input class="form-control" type="text" name="season_name"><br>
            <div style="display:flex; justify-content: space-between;">
                <div style="display:flex; flex-direction: column">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="start_date"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>End Date</label>
                    <input class="form-control" type="date" name="end_date"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>Playoff Date</label>
                    <input class="form-control" type="date" name="playoff_date"><br>
                </div>
            </div>
            <label>Season Info</label>
            <textarea class="form-control" id=""></textarea>
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
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th>Nickname</th>
                        <th>Not Playing</th>
                        <th>Playing</th>
                    </tr>
                </thead>
                <?php
                $rows = '';
                foreach($admins as $admin) {
                    $rows .= '<tr>'
                           . '<td>' . $admin->getNickname() . '</td>'
                           . '<td><div class="form-check">'
                           . '<input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">'
                           . '</div></td>'
                           . '<td><div class="form-check">'
                           . '<input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">'
                           . '</div></td>'
                           . '</tr>';
                }
                echo $rows;
                ?>
            </table>
        </div>

        <h3>Step 4: Choose Captains</h3>
        <div id="step4" class="step">
            Please complete Step 3 first
        </div>

        <button type="submit" class="btn btn-secondary" style="    margin: 50px;position: relative;left: 25%;width: 40%;padding: 30px; font-size: 24px;">Create Season</button>
    </form>
<!--</div>-->

<?php include_once 'footer.php'; ?>
