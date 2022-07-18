<?php
include 'head.php';
?>

<body>
<h1><a href="index.php"><img id="logo" src="images\pineapple.png" alt="logo" style="filter:<?php echo $image_colour; ?>;"></a>
Settings</h1>

<div style="float:left; padding-right:10%;">
	<p>Defult themes</p>
	<select id="theme-select" name="theme-select" style="color:<?php echo $text_colour; ?>; background-color:<?php echo $secondary_colour; ?>;">
    <option value="dark-theme">Dark theme</option>
    <option value="light-theme">Light theme</option>
    <option value="custom">Custom</option>
	</select><br><br>

  <p>Background color</p>
  <input type="color" id="background-color" name="background-color" value="#333333"><br><br>

  <p>Text color</p>
  <input type="color" id="text-color" name="text-color" value="#e6e6e6" onchange="textUpdate(this)"><br><br>

  <p>Secondary color</p>
  <input type="color" id="secondary-color" name="secondary-color" value="#242424" onchange="secondaryUpdate(this)">

  <p>Logo color</p>
  <input type="range" id="logo-color" style="float:left;" value="0" onchange="logoUpdate(this)"><br><br>
</div>

<h1 style="font-size:40px; margin-bottom:2px;">Preview</h1>

<div id="miniSite">
	<h1><a href="index.php"><img id="miniLogo" src="images\pineapple.png" alt="logo" style="filter:<?php echo $image_colour; ?>;"></a> <span id="greating"></span> <?php if($loggedin == true){ echo htmlspecialchars($_SESSION["username"]); } ?></h1>
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

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
						echo "<div calss='linkContainer'><form action='removeLink.php' method='post'><button type='submit' value='" . $row["id"] . "' name='id' id='Xbutton' style='color:" . $text_colour . "; background-color:" . $secondary_colour . ";'>X</button></form><a href=" . $row["link"] . " id='linksButtons'><img class='linksImg' src='" . $row["img"] . "' alt=" . $row["title"] . " style='background-color:" . $secondary_colour . ";'></a><p>" . $row["title"] . "</p></div>";
						}
					}
					else {
					  echo "You have no links";
					}
					echo "<div calss='linkContainer'><img class='linksImg' src='images/plus.png' alt='addLink' onclick='openForm()' style='margin-top:47px;background-color:" . $secondary_colour . ";'><p>Add link</p></div>";
					

					
				} else {
					echo "Login to add your own links";
				}
			?>
		</div>
	</div>
</div>




<script>
	var theme_select_input = document.getElementById("theme-select");
	var bg_color_input = document.getElementById("background-color");
	var text_color_input = document.getElementById("text-color");
	var second_color_input = document.getElementById("secondary-color");
	var logo_color_input = document.getElementById("logo-color");

	//Themes
	var light_theme = {"bg":"#e6e6e6", "text":"#333333", "secondary":"#d1d1d1", "logo":90}
	var dark_theme = {"bg":"#333333", "text":"#e6e6e6", "secondary":"#242424", "logo":0}
	var custom_theme = {"bg":"#333333", "text":"#e6e6e6", "secondary":"#242424", "logo":0}

	//Theme select
	theme_select_input.addEventListener("change", function() {
		if (this.value == "light-theme") {
			theme_update(light_theme)
		} if (this.value == "dark-theme") {
			theme_update(dark_theme)
		} if (this.value == "custom") {
			theme_update(custom_theme)
		}
	});

	function theme_update(theme) {
		bg_color_input.value = theme["bg"];
		text_color_input.value = theme["text"];
		second_color_input.value = theme["secondary"];
		logo_color_input.value = theme["logo"];

		color_update();
	}

	function color_update() {
		//Background color update
		document.getElementById('miniSite').style.backgroundColor = bg_color_input.value;
		
		//Text color update
		document.getElementById('miniSite').style.color = text_color_input.value;
		document.getElementById('searchBox').style.color = text_color_input.value;

		//Secondary color update
		document.getElementById('searchBox').style.backgroundColor = second_color_input.value;
		var elements = document.getElementsByClassName("linksImg");
		for(var i = 0; i < elements.length; i++) {
			elements[i].style.backgroundColor = second_color_input.value;
		}

		//Logo update
		document.getElementById('miniLogo').style.filter = "invert("+logo_color_input.value+"%)";
	}

	bg_color_input.addEventListener("input", function() {
		theme_select_input.value = "custom";
		custom_theme["bg"] = this.value;
		color_update();
	});

	text_color_input.addEventListener("input",  function() {
		theme_select_input.value = "custom";
		custom_theme["text"] = this.value;
		color_update();
	});

	second_color_input.addEventListener("input", function() {
		theme_select_input.value = "custom";
		custom_theme["secondary"] = this.value;
		color_update();
	});

	logo_color_input.addEventListener("input", function() {
		theme_select_input.value = "custom";
		custom_theme["logo"] = this.value;
		color_update();
	});
</script>

</body>

</html>