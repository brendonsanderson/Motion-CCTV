## imports ##
import cv2
from configparser import *
from ftplib import FTP
import smtplib
import mimetypes
import random
import os
import time
import datetime
import threading
from time import sleep
import pymysql

static_back = None
motion_list = [ None, None ]

### configs ###
dbConnect = False
ftpSetup = 0
dbSetup = 0

## user defined congifuration
## all configuration only happens once on launch
config = ConfigParser()
config.read("config.ini")
cameraval = str(config.get("user", "camera"))

#FTP LOGIN
host = config.get("ftp", "host")
usern = config.get("ftp", "user")
passw = config.get("ftp", "passwd")
ftp = FTP(str(host))
ftp.login(user= str(usern), passwd = str(passw))

#SQL LOGIN
hostname = config.get("sql", "host")
username = config.get("sql", "user")
password = config.get("sql", "password")
dbname = config.get("sql", "database")
connection = pymysql.connect(hostname, username, password, dbname)
cur = connection.cursor()

## main program ##

## switch to this to use a live feed
video = cv2.VideoCapture(2)

## switch to this to use a pre-recorded video
#video = cv2.VideoCapture("L:/CS/prerec.mp4")
# limits prerecorded video fps
#video.set(cv2.CAP_PROP_FPS, 30)

def SaveToFile(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval):
    eventType = ('Motion')
    ftp.cwd("/htdocs/files/images")
    cv2.imwrite("./images/" + str(current) + ".jpg", frame)
    path_file1 = "./images/" + str(current) + ".jpg"
    base=os.path.basename(path_file1)
    motionfile = open(path_file1,'rb')
    ftp.storbinary('STOR ' + base, motionfile)
    database(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval, eventType)
    FaceDetect(path_file1, hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval)

def database(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval, eventType):
    imgname = (str(current)+".jpg")
    query = "INSERT INTO event (CamID,Time,Date,EventType,Image) VALUES ('"+str(cameraval)+"','"+str(timeVar)+"','"+str(dateVar)+"','"+str(eventType)+"','"+str(imgname)+"')"
    cur.execute(query)

def fdatabase(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval, eventType):
    imgname = ("F" + str(current)+".jpg")
    query = "INSERT INTO event (CamID,Time,Date,EventType,Image) VALUES ('"+str(cameraval)+"','"+str(timeVar)+"','"+str(dateVar)+"','"+str(eventType)+"','"+str(imgname)+"')"
    cur.execute(query)

def FaceDetect(path_file1, hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval):
    
    CASCADE="./files/Face_cascade.xml"
    FACE_CASCADE=cv2.CascadeClassifier(CASCADE)
    path = path_file1
    image=cv2.imread(path)
    image_grey=cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    faces = FACE_CASCADE.detectMultiScale(image_grey,scaleFactor=1.9,minNeighbors=5,minSize=(25,25),flags=0)

    for x,y,w,h in faces:
        eventType = ('Face')
        sub_img=image[y-10:y+h+10,x-10:x+w+10]
        fdatabase(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval, eventType)
        os.chdir("images")
        cv2.imwrite("F"+ str(current) + ".jpg",sub_img)
        path_file2 = "./images/" +"F"+ str(current) + ".jpg"
        os.chdir("../")
        cv2.rectangle(image,(x,y),(x+w,y+h),(255, 255,0),2)
        cv2.putText(image, 'Face', (x, y), cv2.FONT_HERSHEY_PLAIN, 1.5, (255, 255, 255), 2)
        facefile = open(path_file2,'rb')
        base2=os.path.basename(path_file2)
        ftp.cwd("/htdocs/files/images")
        ftp.storbinary('STOR ' + base2, facefile)

while True:
    # the while loop is created so that when the video is split into a stack of images it can still be treated as a video
    check, frame = video.read()
    motion = 0
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    gray = cv2.GaussianBlur(gray, (21, 21), 0)
    if static_back is None:
        static_back = gray
        continue
    diff_frame = cv2.absdiff(static_back, gray)
    # changing the first diff_frame sets the sensetivity
    thresh_frame = cv2.threshold(diff_frame, 25, 255, cv2.THRESH_BINARY)[1]
    thresh_frame = cv2.dilate(thresh_frame, None, iterations = 2)
    (_, cnts, _) = cv2.findContours(thresh_frame.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    for contour in cnts:
        if cv2.contourArea(contour) < 10000: # default 10000
            continue
        motion = 1

        # sets the identifier (green box)
        (x, y, w, h) = cv2.boundingRect(contour)
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
        cv2.putText(frame, 'Motion', (x, y), cv2.FONT_HERSHEY_PLAIN, 1, (0, 255, 0), 2)

    motion_list.append(motion)
    motion_list = motion_list[-2:]

    # debug views
    #cv2.imshow("Gray Frame", gray)
    #cv2.imshow("Difference Frame", diff_frame)
    #cv2.imshow("Threshold Frame", thresh_frame)

    # main motion view
    cv2.startWindowThread()
    cv2.namedWindow('Color Frame', cv2.WINDOW_NORMAL)
    cv2.resizeWindow('Color Frame', 600,480)
    cv2.imshow("Color Frame", frame)

    # stops stuttering but causes video slowdown
    key = cv2.waitKey(1) & 0xFF
    #cv2.waitKey(7)

    if motion == 1:
        time.localtime()
        seconds = time.localtime().tm_sec
        if int(seconds) % 5 == 0:
            now = datetime.datetime.now()
            # change to an easier to search format
            timeVar = now.strftime("%H:%M.%S")
            dateVar = now.strftime("%d/%m/%Y")
            current = now.strftime("%H.%M.%S-%d-%m-%Y")
            print(current)
            SaveToFile(hostname, username, password, dbname, timeVar, dateVar, dbConnect, cur, current, cameraval)
       
    # closes all windows
    if cv2.waitKey(10) & 0xFF == ord('q'):
        break

ftp.close()
video.release()
cv2.destroyAllWindows()
