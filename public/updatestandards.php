<?php 
$con = mysql_connect("localhost",'root',"") or die(mysql_error());
mysql_select_db("roomifarms", $con);

$query ="select * from bookstandards";

$rs = mysql_query($query);
while($row = mysql_fetch_array($rs)){
	echo "update dailyfeeding set standard_value='".$row['feed']."' where field_name='feed_per_bird' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['wind_velocity']."' where field_name='wind_velocity' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";

	echo "update dailyfeeding set standard_value='".$row['egg_weight']."' where field_name='feed_egg_weight' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";

	echo "update dailyfeeding set standard_value='".$row['egg_production']."' where field_name='feed_egg_production' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";

	echo "update dailyfeeding set standard_value='".$row['water_consumption']."' where field_name='feed_water_consumption' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";

	echo "update dailyfeeding set standard_value='".$row['temprature']."' where field_name='feed_temprature' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";

	echo "update dailyfeeding set standard_value='".$row['humidity']."' where field_name='feed_humidity' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['mortality']."' where field_name='feed_mortality' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['body_weight']."' where field_name='body_weight' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['uniformity']."' where field_name='uniformity' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['manure_removal']."' where field_name='manure_removal' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
	echo "update dailyfeeding set standard_value='".$row['light_intensity']."' where field_name='light_intensity' and bird_age_week='".$row['week']."' and entry_date<='2016-04-30';<br/>";
}
?>