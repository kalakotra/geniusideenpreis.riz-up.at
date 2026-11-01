<!DOCTYPE html>
<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Seeyou - www.seeyou.at
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->

<html lang="$ContentLocale">
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	$MetaTags(false)

	<link rel="icon" type="image/png" href="/favicon-96x96.png?v=20260511" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/favicon.svg?v=20260511" />
	<link rel="shortcut icon" href="/favicon.ico?v=20260511" />
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=20260511" />
	<meta name="apple-mobile-web-app-title" content="RIZ-UP" />
	<link rel="manifest" href="/site.webmanifest?v=20260511" />

</head>
<body class="$ClassName.ShortName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>
<% include Navigation %>

<div class="pt-3 pb-3">
	$Layout 
</div>

<% include Footer %>

<!-- Optional JavaScript -->

</body>
</html>