<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h3>Dear,</h3>
		<?php
			$key = str_replace("feed_", "", $field_name);
			$key = str_replace("_", " ", $key);
			$key = ucfirst($key);
		?>
		<p>Entry for {{$key}} exceeded on {{$entry_date}} Following are the details</br></br>
		</p>
		<p>
			
			<p><label>Date:<strong> {{$entry_date }}</strong></label><br /></p>
			<p><label>Standard Value<strong>{{$standard_value}}</strong></label></p>
			<p><label>Recorded Value <strong>{{$field_value}}</strong></label></p>
		</p>
		<p>Please contact your supervisor for any query.</p>
		<p>
			<h4>Thanks,</h4>
			<strong>no-Reply Roomi Foods</strong><br/>
			<i>This is system generated email, contact supervisor for further assitance</i>
		</p>
	</body>
</html>