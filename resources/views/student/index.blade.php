<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	[! Html::style('style/reset.css') !]
	[! Html::style('style/style.css') !]
</head>
<body class="is-login">
	<div id="header">
		<div class="header-top">
			<div id="header-logo"></div>
		</div>
		<div id="boad-wrap" class="boad-wrap welcome">
			<div id="boad-nav">
				<a href="[! route('mem.news') !]">系統公告</a>
				<a href="[! route('mem.exam') !]">學習</a>
				<a href="[! route('mem.achievement') !]">成果查詢</a>
				<a href="[! route('mem.logout') !]">登出</a>
			</div>
			<div class="boad-welcome-wrap">
				<p>歡迎光臨！</p>
				<p>您是<span class="txt-yellow">[! $user_data['uname'] !] </span>，身份：[! (isset($all_level[$user_data['access_level']]))?$all_level[$user_data['access_level']]:'' !]</p>
				<p>[! $user_data['school_title'] !]</p>
			</div>
			<div class="img-chalk"></div>
		</div>
	</div>
</body>
</html>