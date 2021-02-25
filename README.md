# Motion-CCTV
Motion Recognizing CCTV System, uploads images to a webserver that can be accessed from any browser, even mobile.

# Usage
Python Script
1. Have any camera input on a device (I am using an outdoor security camera connected to a Raspberry Pi 3)
2. Have a Python 3 installation and install the requirements in requirements.txt
3. Run Main.Py and leave this running

Web Interface
1. Put the entirity of the ./web/ folder on the root of your host
2. Fill in the information in config.ini (Webhost details & DB connection details)
3. Replace the text in ./web/dbConfig.php with the DB connection details
4. Setup a table in the database named members with username and password fields
5. You will then be able to login to your site through the main URL to access image uploads.

The python script requires an active internet connection and will upload images when the camera feed detects motion to your webhost in the ./images/ folder, which live update on the website. It counts 'motion' as enough of a change between two frames at 30fps, not tested with any other fps than the 29.97fps input from my camera but it shouldnt have any problems.

# Credits
Thanks to Chris (@Whyssp) for help originally setting up the DB connection.  

Originally written as a part of a Computer Science course but expanded as I used it for personal use.

*Removed the CSS files are they are causing havoc with the way Github reads language %, will re-upload once I clean them up
