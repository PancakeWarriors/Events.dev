<?php
	require_once('connect.php');
	$load = htmlentities(strip_tags($_POST['load'])) * 20;
	$query = $connect->query("SELECT * FROM calendar_events ORDER BY updated_at DESC LIMIT ".$load.",20");
	
	while($row = $query->fetch())
	{
		?>
			<div class="col-md-12">
				<h3>
					<a href="{{{ action('CalendarEventsController@show', <?php echo $row['id'];?>}}}"><?php echo $row['title']; ?>
				</h3>
				<p><img src="http://lorempixel.com/400/400" alt="" class="img-rounded pull-left" width="300" height="200" ><?php echo $row['description'];?></p>
				<h5>From: <?php echo date_create($row['start_dateTime'])->format('l, F jS Y @ h:i:s a');?></h5>
				<h5>To: <?php echo date_create($row['end_dateTime'])->format('l, F jS Y @ h:i:s a')?></h5></a>

			</div>
		<?php
	}


?>