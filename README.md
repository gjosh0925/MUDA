# MUDA
Step 1 - Download Php storm, Xampp, and MYSQL Workbench <br>
Step 2 - Download this file https://drive.google.com/file/d/1VQEN_xz7q0c_8htGyNItGvYa-gu8ASiN/view?usp=sharing <br>
Step 3 - Unzip the .zip file from the google drive above and create your own local host within MySQL Database <br>
Step 4 - Create a new schema and label it MUDA<br>
Step 5 - Import the data files provided and place it into the MUDA Schema<br>
Step 6 - Install Xampp and activate the MYSQL Database button<br>
Step 7 - Install PhpStorm or any IDE of your choosing<br>
Step 8 - Download the files from the Github (https://github.com/gjosh0925/MUDA) and open the file up in PHP<br>
Step 9 - Within the includes folder create a file called evironment.php and add this code (This is used to call the database)<br>
        <?php<br>
        $config['servername'] = 'localhost';<br>
        $config['username'] = 'root';<br>
        $config['password'] = '';<br>
        $config['dbName'] = 'muda';<br>
        $config['system_path'] = "(File path to the MUDA folder)";<br>
        $config['system_url'] = "http://localhost:63342/MUDA/";<br>
        $config['portnum'] = '3306';<br>
Step 10 - Within the js folder create a file called environment.js add this code (Used to make asynchronous calls)<br>
        var MainSiteURL = "http://localhost:63342/MUDA/";<br>
        var SiteURL = MainSiteURL + 'includes/async.php';<br>
Step 11 - Within the XAMPP file folder (if you chose the default path, it should be in your c: drive) open the php folder and go to the php.ini file<br>
Step 12 - Find max_input_vars and change the max amount to 8000 and delete the semicolon on the front (if it’s there, it comments out the line)<br>
Step 13 - Save the document afterwards<br>
Step 14 - Run the index file which should take you to the home page. After that you are done.<br>

