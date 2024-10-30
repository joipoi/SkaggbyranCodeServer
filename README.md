## Description
This project lets users upload projects consisting of html, css, javascript and images.
These projects are then  hosted on a raspberry pi currently at "Skäggbyrån".
## Download
You can download this project as a zip file by pressing the green button that says "Code" and then clicking "Download ZIP".

You can also download it with git by running "git clone https://github.com/joipoi/upload.git"
## Files
- index.php: This file is where the user can upload projects to the server
- login.php: This file is where the user can login if they have an account
- register.php: This filer is where the user can Register a new account
- projects.php: This file is where all the projects on the server are displayed
- project_view.php: This file is where you can see a specific project
- file_list.php: This file is where you can see a list of all the files in a project
- upload.php: This file handles the request from the user to upload their project
- delete_file.php: this file handles deleting a file
- delete_project.php: This file handles deleting an entire project
- edit_file.php: This file handles editing a file in a project
- logout.php: This file handles a request to logout
## Good to know

### PHP Sessions
This project uses php session which is what keeps track of who you are logged in as and what you are allowed to do

### Post Requests
This project uses post requests for several things like, login, logout, register, delete file, edit file, delete project.

### Guest
To upload projects you have to create a user and login. if you dont want to do this, you can instead
upload a guest. This works but then anyone can edit/delete your project.
