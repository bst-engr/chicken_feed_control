<?php
$con = mysql_connect("localhost",'root',"") or die(mysql_error());
mysql_select_db("roomifarms", $con);

$query= "select * from dailyfeeding where field_name='feed_mortality' and flock_id=8";
//$rs =mysql_query("select * from dailyfeeding where feed_name='feed_mortality'") or die(mysql_error());
$rs = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($rs)){
  $sumQuery = "select sum(field_value) as sum from dailyfeeding where  field_name='feed_mortality' and  entry_date < '".$row['entry_date']."' and flock_id='".$row['flock_id']."'";
  $sumRes = mysql_query($sumQuery) or die(mysql_error());;
  $sumRow = mysql_fetch_array($sumRes);

  $standardQ = "select * from flock_standards where flock_id=8 and week='".$row['bird_age_week']."'";
  $resQ = mysql_query($standardQ) or die(mysql_error());
  $standrRow = mysql_fetch_array($resQ);


  $flockQuery = "select * from flocks where flock_id='".$row['flock_id']."'";
  $flockRes = mysql_query($flockQuery) or die(mysql_error());;
  $flockRow = mysql_fetch_array($flockRes);  
  // echo ">>>>".$row['standard_value']/7;
  // echo ">>>>".($flockRow['batch_size']);
  // echo ">>>>".(int)$sumRow['sum'];
  //echo $row['standard_value'].'<br/>';
  echo $query1 = "update dailyfeeding set standard_value='".ceil((($standrRow['mortality']/100)/7)*($flockRow['batch_size']-$sumRow['sum']))."' where entry_date='".$row['entry_date']."' and flock_id='".$row['flock_id']."' and field_name='feed_mortality';"."<br/>";
}

?>