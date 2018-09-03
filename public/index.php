<?php 
/**
 * 功能最简单的软件包管理，
 * 限制IP形式访问。
 * 无数据库支持
 * 直接markdown格式。
 * 使用时，请保留作者版权信息。
 * 可用由任何用途。
 * @author : KEN <[<68103403@qq.com>]>
 */
require __DIR__.'/../vendor/autoload.php';
error_reporting( E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING );
 
$app = new Slim\App();
$config = include __DIR__.'/../config.php';
$ipallow = include __DIR__.'/../ipallow.php';
if(!in_array(ip(),$ipallow)){
	exit('IP NOT ALLOW REQUEST THIS SITE.');
}

$dir = __DIR__.'/../markdown/';
$ignore = ['.','..','.git','.svn'];
$list = scandir($dir);
foreach($list as $v){
	if(in_array($v,$ignore)){
		continue;
	} 
	if(is_file($dir.$v)){
		continue;
	}
	$out[$v]['tip']  = file_get_contents($dir.$v.'/readme.txt');
	$deep = scandir($dir.$v);

 
	foreach($deep as $v1){
		$next  = $dir.$v.'/'.$v1;
		if(in_array($v1,$ignore)  ){
			continue;
		} 
		if(!is_dir($next)){
			continue;
		}
		$out[$v]['lists'][$v1]['tip']  = file_get_contents($next.'/tip.txt');
		$out[$v]['lists'][$v1]['readme']  = file_get_contents($next.'/readme.txt');
		$out[$v]['lists'][$v1]['time']  =  date("Y-m-d H:i:s",filectime($next));
	}

}

foreach($out as $k=>$v){
	$arr = $v['lists'];
	$time = [];
	foreach($v['lists'] as $k1=>$v1){
		$time[$k1] = $v1['time'];
	}
	array_multisort($time, SORT_DESC, SORT_STRING, $arr);
	$out[$k]['lists'] = $arr;
}
 


$app->get('/', function ($request, $response, $args) use($config , $out) {
	$type = $args['type'];
	$name = $args['name']; 
    include __DIR__.'/../welcome.php';
});
$app->get('/download/{type}', function ($request, $response, $args) use($config , $out ,$dir) {
	$type = $args['type'];
	$name = $args['name']; 
	$version = $_GET['version'];
	if(!$version){

	}
    $fs = $dir.$type.'/'.$version."/".$version.'.zip';
    header("Content-type:application/zip");
	header("Accept-Ranges:bytes");
	header("Accept-Length:".filesize($fs) );
	header("Content-Disposition: attachment; filename=".$version.'.zip'); 
	$h = fopen($fs, 'r');                                                                                       //打开文件
	echo fread($h, filesize($fs));             

});
$app->get('/view/{type}', function ($request, $response, $args) use($config , $out) {
	$type = $args['type'];
	$name = $args['name']; 
	$version = $_GET['version'];
	if(!$version){
		
	}
	include __DIR__.'/../view.php'; 
     
});
$app->get('/wiki/{type}', function ($request, $response, $args) use($config , $out) {
	$type = $args['type'];
    include __DIR__.'/../list.php';
});

 
$app->run();



function ip($type = 0) {
	$type = $type ? 1 : 0;
	static $ip = null;
	if (null !== $ip) {
		return $ip[$type];
	}
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos = array_search('unknown', $arr);
		if (false !== $pos) {
			unset($arr[$pos]);
		}
		$ip = trim($arr[0]);
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$long = sprintf("%u", ip2long($ip));
	$ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}