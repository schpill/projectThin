<?php
return '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css" />
<title>Oops, 404 Not Found</title>
</head><body bgcolor="#58989a">
<center>
<h1 style="margin-top: 60px;"><img src="' . URLSITE . 'assets/img/404.png" /></h1>
<p style="font-size: 22px; font-family: Ubuntu; width: 50%; color: white; font-weight: bold">The requested URL <br /><br /><span style="padding: 8px; border: solid 2px white;">' . trim(URLSITE, '/') . $_SERVER['REQUEST_URI'] . '</span><br /><br />was not found on this server.</p>
</body></html>';
