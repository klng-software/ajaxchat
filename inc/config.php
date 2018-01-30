
<?php
	$server    = 'localhost';
	$user    = 'dbuser1';
	$pass    = 'LWu_LH]CY_rOvcdZ]xDxcjX9XClUMrCo';
	$db    = 'chat';
	
        $mysql = new mysqli($server, $user, $pass, $db);
        if (mysqli_connect_errno()) {
            printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
            exit();
        }
	
?> 