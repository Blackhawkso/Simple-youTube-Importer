# Simple youTube videos importer

This is a simple PHP based system to import video data from a youTube channel and stores it in a json file.

----

### How to use

It can be run from the browser just by going to the index.php file but best use case is to use cron to run the script periodically so it can be as up to date as possible.

#### Setup

Edit the config.php file and place the name of the youTube channel you wish to import the video data for and make sure that the output folder can be written to. Thats it, it's that simple to setup.

-----

### Requirements

PHP >= 5.4.*

-----

##### Please note

This is using the Google youTube api v2 which is in the process of being deprecated but I will update it when I find a nice way to hand the new v3 of the api. Also due to a restriction that Google has placed on api calls you can only import a maximum of 500 of the most recent videos from each play list.



