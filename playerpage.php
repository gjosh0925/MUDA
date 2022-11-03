<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$users = new user();
$users = $users->FindAllByParams($params);

?>

<script>

    function getUserInfo(elem){
        let id = $(elem).parent().parent().attr('ID');
        var datapacket = {
            TODO: 'getUserInfo',
            UserID: id
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
                    console.log(reply);
                    $('#userID').html(reply.userInfo.UserID);
                    $('input[name=user_nickname]').val(reply.userInfo.Nickname);
                    $('input[name=user_email]').val(reply.userInfo.Email);
                    $('input[name=user_phone]').val(reply.userInfo.Phone);
                    $('input[name=user_gender]').val(reply.userInfo.Gender);
                    $('input[name=user_dob]').val(reply.userInfo.DOB);
                    $('#user_userrole').val(reply.userInfo.UserRole);
                    $('input[name=user_jersey]').val(reply.userInfo.Jersey);
                    $('input[name=user_absences]').val(reply.userInfo.Absences);
                    $('input[name=user_playoffs]').val(reply.userInfo.Playoffs);
                    $('input[name=user_buddy]').val(reply.userInfo.Buddy);
                    $('input[name=user_throwing]').val(reply.userInfo.Throwing);
                    $('input[name=user_cutting]').val(reply.userInfo.Cutting);
                    $('input[name=user_speed]').val(reply.userInfo.Speed);
                    $('input[name=user_conditioning]').val(reply.userInfo.Conditioning);
                    $('input[name=user_experience]').val(reply.userInfo.Experience);
                    $('input[name=user_height]').val(reply.userInfo.Height);
                    $('#user_comments').val(reply.userInfo.Comment);


                    $('#editUserInfo').modal('show');
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function updateUserInfo(){
        var datapacket = {
            TODO: 'updateUserInfo',
            UserID: $('#userID').html(),
            Nickname: $('input[name=user_nickname]').val(),
            Email: $('input[name=user_email]').val(),
            Phone: $('input[name=user_phone]').val(),
            Gender: $('input[name=user_gender]').val(),
            DOB: $('input[name=user_dob]').val(),
            UserRole: $('#user_userrole').val(),
            Jersey: $('input[name=user_jersey]').val(),
            Absences: $('input[name=user_absences]').val(),
            Playoffs: $('input[name=user_playoffs]').val(),
            Buddy: $('input[name=user_buddy]').val(),
            Throwing: $('input[name=user_throwing]').val(),
            Cutting: $('input[name=user_cutting]').val(),
            Speed: $('input[name=user_speed]').val(),
            Conditioning: $('input[name=user_conditioning]').val(),
            Experience: $('input[name=user_experience]').val(),
            Height: $('input[name=user_height]').val(),
            Comments: $('#user_comments').val()
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
                    $('#editUserInfo').modal('hide');
                    window.location = 'playerpage.php';
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function userPaidStatus(elem){
        let paid = '';
        if (elem.is(':checked')) {
            paid = '1';
        } else {
            paid = '0';
        }
        let id = $(elem).parent().parent().parent().attr('id');

        var datapacket = {
            TODO: 'userPaidStatus',
            UserID: id,
            Paid: paid
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,

        });

    }

</script>

<style>

    h1 {
        text-align: center;
    }

    td, tr {
        border: 2px solid #0c2340;
    }

    th {
        background-color: #00b2a9;
        color: #0c2340;
        cursor: pointer;
    }

    table {
        border: 3px solid #0c2340 !important;
    }

    th {
        border-bottom: 3px solid #0c2340 !important;
    }
</style>

<h1>Players</h1>

<table id='playerTable' class="table sortable" style="width: 98%; margin: 1%;">
    <thead>
        <tr>
            <th scope="col">Edit</th>
            <th scope="col">Team Name</th>
            <th scope="col">Name</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Jersey Size</th>
            <th scope="col">Received Jersey</th>
            <th scope="col">Paid</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $tbody = '';
            foreach($users as $user) {
                $team = new teams($user->getTeamID());
                $paid = '';
                $jersey = '';
                if($user->getPaid() == '1'){
                    $paid = 'checked';
                }
                echo '<tr id="' . $user->getID() . '">'
                    . '<td><button onclick="getUserInfo($(this));" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></button></td>'
                    . '<td>' . $team->getName() . '</td>'
                    . '<td>' . $user->getNickName() . '</td>'
                    . '<td>' . $user->getPhone() . '</td>'
                    . '<td>' . $user->getJersey() . '</td>'
                    . '<td><div class="form-check" style="display: flex; justify-content: center;"><input onchange="" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox" ' . $jersey . '></div></td>'
                    . '<td><div class="form-check" style="display: flex; justify-content: center;"><input onchange="userPaidStatus($(this));" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox" ' . $paid . '></div></td>'
                    . '</tr>';
            }
        ?>
    </tbody>
</table>

<div class="modal fade" id="editUserInfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; flex-wrap: wrap; justify-content: space-between; padding: 20px 50px 20px 50px;">
                <p id="userID" style="display:none;"></p>
                <div id="left_side" style="width: 45%">
                    <label>Nickname</label>
                    <input class="form-control" type="text" name="user_nickname"><br>

                    <label>Email</label>
                    <input class="form-control" type="email" name="user_email"><br>

                    <label>Phone Number</label>
                    <input class="form-control" type="text" name="user_phone"><br>

                    <label>Gender</label>
                    <input class="form-control" type="text" name="user_gender"><br>

                    <label>Date of Birth</label>
                    <input class="form-control" type="text" name="user_dob"><br>
                </div>


                <div id="right_side" style="width: 45%">
                    <label>User Role</label>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="user_userrole">
                            <option value="player" selected>Player</option>
                            <option value="captain">Captain</option>
                            <option value="adminPlaying">League Coordinator Player</option>
                            <option value="adminCaptain">League Coordinator Captain</option>
                            <option value="admin">League Coordinator</option>
                        </select>
                    </div>

                    <label>Jersey</label>
                    <input class="form-control" type="text" name="user_jersey"><br>

                    <label>Absences</label>
                    <input class="form-control" type="number" name="user_absences"><br>

                    <label>Attending Playoffs</label>
                    <input class="form-control" type="text" name="user_playoffs"><br>

                    <label>Buddy</label>
                    <input class="form-control" type="text" name="user_buddy"><br>
                </div>

<!--                <div class="row">-->
<!--                    <div style="display:flex; width: 100%;">-->
<!--                        <label>Received Jersey</label>-->
<!--                        <div class="form-check"><input onchange="" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox"></div>-->
<!--                    </div>-->
<!---->
<!--                    <div style="display:flex; width: 100%;">-->
<!--                        <label>Paid Fees</label>-->
<!--                        <div class="form-check"><input onchange="" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox"></div>-->
<!--                    </div>-->
<!---->
<!--                    <div style="display:flex; width: 100%;">-->
<!--                        <label>Signed Waiver</label>-->
<!--                        <div class="form-check"><input onchange="" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox"></div>-->
<!--                    </div>-->
<!--                </div>-->

                <div style="display:flex; gap: 15px;">
                    <div>
                        <label>Throwing</label>
                        <input class="form-control" type="number" name="user_throwing" min="1" max="5"><br>
                    </div>

                    <div>
                        <label>Cutting</label>
                        <input class="form-control" type="number" name="user_cutting" min="1" max="5"><br>
                    </div>

                    <div>
                        <label>Speed</label>
                        <input class="form-control" type="number" name="user_speed" min="1" max="5"><br>
                    </div>

                    <div>
                        <label>Conditioning</label>
                        <input class="form-control" type="number" name="user_conditioning" min="1" max="5"><br>
                    </div>

                    <div>
                        <label>Experience</label>
                        <input class="form-control" type="number" name="user_experience" min="1" max="5"><br>
                    </div>

                    <div>
                        <label>Height</label>
                        <input class="form-control" type="text" name="user_height"><br>
                    </div>
                </div>

<!--                <label>Verified</label>-->
<!--                <input class="form-control" type="text" name="user_buddy"><br>-->

                <label>Comments</label>
                <textarea class="form-control" id="user_comments" name="user_comments"></textarea>


            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="updateUserInfoButton" type="button" class="btn btn-primary" onclick="updateUserInfo();">Update</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
