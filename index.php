
	<style type="text/css">
		
		#textbox{
			width:219px;
			border:1px solid orange;
		}
		
		#textbox:focus{
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
			string = document.getElementById("ajax_chat").innerHTML;
			xmlhttp.open("GET","ajax_loader.php?id="+string+"&blabla="+Math.random(),true);
			xmlhttp.send();
		}
	</script> 

	 <?php 
	//Config auslesen
	require_once('inc/config.php');
	 

	echo '
	 <form action="index.php" method="post">
		<table border="0">
			<tr>
				<th><span style="font-weight:normal;">Nickname:</span></th><td><input type="text" name="nick" value="'.(isset($_POST['nick']) ? htmlspecialchars($_POST['nick']) : "").'" id="textbox"></td>
			</tr>                
			<tr>
				<th><span style="font-weight:normal;">Nachricht:</span></th><td><input type="text" name="eintrag" value="'.(isset($_POST['eintrag']) ? htmlspecialchars($_POST['eintrag']) : "").'" id="textbox">&nbsp;
				<input type="submit" name="eintragen" value="Senden!" id="button">&nbsp;
				<input type="button" id="button" onClick="loadXMLDoc();" value="Reload"></td>
			</tr>
		</table>
		
	<div id="ajax_chat" style="border:1px dotted black; width:402px; height:190px; padding:5px; overflow: auto;">';
			  $ausdruck = $mysql->prepare("SELECT chattext FROM $table");
			  $ausdruck->execute();
			  $ergebnis = $ausdruck->get_result();
			  while($row = $ergebnis->fetch_assoc())
			  {
				echo $row['chattext'].'<br />';
			  }'
	</div>';
			 

	if(isset($_POST['eintrag'])){

		if(empty($_POST['nick']) || empty($_POST['eintrag'])){
			
			echo '<script>alert("Bitte Nick oder Nachricht eingeben -.-")</script>';
			
		} else {
			//Variablen definieren und mit "POST" Daten füllen (Mit htmlspecialchars filtern..)
			$nick = htmlspecialchars($_POST['nick']);
			$eintrag = htmlspecialchars($_POST['eintrag']);

			//Die 2 oben definierten Variablen zusammensetzen
			$alles = '<span style="color:#FF1493">'.$nick.'</span>: <span style="color:#3399FF">'.$eintrag.'</span>';

			//Nick + Eintrag in die Datenbank schreiben
			$ausdruck = $mysql->prepare("INSERT INTO $table 
										(chattext) VALUES	
										('{$alles}')");
			$ausdruck->execute();		
							  
		}

	}

