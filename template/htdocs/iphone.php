<?
include 'settings.php';
include 'auth.php';
login();
$user=userinfo();
?>
<html>
<head>
	<title>Antradar Gyroscope&trade; Mobile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; user-scalable=0;"/>
	<link href='iphone/gyrodemo.css' type='text/css' rel='stylesheet'>
<style>
body{font-family:helvetica;}
.menuitem{padding-left:10px;font-size:20px;height:30px;float:left;margin-right:3px;}
.menuitem a, .menuitem a:hover, .menuitem a:visited, .menuitem a:link{
	display:block;
	padding-top:3px;
	color:#000000;
	text-decoration:none;
}

</style>

</head>

<body onload="setTimeout(scrollTo, 0, 0, 1);">

<div style="height:40px;position:fixed;width:100%;z-index:1000;top:0;background-color:#efefef;opacity:0.9"></div>
<div id="toolicons" style="position:fixed;width:100%;z-index:2000;top:0;border-bottom:solid 1px #dedede;">

	<div id="toollist" style="overflow:hidden;width:300px;height:35px;"><div style="width:1000px;">
	
	<div class="menuitem"><a href=# onclick="showview(0);"><img src="imgs/bigicon1.gif" border="0"></a></div>
	<div class="menuitem"><a href=# onclick="showview(1);"><img src="imgs/bigicon2.gif" border="0"></a></div>

	</div></div>
		
	<a href="login.php?from=<?echo $_SERVER['PHP_SELF'];?>" style="position:absolute;top:10px;right:10px;"><img border="0" src="iphone/exit.png"></a>
</div><!-- toolicons -->
<div style="width:100%;height:40px;"></div>

<div id="leftview" style="float:left;width:150px;font-size:20px;margin-right:5px;">
	<div id="tooltitle" style="width:150px;position:fixed;top:40px;z-index:1000;height:25px;"></div>
	<div id="tooltitleshadow" style="width:150px;height:25px;"></div>
	<div id="lvviews">
		<div id="lv0" style="background-color:#ffffff;display:none;"></div>
		<div id="lv1" style="background-color:#ffffff;display:none;"></div>
		<div id="lv2" style="background-color:#ffffff;display:none;"></div>
		<div id="lv3" style="background-color:#ffffff;display:none;"></div>
		<div id="lv4" style="background-color:#ffffff;display:none;"></div>
		<div id="lv5" style="background-color:#ffffff;display:none;"></div>
		<div id="lv6" style="background-color:#ffffff;display:none;"></div>
	</div>
</div>
<div id="content" style="float:left;width:320px;">

	<div id="backlist" style="display:none;position:fixed;top:40px;width:320px;z-index:1000;"><a id="backlistbutton"><img onclick="navback();" src="iphone/bb.png"></a></div>
	<div id="backlistshadow" style="display:none;width:320px;height:43px;"></div>

	<div id="tabtitles" style="width:325px;position:fixed;z-index:1000;"></div>
	<div id="tabtitleshadow" style="height:25px;width:100px;display:none;"></div>

	<div id="tabviews" style=""></div>
	<div id="statusinfo" style="display:none;"></div>
</div>
<div id="rotate_indicator" style="display:none;position:fixed;width:100px;height:100px;top:220px;left:110px;z-index:3000;background-image:url(iphone/flip.png);"></div>
<div id="preloaders" style="display:none;">
	<img src="iphone/tcd.png"><img src="iphone/dt.png"><img src="iphone/hbg.png">
</div>
<script>
document.appsettings={codepage:'<?echo $codepage;?>',viewcount:<?echo $viewcount;?>};
</script>
<script src="iphone/nano.js"></script>
<script src="iphone/tabs.js"></script>
<script src="iphone/viewport.js"></script>
<script src="iphone/validators.js"></script>
<script src="autocomplete.js"></script>

<script>
function showdeck(){
	switch(document.viewmode){
		
		case 1: 
			gid('leftview').style.display='block'; 
			gid('tabtitles').style.display='block';
			
			gid('content').style.display='none';

		break;
		case 2:
			gid('leftview').style.display='none'; 
			gid('tabtitles').style.display='none';
			
			gid('content').style.display='block';
			
		break;
	}
		
}


function rotate(){

	ori=window.orientation;
	//if (ori==null) ori=0; //debug
	
	if (ori==null) ori=90;

	setTimeout(scrollTo, 0, 0, 1);
	
	switch(ori){
	case 0: //vertical 
		//gid('panel2').style.display='block';
		showdeck();
		gid('leftview').style.width='320px';
		gid('backlist').style.display='block';
		gid('backlistshadow').style.display='block';
		gid('leftview').style.fontSize='25px';
		gid('tooltitle').style.width='320px';
		gid('toollist').style.width='280px';
		gid('tabtitleshadow').style.display='none';
		
		ajxcss(self.cssloader,'iphone/portrait.css');
		document.viewheight=350;
		document.iphone_portrait=1;

		
	break;
	case 90: case -90: 
		//gid('panel2').style.display='none';
		gid('leftview').style.display='block';
		gid('leftview').style.width='150px';
		gid('leftview').style.fontSize='14px';
		gid('tabtitles').style.display='block';
		gid('content').style.display='block';
		gid('backlist').style.display='none';
		gid('backlistshadow').style.display='none';
		
		gid('tooltitle').style.width='150px';
		gid('toollist').style.width='450px';
		gid('tabtitleshadow').style.display='block';
		
		ajxcss(self.cssloader,'iphone/landscape.css');
		document.viewheight=210;

		scaleall(document.body);
		document.iphone_portrait=null;
		gid('rotate_indicator').style.display='none';
		
	break;

	}
	
	

}

function portrait_ignore(ttl){
	if (!ttl) ttl=2000;

	document.portraitlock=1;

	setTimeout(function(){document.portraitlock=null;},ttl);
}

addtab('welcome','Welcome','wk');

window.onorientationchange=rotate;
rotate();
scaleall(document.body);

</script>
</body>
</html>
