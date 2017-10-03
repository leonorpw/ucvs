What is UCVS?
 
You are running a private server and want to reward your users for voting on toplist sites, but only if they really voted?
Then UCVS is what you are looking for, because UCVS checks after each successful vote whether the user is entitled to recieve a reward for the vote, or not.
 
How it works:
When a user clicks a vote button on your page, your ServerID and UserID will be passed to the Toplist Site.
After the user successfully voted the Toplist site checks if the user has already voted with this IP address, if not the Toplist site sends an answer with the UserID to your UCVS installation.
UCVS then checks whether the UserID has already voted during the configured timeframe and whether there possibly is still a cooldown. If everything is okay, the user is rewarded for his vote with VotePoints or Silk (Only for Silkroad Online Servers)!
 
 
How to install:
Download the current version of UCVS, extract it and upload it to your webserver, then open http://yourdomain.com/UCVS/index.php and the installer will show up.
Fill out the form and submit. If everything works out you see now a link like: http://yourdomain.com/UCVS/ucvs_listener.php
 
Now you have to adjust your vote buttons on your page. First of all they should only be displayed when the user is logged in (this is important!) and contain his userID like shown below.
 
 
What voting pages are supported and what does the votelink look like:
 
Please note: some of these pages require you to be a premium user in order to be able to use the callback voting (Xtremetop100 for example)!
 
 - Silkroad-Servers.com:   https://silkroad-servers.com/index.php?a=in&u=SERVER_ID&id=VOTER_USERNAME_OR_ID
 - Private-Server.ws:      https://private-server.ws/index.php?a=in&u=SERVER_ID&id=VOTER_USERNAME_OR_ID
 - Arena-top100.com:       http://www.arena-top100.com/index.php?a=in&u=SERVER_ID&id=VOTER_USERNAME_OR_ID
 - gtop100.com:            http://www.gtop100.com/CATEGORY/sitedetails/testserver-91630?vote=1&pingUsername=VOTER_USERNAME_OR_ID
 - topg.org:               http://topg.org/CATEGORY/in-SERVER_ID-VOTER_USERNAME_OR_ID
 - xtremetop100.com:       http://www.xtremetop100.com/in.php?site=SERVER_ID&postback=VOTER_USERNAME_OR_ID
 - top100arena.com:        http://www.top100arena.com/in.asp?id=SERVER_ID&incentive=VOTER_USERNAME_OR_ID
 
SERVER_ID = Your Username on Toplist Sites
VOTER_USERNAME_OR_ID = User ID
 
 
Usefull Tips:
 - You have to enter your listener URL in the settings of every toplist
 - If you are installing UCVS for the first time you should turn on logging, so that you can test thoroughly. Everything that happens is then written into a log file located at /UCVS/logs/
    You can turn logging off later, by editing /UCVS/classes/userconfig.class.php
    The comments for every setting should explain everything you need to know.
 - If you want to use the Silk reward system (Silkroad Online Servers only), you should first check if you have the dbo.CGI_WebPurchaseSilk stored procedure fixed or not!
    If you didn't, you can find the query used to do so in /UCVS/fixes/CGI_WebPurchaseSilk.sql


Troubleshooting:
 - When using top100arena.com you have to append "?postback=" to your "Incentive Postback"-URL in the Server Settings.
 - If you enabled logging, but the logs arent created check the chmod of the logs folder, it should be at 644. If that didnt help check if the logs folder belongs to the correct user (chown).
 
 
FAQ:
 - MSSQL or MySQL, how does UCVS decide which one to use?
    Answer: UCVS can deal with both MS SQL Server and MySQL databases and will work with the appropriate class depending on what has been selected. For MySQL databases it will use the PHP5 and PHP7 compliant mysqli extension, for MS SQL Server it will either use the PHP5 and PHP7 compliant sqlsrv extension or the deprecated mssql extension, depending on wich one is installed on your webserver.
