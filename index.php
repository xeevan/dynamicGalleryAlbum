<?php
	
	if(isset($_FILES['files']))
	{	
		$name = $_FILES['files']['name'];
		$type = $_FILES['files']['type'];

		$extention = strtolower(substr($name, strpos($name,'.')+1));

		$tmp_name = $_FILES['files']['tmp_name'];
		if(!empty($name))
		{
			if(($extention=='jpg' or $extention=='jpeg') and $type=='image/jpeg')
			{
				$location = "uploads/".$name;

				if(move_uploaded_file($tmp_name,$location))
				{
					$mysql_host = 'localhost';
					$mysql_user = 'root';
					$mysql_pass = '';

					$mysql_db = 'images';
					$mysql_conn_error = 'Oops! Could not connect to database';

					if(!@mysql_connect($mysql_host,$mysql_user,$mysql_password) or !@mysql_select_db($mysql_db))
					{	
						die($mysql_conn_error);
					}

					$query = "INSERT INTO `imageLinks`(`imgLink`) VALUES('$location')";
					$query_run = mysql_query($query);
				}
				else
					echo 'There was an error';
				}
			else
			{
				echo 'Please choose jpeg file.';
			}
		}
		else
		{
			echo 'Please choose a file.';
		}
	}
?>

<html>
  <head><title>dynamicGalleryAlbum</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			    <div class="navbar-header">		      
			    	<a class="navbar-brand" href="/dynamicGalleryAlbum">Dynamic Gallery Album</a>
			    </div>		    
			</div>
		</nav>

		<div class="container"><hr>
			<div class="jumbotron">

			<?php
				$mysql_host = 'localhost';
				$mysql_user = 'root';
				$mysql_password = '';

				$mysql_db = 'images';
				$mysql_conn_error = 'Oops! Could not connect to database';

				if(!@mysql_connect($mysql_host,$mysql_user,$mysql_password) or !@mysql_select_db($mysql_db))
				{	
					die($mysql_conn_error);
				}

				$query = "SELECT `imgLink` FROM `imageLinks`";
				if($query_run = mysql_query($query))
				{	
					$query_num_row = mysql_num_rows($query_run);
					if($query_num_row != NULL)
					{
						while ($query_row = mysql_fetch_assoc($query_run)) {
							echo '<img src="'.$query_row['imgLink'].'" class="img-thumbnail" height="150px" width="150px" style="margin-left:17px; margin-top:10px;">';
						}
					}
					else
					{
						echo '<h2><strong>Uloaded Images goes here...</strong><small>Dynamic Gallery Album</small></h2>';
					}
				}
			?>

				<!-- <img src="<?php if(isset($_FILES['files']))
								{	
									$name = $_FILES['files']['name'];
									$type = $_FILES['files']['type'];

									$extention = strtolower(substr($name, strpos($name,'.')+1));
									if(!empty($name))
									{
										if(($extention=='jpg' or $extention=='jpeg') and $type=='image/jpeg')
										{
											echo $location = "uploads/".$name;
										}
									}
								}?>" class="img-thumbnail" height="150px" width="150px"> -->
			</div>
			<form class="form-horizontal" action="index.php" method="POST" enctype="multipart/form-data">
				<div class="form-group">
		      		<div class="col-lg-10">
			        	<input type="file" name="files" style="display:none;"id="browse">
			        	<input type="button" class="btn btn-primary" value="Browse" onclick="document.getElementById('browse').click()">
			        	<input type="submit" class="btn btn-primary" value="Upload">
			      	</div>
			    </div>
			</form>
		</div>

      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
  </body>
</html>
