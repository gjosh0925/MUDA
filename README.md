# MUDA
Step 1 - Download Php storm, Xampp, and MYSQL Workbench
Step 2 - Download this file https://drive.google.com/file/d/1VM_tAe5S7G8uREghifV6-DMaRxBE4mjv/view?usp=sharing, and unpack it.
Step 3 - Once unzipped, create your own local host within MySQL Database; if not installed please install MYSQL
Step 4 - Create a new schema and label it MUDA
Step 5 - Import the data files provided within Step 2 and place it into the MUDA Schema
Step 6 - Install Xampp and activate the MYSQL Database button
Step 7 - Install PhpStorm and open the folder (found within the Github repo) within PhpStorm 
Step 8 - Create two files: environment.php and environment.js
  - place this within the .js file:
      var MainSiteURL = "http://localhost:63342/MUDA/";
      var SiteURL = MainSiteURL + 'includes/async.php';
  - place this within the .php file:
      <?php
        $config['servername'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = '';
        $config['dbName'] = 'muda';

        $config['system_path'] = ""; (root being the directory where the folder is found)
        $config['system_url'] = "http://localhost:63342/MUDA/www_home/";
Step 9 - Once finished, click on the index file and press the chrome pop up (the website should appear)
Step 10 - You're finished
