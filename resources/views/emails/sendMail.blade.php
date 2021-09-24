<!DOCTYPE html>
<html lang="en">
	<title>辰光閣文庫</title>
</head>
<body>
	<div class="mail-container" style="color: black">
		<div class="mail-header" style="color: black">
			<h1 style="text-align: center; color: white; background-color: #7d8886">{{ $details['title'] }}</h1>
			<p>Hello {{ $details['name'] }},</p>
			<p>{{ $details['body'] }}</p>
		</div>
		<div class="mail-activity" style="margin: 0 auto; background-color: #f6f6f6; width: 600px; padding: 10px; border-radius: 20px; color: black">
			<h2 style="text-align: center">Account Activity</h2>
			<h3>IP: {{ $details['ip'] }}</h3>
			<h3>Login Time: HK Time {{ $details['currentTime'] }}</h3>
			<h3>Country: {{ $details['countryName'] }}</h3>
			<h3>Region: {{ $details['regionName'] }}</h3>
		</div>
		<div class="mail-close" style="line-height: .4">
			<p class="member" style="font-weight: bold">{{ $details['member'] }}</p>
			<p class="team">{{ $details['team'] }}</p>
		</div>
	</div>
</body>
</html>