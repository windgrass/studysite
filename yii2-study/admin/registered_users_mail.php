<?php 

				$ergebnis=safe_query("SELECT * FROM ".PREFIX."user WHERE newsletter='1' AND email != ''");
				$anz=mysql_num_rows($ergebnis);
				if($anz) {
					while($ds=mysql_fetch_array($ergebnis)) {
						$emails = $ds['email'];
						echo $emails.'; <br \>';
					}		
				}
				
?>