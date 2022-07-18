<?php
include 'head.php';
?>

<body style="background-color:<?php echo $bg_colour; ?>; color:<?php echo $text_colour; ?>;">
	<h1><a href="index.php"><img id="logo" src="images\pineapple.png" alt="logo" style="filter:<?php echo $image_colour; ?>;"></a> <span id="greating"></span> <?php if($loggedin == true){ echo htmlspecialchars($_SESSION["username"]); } ?>
	<div class="loginLinks">
		<?php if($loggedin == true){ echo '<a href="logout.php">Log out</a>'; }else {echo '<a href="login.php">Log in</a> <a href="register.php">Sign up</a>';} ?>
	</div></h1>
 	<div class="date" id="clockbox"></div>

	<script type="text/javascript">
		var tday=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		var tmonth=["January","February","March","April","May","June","July","August","September","October","November","December"];

		function GetClock(){
		var d=new Date();
		var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate();
		var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

		if(nhour==0){ap=" AM";nhour=12;greating=" Good Morning";}
		else if(nhour<12){ap=" AM";greating=" Good Morning";}
		else if(nhour==12){ap=" PM";greating=" Good Afternoon";}
		else if(nhour>12){ap=" PM";nhour-=12;greating=" Good Afternoon";}
			
		if (nhour>14){greating=" Good Evening"}

		if(nmin<=9) nmin="0"+nmin;
		if(nsec<=9) nsec="0"+nsec;

		var clocktext=""+tday[nday]+" - "+tmonth[nmonth]+" "+ndate+" - "+nhour+":"+nmin+ap;
		document.getElementById('clockbox').innerHTML=clocktext;
		document.getElementById('greating').innerHTML=greating;
		}

		GetClock();
		setInterval(GetClock,1000);
	</script>
	<br><br>


	<?php
		echo('
		<div class="weatherwidget">
		<a class="weatherwidget-io" href="https://forecast7.com/en/n43d30172d60/rangiora/" data-label_1="RANGIORA" data-label_2="WEATHER" data-font="Roboto" data-icons="Climacons" data-theme="blank" data-textcolor="'.$text_colour.'">RANGIORA WEATHER</a>
		<script>
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://weatherwidget.io/js/widget.min.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","weatherwidget-io-js");
		</script></div>');
	?>

	<form method="GET" action="https://www.google.com/search" name="googleSearch">
		<input id="searchBox" type="text" name="q" placeholder="Search Google..." size="120" autofocus style="color:<?php echo $text_colour; ?>; background-color:<?php echo $secondary_colour; ?>; ">
	</form>

	<div class="your_links">
		<h2>Your links</h2>
		<div class="links">

			<?php
				if ($loggedin == true) {

					$sql = 'SELECT id, userID, link, title, img FROM links WHERE userID='.$_SESSION["id"].'';
					$result = $link->query($sql);

					$link_id = 0;
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
						echo "<div class='linkContainer' draggable='true' id='" . $link_id . "'><form action='removeLink.php' method='post'><button type='submit' value='" . $row["id"] . "' name='id' id='Xbutton' style='color:" . $text_colour . "; background-color:" . $secondary_colour . ";'>X</button></form><a href=" . $row["link"] . " id='linksButtons' draggable='false'><img class='linksImg' draggable='false' src='" . $row["img"] . "' alt=" . $row["title"] . " style='background-color:" . $secondary_colour . ";'></a><p>" . $row["title"] . "</p></div>";
						$link_id += 1; 
						}
					}
					else {
					  echo "You have no links";
					}
					echo "<div class=''><img class='linksImg' id='addLink' src='images/plus.png' alt='addLink' onclick='openForm()' style='margin-top:47px;background-color:" . $secondary_colour . ";'><p>Add link</p></div>";
					

					
				} else {
					echo "Login to add your own links";
				}
			?>
		</div>
	</div>

	<script>
		dragged = null;
		elements = document.getElementsByClassName("linkContainer");
		for (var i = 0; i < elements.length; i++) {
		elements[i].addEventListener("drag", event => {
			// store a ref. on the dragged elem
			dragged = event.target;
			dragged.style.visibility = "hidden";
		});

		elements[i].addEventListener("dragend", event => {
			dragged.style.visibility = "visible";
			dragged = null;
		});

		/* events fired on the drop targets */
		elements[i].addEventListener("dragover", event => {
			if (dragged != null) {
				// prevent default to allow drop
				event.preventDefault();
			}
		}, false);

		elements[i].addEventListener("dragenter", event => {
			// highlight potential drop target when the draggable element enters it
			if (event.target.className == "linksImg" & dragged != null) {
				event.target.style.outline = 'grey solid 2px';
			}
		});

		elements[i].addEventListener("dragleave", event => {
			// reset background of potential drop target when the draggable element leaves it
			if (event.target.className == "linksImg" & dragged != null) {
				event.target.style.outline = null;
			}
		});

		elements[i].addEventListener("drop", event => {
			// move dragged element to the selected drop target
			if (event.target.className == "linksImg" & dragged != null) {
				event.target.style.outline = null;
				dragged_html = dragged.innerHTML;
				dragged.innerHTML = event.target.parentNode.parentNode.innerHTML;
				event.target.parentNode.parentNode.innerHTML = dragged_html;
			}
		});
		}
	</script>

	<div class="form-popup" id="myForm" style="background-color:<?php echo $secondary_colour; ?>;">
		<form action="newLink.php" method="post">
			<label>URL</label><br>
			<input type="text" name="url" class="form-control" autocomplete="off" style="color:<?php echo $text_colour; ?>; background-color:<?php echo $bg_colour; ?>;"><br>

		    <label>Title</label><br>
		    <input type="text" name="title" class="form-control" autocomplete="off" style="color:<?php echo $text_colour; ?>;background-color:<?php echo $bg_colour; ?>;"><br>

		    <input type="submit" value="Submit" class="btn btn-primary" style="display: inline-block; float: right; color:<?php echo $text_colour; ?>;background-color:<?php echo $bg_colour; ?>;">
		</form>
		<button class="btn cancel" onclick="closeForm()" style="display: inline-block; float:left; margin-top: -3px; color:<?php echo $text_colour; ?>;background-color:<?php echo $bg_colour; ?>;">Close</button>
	</div>

	<script type="text/javascript">
		function openForm() {
		  	document.getElementById("myForm").style.visibility = "visible";
		  
		  	var elms = document.querySelectorAll("[id='Xbutton']");
			for(var i = 0; i < elms.length; i++) 
		  		elms[i].style.visibility='visible';
		}

		function closeForm() {
		  	document.getElementById("myForm").style.visibility='hidden';

		 	var elms = document.querySelectorAll("[id='Xbutton']");
			for(var i = 0; i < elms.length; i++) 
		  		elms[i].style.visibility='hidden';
		}
	</script>

	<?php
	echo '<form action="theme_change.php" method="post">
		<input id="lightMode" type="submit" name="theme-change" value="theme-change" style="background-color:' . $text_colour . '; color:' . $bg_colour . ';">
	</form>';
	?>

	<a href="settings.php"><img src="images/cog.png" id="settings_button" alt="settings" width="25px" style="position: fixed; bottom: 22px; left: 140px;"></a>

</body>

</html>