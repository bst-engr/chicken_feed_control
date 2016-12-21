<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h3>Dear {{$doctor_id}},</h3>
		<p>A new Flock Has been assigned to you to take care of that. following are the details you may require.</br></br>
		</p>
		<p>
			
			<p><label>Flock Id<strong> {{$display_id }}</strong></label><br /></p>
			<p><label>No of Birds<strong>{{$batch_size}}</strong></label></p>
			<p><label>Breed Name is <strong>{{$breed_name}}</strong></label></p>
			<p><label>Located to Sheed no. <strong>{{$shed_no}}</strong></label></p>
		</p>
		<p>Please contact your supervisor for any query.</p>
		<p>
			<h4>Thanks,</h4>
			<strong>Admin Roomi Foods</strong>
		</p>
	</body>
</html>