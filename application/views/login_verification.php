<?php

	if(isset($QR))
	{
		echo '<img src='.$QR.'>';
	}
	
	if(isset($mensaje))
		echo $mensaje;
	
	?>
	
	<head></head>
	
	<body>
	
		<form action="pass_auth" method="post">
		
			<input type="text" name="key">
			<input type="submit" value="enviar" name="enviar"> 
		
		</form>
	
	</body>
	

