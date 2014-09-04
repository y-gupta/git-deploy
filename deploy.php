<?php
date_default_timezone_set('Asia/Calcutta');
set_time_limit(0);
ignore_user_abort(1);
if(@$_GET['key']!='mysecurekey')
 return;
$repo=urlencode(@$_REQUEST['repo']);
$user=urlencode(@$_REQUEST['user']);
$pass=urlencode(@$_REQUEST['pass']);
// decompress from gz
$data=json_decode(file_get_contents("http://sample-server.with/git/and/shell/access/deploy_zip.php?key=$_GET[key]&pass=$pass&user=$user&repo=$repo"),1);
echo $data['output'];
copy($data['url'],'deploy.tar.gz');
$p = new PharData('deploy.tar.gz');
$p->decompress(); // creates /path/to/my.tar
$phar = new PharData('deploy.tar');
$phar->extractTo('.',null,true);
unlink('deploy.tar.gz');
unlink('deploy.tar');
file_put_contents('deploy.log',"deployed on ".date('d/m/Y h:i:s a').PHP_EOL,FILE_APPEND);
