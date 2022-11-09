<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$users = new user();
$users = $users->FindAllByParams($params);

?>

<script>

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
            <th scope="col" style="width:14%">Name</th>
            <th scope="col" style="width:9%">Phone Number</th>
            <th scope="col" style="width:9%">Email</th>
            <th scope="col" style="width:9%">Gender</th>
            <th scope="col" style="width:9%">Height</th>
            <th scope="col" style="width:9%">Date of Birth</th>
            <th scope="col" style="width:10%">Jersey</th>
            <!-- Place a checkbox/button here -->
            <th scope="col" style="width:9%">Have They Paid</th>
            <!-- Place a checkbox/button here -->
            <th scope="col" style="width:14%">Absences</th>
            <th scope="col" style="width:9%">Playoffs</th>
            <th scope="col" style="width:9%">Buddy</th>
            <th scope="col" style="width:9%">User Role</th>
            <th scope="col" style="width:8%">Waiver Agreement</th>
            <th scope="col" style="width:8%">Conditions/Illness/Injuries</th>
            <th scope="col" style="width:8%">Throwing</th>
            <th scope="col" style="width:8%">Cutting</th>
            <th scope="col" style="width:8%">Speed</th>
            <th scope="col" style="width:8%">Conditioning</th>
            <th scope="col" style="width:8%">Experience</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $tbody = '';
            foreach($users as $user) {
                $paid = '';
                if($user->getPaid() == '1'){
                    $paid = 'checked';
                }

                $tbody .= '<tr id="' . $user->getID() . '">'
                    . '<td>' . $user->getNickName() . '</td>'
                    . '<td>' . $user->getPhone() . '</td>'
                    . '<td>' . $user->getEmail() . '</td>'
                    . '<td>' . $user->getGender() . '</td>'
                    . '<td>' . $user->getHeight() . '</td>'
                    . '<td>' . $user->getDOB() . '</td>'
                    . '<td>' . $user->getJersey() . '</td>'
                    . '<td><div class="form-check" style="display: flex; justify-content: center;"><input onchange="userPaidStatus($(this));" class="form-check-input" style="width: 20px; height: 20px;" type="checkbox" ' . $paid . '></div></td>'
                    . '<td>' . $user->getAbsence() . '</td>'
                    . '<td>' . $user->getPlayoffs() . '</td>'
                    . '<td>' . $user->getBuddy() . '</td>'
                    . '<td>' . $user->getUserRole() . '</td>'
                    . '<td>' . $user->getVerified() . '</td>'
                    . '<td>' . $user->getComments() . '</td>'
                    . '<td>' . $user->getThrowing() . '</td>'
                    . '<td>' . $user->getCutting() . '</td>'
                    . '<td>' . $user->getSpeed() . '</td>'
                    . '<td>' . $user->getConditioning() . '</td>'
                    . '<td>' . $user->getExperience() . '</td>'
                    . '</tr>';
            }
            echo $tbody;
        ?>
    </tbody>
</table>
