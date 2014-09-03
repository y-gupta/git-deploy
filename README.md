### Continuous integration from your git repo to deployment server.

## Usage

- put deploy-zip.php on a server with shell access in php (basically safe_mode off) and git installed. Make sure that www-data (or whatever user runs your server) has write access to the directory containing deploy-zip.php
- put deploy.php in the root of your application. Again, make sure that www-data has write access to your app's root.
- Create a git-post-receive hook that sends a HTTP request to deploy.php on your application. Note that it needs some parameters in the query string, as explained below. On bitbucket, it is called POST and on github it is called web-hook.
- deploy.php uses phar for decompression of the tar.gz. Make sure it is available.

## Parameters for deploy.php

`http://<url-to-app-root>/deploy.php?key=<key>&repo=<repo>&user=<user-name for private repo>&pass=<password-for-private-repo>`

- The *\<key\>* has to be updated in `deploy-zip.php` and `deploy.php`. Default is `mysecurekey`
- *\<repo\>* has to be of form *\<domain\>/\<path-to-repo\>*. Please omit `http://` part of it. If you need to use `https://` or `git://`, edit `deploy-zip.php`

## Important notes

- This method of continuous integration is not intended to be secure. Please remove these files if you go in production mode.
- For large projects, this might be slow, as the git repo is cloned everytime you deploy.
- The functionality is split into two files as shared hosting won't allow you with shell access or have git installed for you (most probably)
- deploy.php doesnt remove old files from the app's root dir when deploying. It simply overwrites any existing files. So if you remove some file from your repo, it won't be removed from the server (This was done because you might be using some files on the server to store data)
- Use at your own risk!!!
