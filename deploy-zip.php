<?php
ob_start();
?><pre><?php
var_dump($_REQUEST);
echo "</pre><br><br>";
if(@$_REQUEST['key']!='mysecurekey')
	exit;
$repo=@$_REQUEST['repo'];
$user=@$_REQUEST['user'];
$pass=@$_REQUEST['pass'];
if(!$repo)
	return;
if($user&&$pass)
	$user=$user.':'.$pass;
if($user)
	$repo=$user.'@'.$repo;
$repo='http://'.$repo;
$hash=md5($repo);
echo $hash."<br>";
$tmp_dir=md5(microtime());
$commands = array(
	'echo $PWD; ls; whoami',
	'rm '.$hash.'.tar.gz',
	'rm -rf '.$tmp_dir,
	'git clone --depth 1 --recursive -v '.$repo.' '.$tmp_dir.' 2>&1',
	'cd '.$tmp_dir,
	'echo $PWD',
	'git submodule foreach rm -rf .git*',
	'rm -rf .git*',
	'tar -zcf ../'.$hash.'.tar.gz ./',
	'cd ..',
	'gzip -l '.$hash.'.tar.gz',
	'rm -rf '.$tmp_dir
);
$commands=implode('; ',$commands);
$tmp = shell_exec($commands);
// Output
echo "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$commands}\n</span>\n<pre>";
echo htmlentities($tmp)."</pre>\n";
$out=ob_get_clean();
echo json_encode(array('url'=>"http://$_SERVER[HTTP_HOST]/".rtrim(dirname($_SERVER['SCRIPT_NAME']),'/')."/$hash.tar.gz",
	'output'=>$out));