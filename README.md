## Description
This project lets users upload projects consisting of html, css, javascript and images. These are then hosted on the server and can be viewed  by other users. It has currently only been tested on a linux debian machine.
## Download
You can download this project as a zip file by pressing the green button that says "Code" and then clicking "Download ZIP".

You can also download it with git by running "git clone https://github.com/joipoi/upload.git"

## Todo/Problems
Currently it is a pain to get this up and running on your own machine. I think I could fix this but I have not yet, here is what i think you need to do:
- Set correct permissions and owners for all the files in the project. This is because we are creating and deleting files and it might not work if you do not have the right permissions.
- Download php modules php-mysql, php-zip
- Since this project uses apache you need to fix some settings in apache. Make sure you have the document root in the right place and also you need Enviroment Variables since I use that in the code.
- This project uses a mysql database and you would need to set that up to match what I have, I should have a sql dump here to make it easier.

## Files

### Can be accessed/has html

- index.php: This file is where the user can upload projects to the server
- login.php: This file is where the user can login if they have an account
- register.php: This filer is where the user can Register a new account
- projects.php: This file is where all the projects on the server are displayed
- project_view.php: This file is where you can see a specific project
- file_list.php: This file is where you can see a list of all the files in a project
- upload.php: This file handles the request from the user to upload their project
- edit_file.php: This file handles editing a file in a project


### Only for handling post requests

- delete_file.php: this file handles deleting a file
- delete_project.php: This file handles deleting an entire project
- logout.php: This file handles a request to logout
- download_project.php: This file handles a request to download a project

## Good to know

### PHP Sessions
This project uses php session which is what keeps track of who you are logged in as and what you are allowed to do

### Post Requests
This project uses post requests for several things like, login, logout, register, delete file, edit file, delete project.

### Guest
To upload projects you have to create a user and login. if you dont want to do this, you can instead
upload a guest. This works but then anyone can edit/delete your project.
