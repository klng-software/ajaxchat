  <?php 
	$chat_id = $_GET['chat_id'];


	//Config auslesen
	require_once('inc/config.php');
        
        // 
	$ausdruck = $mysql->prepare("SELECT txt.textval FROM chattext txt "
                                                    . "INNER JOIN chatentity chat ON chat.entityid = txt.textaddr "
                                                    . "WHERE chat.entityid = ?");
        
        $ausdruck->bind_param("i", $chat_id);
	
        $ausdruck->execute();
	
        $ergebnis = $ausdruck->get_result();
        
        $neu = '';
	while($row = $ergebnis->fetch_assoc())
	{
		$neu .= $row['textval'].'<br /></div>';
	}

      
	
        echo $neu;
	