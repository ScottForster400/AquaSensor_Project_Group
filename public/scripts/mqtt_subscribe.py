#!/usr/bin/env python3
import paho.mqtt.client as mqtt
import time
import pymysql
import random

def on_message(client, userdata, message):
    print("Recieved message: ", str(message.payload.decode("utf-8")))
    # gets topic and message of MQTT
    topic = str(message.topic)
    data = str(message.payload.decode("utf-8"))

    splitdata = data.split(',')
    mgl_dissolved_oxygen = splitdata[6]
    mgl_dissolved_oxygen_trun = mgl_dissolved_oxygen[:-1]
    print(mgl_dissolved_oxygen_trun)
    #Checks if topic already has an entry in the database
    querylocate = (f'SELECT * FROM `sensor__data` WHERE `sensor_id` = "{topic[7:]}"')
    cursor.execute(querylocate)
    rows= cursor.fetchall()
    print('search complete')

    #updates current entry with current data if already has entry
    if len(rows)>0:
        queryupdate=(f'UPDATE `sensor__data` SET `sensor_data_date`="{splitdata[0]}",`sensor_data_time`="{splitdata[1]}",`packet_counter`="{splitdata[3]}",`temperature`="{splitdata[4]}",`%dissolved_oxygen`="{splitdata[5]}",`mgl_dissolved_oxygen`="{mgl_dissolved_oxygen_trun}" WHERE `sensor_id` = "{topic[7:]}" ')
        print(queryupdate)
        cursor.execute(queryupdate)
        print("upadted")

    #creates a new entry for sensor data
    else:
        queryadd= (f'INSERT INTO `sensor__data`(`sensor_name`, `sensor_id`, `sensor_data_date`, `sensor_data_time`, `packet_counter`, `temperature`, `%dissolved_oxygen`, `mgl_dissolved_oxygen`) VALUES ("{topic[7:]}","{topic[7:]}","{splitdata[0]}","{splitdata[1]}","{splitdata[3]}","{splitdata[4]}","{splitdata[5]}","{mgl_dissolved_oxygen_trun}")')
        #queryadd = (f'INSERT INTO `sensor__data`(`sensor_name`,`data`) VALUES ("{topic[7:]}","{data}")')
        print(queryadd)
        cursor.execute(queryadd)
        print("added")

    #commits changes
    connection.commit()

# try:
connection = pymysql.connect(host='aquasensordb.mysql.database.azure.com',user='aquaad4276',password='Minklover456',database='aquasensordb',ssl={"fake_flag_to_enable_tls":True})
print("database connected..")
cursor = connection.cursor()
clientNum = random.randint(10000,99999)
mqttBroker = "excalibur.ioetec.com"
portnum = int(1833)
client = mqtt.Client(str(clientNum))
client.connect(mqttBroker)
print("MQTT connection established")
#Maintains constant connection to MQTT
while(True):

    client.loop_start()
    client.subscribe("sensor/#")
    client.on_message = on_message
    time.sleep(30)
# except:
print("ERROR: MQTT failed to connect")
input("abdjk");


