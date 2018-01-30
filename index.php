
	<style type="text/css">
		
		#textbox{
			width:219px;
			border:1px solid orange;
		}
		
		.textbox:focus{
			border:1px solid #3399FF;
		}    
		
		#button{

			border:1px solid #FF1493;
			cursor:pointer;
		}
		
		#button:hover{
			border:1px solid #3399FF;
		}
	</style> 

	<script type="text/javascript">
		function loadXMLDoc()
		{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange = function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("ajax_chat").innerHTML=xmlhttp.responseText;
			}
		}
			var id = document.getElementById("chatid").getAttribute("value");
			xmlhttp.open("GET","ajax_loader.php?chat_id="+id+"&blabla="+Math.random(),true);
			xmlhttp.send();
		}
	</script> 

	 <?php 
         $userid = 1;
         $chatid = 1;
	//Config auslesen
	require_once('inc/config.php');
	 
        echo '
	 <form action="index.php" method="post">
		<table border="0">
                        <input hidden=hidden type="select" id="chatid" name="chatid" value="'. $chatid .'" class="textbox"></td><tr>
                        <th><span style="font-weight:normal;">Nickname:</span></th><td><input type="text" name="nickname" value="'.(isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : "").'" class="textbox"></td>
			</tr>                
			<tr>
				<th><span style="font-weight:normal;">Nachricht:</span></th><td><input type="text" name="eintrag" value="'.(isset($_POST['eintrag']) ? htmlspecialchars($_POST['eintrag']) : "").'" class="textbox">&nbsp;
				<input type="submit" name="eintragen" value="Senden!" id="button">&nbsp;
				<input type="button" id="button" onClick="loadXMLDoc();" value="Reload"></td>
			</tr>
		</table>
		
	<div id="ajax_chat" style="border:1px dotted black; width:402px; height:190px; padding:5px; overflow: auto;">';
			  $ausdruck = $mysql->prepare("SELECT txt.textval FROM chattext txt "
                                                    . "INNER JOIN chatentity chat ON chat.entityid = txt.textaddr "
                                                    . "WHERE chat.entityid = ?");
                          $ausdruck->bind_param("i", $chatid);
			  $ausdruck->execute();
			  $ergebnis = $ausdruck->get_result();
			  while($row = $ergebnis->fetch_assoc())
			  {
				echo $row['textval'].'<br />';
			  }'
	</div>';
			 

	if(isset($_POST['eintrag'])){

		if(empty($_POST['nickname']) || empty($_POST['eintrag'])){
			
			echo '<script>alert("Bitte Nick oder Nachricht eingeben -.-")</script>';
			
		} else {
			//Variablen definieren und mit "POST" Daten füllen (Mit htmlspecialchars filtern..)
			$nick = htmlspecialchars($_POST['nickname']);
			$eintrag = htmlspecialchars($_POST['eintrag']);

			//Die 2 oben definierten Variablen zusammensetzen
			$alles = '<span style="color:#FF1493">'.$nick.'</span>: <span style="color:#3399FF">'.$eintrag.'</span>';
                        
			//Eintrag in die Datenbank schreiben
			$ausdruck = $mysql->prepare("INSERT INTO chattext(textuser, textaddr, textval) VALUES(?, ?, ?)");
                        $ausdruck->bind_param("iis", $userid, $chatid, $alles);
                        
			$ausdruck->execute();
							  
		}

	}

