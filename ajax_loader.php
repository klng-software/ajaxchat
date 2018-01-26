  <?php 
	$abfrage = $_GET['id'];
	$neu = '';

	//Config auslesen
	require_once('inc/config.php');
	$ausdruck = $mysql->prepare("SELECT chattext FROM $table");
	$ausdruck->execute();
	$ergebnis = $ausdruck->get_result();
	while($row = $ergebnis->fetch_assoc())
	{
		$neu .= $row['chattext'].'<br /></div>';
	}

      
	if ($abfrage !== $neu){
		echo $neu;
	} 