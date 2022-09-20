<?php
include_once 'header.php';
global $pageUser;


?>
<h1>Welcome<?php echo (isset($pageUser)) ? ' ' . $pageUser->getNickName() : '!'; ?></h1>
<h3>MUDA Schedule</h3>
<! This is a test comment>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Teams</th>
            <th scope="col">Date</th>
            <th scope="col">Field</th>
            <th scope="col">Score</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Spartans<br>Cobras</td>
            <td>9/25/2022<br>8:45pm</td>
            <td>4</td>
            <td>2-1</td>
        </tr>
        <tr>
            <td>Speeders<br>Alphas</td>
            <td>9/25/2022<br>8:45pm</td>
            <td>1</td>
            <td>4-5</td>
        </tr>
        <tr>
            <td>Alphas<br>Spartans</td>
            <td>9/30/2022<br>6:15pm</td>
            <td>3</td>
            <td>0-2</td>
        </tr>
    </tbody>
</table>
<?php if (!isset($pageUser)) { ?>
    <button onclick="location.href = 'login.php';">Login</button>
<?php } else { ?>
    <button onclick="location.href = 'logout.php';">Logout</button>
<?php } ?>


<?php
include_once 'footer.php';
?>
