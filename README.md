needforspeed-roadtodeleon
=========================

ENVIRONMENTS
------------
Dev: Automatic update when Master branch is pushed in GitHub
PUBLIC URL: http://nfs-stage.azurewebsites.net/

Production: Manual FTP Deployment:
publishUrl="ftp://waws-prod-bay-001.ftp.azurewebsites.windows.net/site/wwwroot" ftpPassiveMode="True"
userName="nfs-prod\$nfs-prod" userPWD="mEuZ5KnlC5jR9wHunW7Kv40i9wcw2itmki4AEwYCCQ89sRN0n3HTZvnpHqHg"
PUBLIC URL: http://nfs-prod.azurewebsites.net/


DATABASE SETUP
--------------
Development/Staging:
name: nfs-mysql-development
ConnectionString: Database=nfs-mysql-development;Data Source=us-cdbr-azure-west-b.cleardb.com;User Id=b2bda428647173;Password=a5a96527
Connection URL: mysql://b2bda428647173:a5a96527@us-cdbr-azure-west-b.cleardb.com/nfs-mysql-development

Production:
name: nfs-mysql-production
ConnectionString: Database=nfs-mysql-production;Data Source=us-cdbr-azure-west-b.cleardb.com;User Id=bd1df8fd21927e;Password=b704edca
Connection URL: mysql://bd1df8fd21927e:b704edca@us-cdbr-azure-west-b.cleardb.com/nfs-mysql-production

PROJECT SETUP
-------------
* Download project into local folder
* Open terminal and run "sudo vi /etc/hosts" on your local machine
* Press "i" to modify file
* Once in insert mode, add a new line: "127.0.0.1       needforspeed.local"
* press "esc" then type ":wq"... this will save the file edits.
* close terminal
* modify your local apache settings in your httpd.conf file similar to:

```
	<VirtualHost *:80>
		ServerName needforspeed.local
		ServerAlias needforspeed.local
		DocumentRoot /Users/reesretuta/Sites/needforspeed-roadtodeleon/needforspeed-roadtodeleon
	</VirtualHost>
```

* restart MAMP or apache
* hit needforspeed.local in your preferred browser


API ENDPOINTS
-------------


```
POST /api/activity/texttrivia
```
required params:
* aid (activity id)
* a1 (answer: a,b,c,d)
* a2 (answer: a,b,c,d)
* a3 (answer: a,b,c,d)

```
example response:
{
  "answer" : [
    "b",
    "b",
    "b"
  ],
  "earned" : 2000,
  "correct_count" : 1
}
```



```
POST /api/activity/phototrivia
```
required params:
* aid (activity id)
* a (answer: a,b,c,d)

```
POST /api/activity/youtube
```
* required params:
* aid (activity id)
* platform (twitter, tumblr, facebook)
```
response:
true | false
```



```
POST /api/activity/follow
```
required params:
* aid (activity id)
* activity_type (facebook, twitter, tumblr)
```
response:
true | false
```



```
POST /api/activity/checkin
```
required params:
* aid (activity id)
* platform (twitter, instagram)
* username (twitter username, instagram username)


```
POST /api/car/model
```
required params:
* carmodel (1) ...0 based index. phase1 models are: 0-3, phase2 models are 4-5


```
POST /api/car/customize
```
required params:
* mods ("456123") 6 digits