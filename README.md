### Continuous integration from your git repo to deployment server.

## Usage

- put deploy-zip.php on a server with shell access in php (basically safe_mode off) and git installed. Make sure that www-data (or whatever user runs your server) has write access to the directory containing deploy-zip.php
- put deploy.php in the root of your application. Again, make sure that www-data has write access to your app's root.
- Create a git-post-receive hook that sends a HTTP request to deploy.php on your application. Note that it needs some parameters in the query string, as explained below.

## Parameters for deploy.php

`http://<url-to-app-root>/deploy.php?key=<key>&repo=<repo>&user=<user-name for private repo>&pass=<password-for-private-repo>`

- The *\<key\>* has to be updated in `deploy-zip.php` and `deploy.php`. Default is `mysecurekey`
- *\<repo\>* has to be of form *<domain>/<path-to-repo>*. Please omit `http://` part of it. If you need to use `https://` or `git://`, edit `deploy-zip.php`