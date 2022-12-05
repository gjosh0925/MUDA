What this project is:<br>

This project is basically a website for the Memphis Ultimate Disc Association. It is designed to be a multipurpose website for the organization to use in conjunction with setting up their games.<br>
These functions, currently,  include:<br>
Creating a new season so an Admin can:<br>
import player data<br>
set the season dates<br>
create captains and include whether or not they are playing within the season<br>
Announce anything using the season info<br>
Being able to draft players, using the draft page (auto refreshes after 10 seconds, on actual server)<br>
Settings page:<br>
Edit schedule (also adding scores)<br>
Editing draft order, which will fix in real time<br>
Editing season information<br>
Being able to see which team a player is on through the teams page<br>
Seeing player information (being a captain or higher) and being able to edit those (being a league coordinator or higher)<br>
Also being able to mark if players have received their jersey and paid<br>
Able to see the season name, dates, and schedule with the index page<br>
Teams page displays:<br>
Players for that team<br>
Team captain<br>
Schedule specifically for that team<br><br>


Items Required/Installation:<br><br>

Any sort of IDE that uses PHP (PHPStorm HIGHLY recommended, since most of the code is in PHP, but any IDE with PHP is essential)<br>
XAMPP (to help run the localhost server, to see the website)<br>
MYSQL Database (For a database)<br><br>

Additionally, download this: https://drive.google.com/file/d/1VQEN_xz7q0c_8htGyNItGvYa-gu8ASiN/view?usp=sharing (these are the database tables)<br><br>

Instillation:<br>
Unzip the .zip file from the google drive above and create your own local host within MySQL Database<br>
Create a new schema and label it MUDA<br>
Import the data files provided and place it into the MUDA Schema<br>
Install Xampp and activate the MYSQL Database button<br>
Install PhpStorm or any IDE of your choosing<br>
Download the files from the Github (https://github.com/gjosh0925/MUDA) and open the file up in PHP<br>
Within the includes folder create a file called evironment.php and add this code (This is used to call the database)<br>
<?php
$config['servername'] = 'localhost';<br>
$config['username'] = 'root';<br>
$config['password'] = '';<br>
$config['dbName'] = 'muda';<br>


$config['system_path'] = "(File path to the MUDA folder)";<br>
$config['system_url'] = "http://localhost:63342/MUDA/";<br>
$config['portnum'] = '3306';<br>
Within the js folder create a file called environment.js add this code (Used to make asynchronous calls)<br>
var MainSiteURL = "http://localhost:63342/MUDA/";<br>
var SiteURL = MainSiteURL + 'includes/async.php';<br>
Within the XAMPP file folder (if you chose the default path, it should be in your c: drive) open the php folder and go to the php.ini file<br>
Find max_input_vars and change the max amount to 8000 and delete the semicolon on the front (if it’s there, it comments out the line)<br>
Save the document afterwards<br>
Run the index file which should take you to the home page. After that you are done. <br>
You will have to make new logins for both, captains, league coordinators, and admins<br>
Captain passwords are automatically set to “MUDACaptain!”<br><br>


BUGS:<br><br>

These bugs are fixed after putting the code onto an actual server (Most bugs were fixed due to this)<br>
Can’t return to the website after a 502 error page without restarting phpstorm<br>
New Season does not function after 3rd refresh of the page<br>
bug where if you update player’s data, player page table breaks, fixes on reload (may take several tries) <br>
502 error occurs if you are on the draft page when there is no data loaded in and instead of refreshing, you go to a different page. You will then be stuck on a loading screen if you try to change the url or refresh the page.<br>
The code itself works effectively and we have not encountered any bugs but there is a possibility that there are several ones that we have missed<br>
If you do put the website onto a server, UofM wifi will not let you access it (could only be server we used but hotspot can be used during class to be able to access it)<br><br>


FUTURE IMPLEMENTATIONS:<br><br>

A working tournament scheduling generator that will display the games onto the index page after it creates the games for the first week<br>
Which will also update once a team has won to move that team into the next bracket with the opposing winning team<br>
Consider making a losers bracket (Ask sponsor about it)<br>
A raffle generator<br>
Better sorting options within the draft page (multiple sort categories to identify what type of specific player a captain wants)<br>
A search function that can comb through the player names to find the exact person they want<br>
Adding pictures to the season details<br>
Editing team name after teams have been created<br>
Ability to be able to pay through the website and being able to automatically check that person off after they have paid (maybe by referencing the email?)<br>
Add an option for players to pay their dues with links to paypal, venmo, etc.<br>
Making the player page to where it only displays the players for that specific captain<br>
If that is not possible, resort to making a search function<br>
Any functionality that can improve something already created<br>
Adding a favorite button to the draft page<br>
Have a template csv file for uploading the players into the new season<br>
Send out emails when the captains are chose for them to create a password<br>
Add an option to add a new player to the database<br>
Make finding errors in the csv upload easier to find by adding an alert icon to the top of the row<br>
Change how the schedule is displayed<br>
Remove "Your team" box for admin's and replace with something else, maybe draft order, since admin's do not have a team but could still want to regulate the draft<br>
Make the website more mobile friendly <br>
Have a new page that shows the stats of past seasons<br>
Add a playoff bracket generator that can be filled in with who won each game<br>
Add an option for randomly choosing the spirit player<br>
Go through all of the options on different browsers and make sure everything is working as expected (not a future implementation but something to consider)<br>
Change how a user edits the draft order (drag and drop)<br>

