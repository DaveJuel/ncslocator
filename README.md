# README #

This file is to instruct you installing and successfully running odelima.

### What is this repository for? ###

* odelima is an app to help you localize the nearest and cheapest service near you and have it delivered where you are.
* Version 0.0.1 beta

### INSTALLATION PREREQUISITES ###

* Apache2 installed
* PHP 5.7 or greater installed
* Mysql

### CONFIGURATION DETAILS ###
After cloning this project to your desired directory[Windows: C:~/xampp/htdocs , Linux: /var/www/html], you need to do the following.  
  
* Configure the database  
-> In DB management app (eg:phpmyadmin, workbench,...), create a database.   
-> Import the database(smellit.sql) from odelima root folder, to your newly created database.  
-> Go into ~/addax/admin/includes and open file 'config.php' change your local connection values respective to your settings.
-> Change to database connection respective to your mysql configurations on line 9.  

* Run the application  
After finishing the steps above, you will need to run the app on your local machine.  
-> Go into your browser and type _localhost/odelima_.  
-> If all was done successfully, you will find a login page.   
-> Use admin as username and test as password.  
  
There you go, every thing done well.  
### Contribution guidelines ###  
  
* Writing tests  
* Code review  
* Other guidelines  
* Investment  
  
### Who do I talk to? ###  
In case you need help!  
  
* David NIWEWE[phone:+250788353869 , email:davejuelz@gmail.com ]