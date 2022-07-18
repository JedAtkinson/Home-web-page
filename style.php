<?php
    header("Content-type: text/css; charset: UTF-8");

	if($theme == 'light'){
		$bg_colour = "#e6e6e6";
		$text_colour = "#333333";
		$secondary_colour = "#d1d1d1";
	} elseif($theme == "dark"){
		$bg_colour = "#333333";
		$text_colour = "#e6e6e6";
		$secondary_colour = "#242424";
	}

?>

body {
	background-color: <?php echo $bg_colour; ?>;
	color: <?php echo $text_colour; ?>;
	margin: 8%;
	margin-top: 2%;
	font-family: Optima, sans-serif;
}

.light-body {
	background-color: #e6e6e6;
	color: #333333;
}

h1 {
	font-size: 60px;
	margin-bottom: 50px;
}

.light-logo {
	filter: invert(90%);
}

.loginLinks {
	font-size: 20px;
	float: right;
	padding: 20px;
}

.loginLinks a {
	float: right;
	font-size: 20px;
	padding: 10px;
}

.date { 
  font-size: 27px;
  text-align: center;
}

.weatherwidget {
	width: 100%;
	float: left;
}

.light-searchBox {
	background-color: #d1d1d1 !important;
	color: #333333 !important;
}

#searchBox {
	margin-top: 5%;
	border-radius: 300px;
	background-color: <?php echo $secondary_colour; ?>;
	background-image: url("images/search.png");
	position: left;
	padding-left: 40px;
	background-size: 30px;
	background-repeat: no-repeat;
	color: <?php echo $text_colour; ?>;
	font-size: 20px;
	height: 40px;
	width: 99%;
}

.links {
	display: grid;
	justify-content: center !important;
	grid-template-columns: repeat(auto-fit, minmax(80px, 0fr));
	grid-gap: 80px;
}

h2 {
	font-size: 50px;
	text-align: center;
}

#Xbutton {
	color: <?php echo $text_colour; ?>;
	background-color: <?php echo $secondary_colour; ?>;
	border-radius: 100px;
	padding: 4px;
	z-index: 10;
	position: relative;
	left: 50px;
	top: 50px;
	display: none;
}

.light-linksImg {
  	background-color: #d1d1d1 !important;
}

.linksImg {
  	width: 20px;
  	background-color: <?php echo $secondary_colour; ?>;
	padding: 30px;
	border-radius: 30px;
	display: block;
	margin-left: auto;
	margin-right: auto;

}

.links p {
	position: relative;
	bottom: 10px;
	text-align: center;
}

.to_do {
	width: 40%;
	display: inline-block;
	float: right;
}

/* Style the list items */
ul li {
  cursor: pointer;
  position: relative;
  padding: 8px; 
  background: <?php echo $secondary_colour; ?>;;
  font-size: 18px;
  transition: 0.2s;

  /* make the list items unselectable */
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Set all odd list items to a different color (zebra-stripes) */
ul li:nth-child(odd) {
  background: <?php echo $$bg_colour; ?>;
}

/* Darker background-color on hover */
ul li:hover {
  background: grey;
}

/* When clicked on, add a background color and strike out text */
ul li.checked {
  background: #888;
  color: #fff;
  text-decoration: line-through;
}

/* Style the close button */
.close {
  position: absolute;
  right: 0;
  top: 0;
  padding: 8px;
}

.close:hover {
  background-color: #f44336;
  color: white;
}

.form-control {
	width: 500px;
	height: 20px;
	background-color: <?php echo $secondary_colour; ?>;
		color: <?php echo $text_colour; ?>;
	border-radius: 10px;
	margin: 10px;
	margin-bottom: 30px;
}

form {
	display: block;
	text-align: center;
	align-content: center;
	padding: 10px;
}

.btn {
	background-color: <?php echo $secondary_colour; ?>;
	color: <?php echo $text_colour; ?>;
	width: 100px;
	margin: 20px;
	border-radius: 10px;
}

a {
	color: #62aad1;
}

.light-myForm {
	background-color: rgba(230,230,230,0.75) !important;
  	color: #e6e6e6 !important;
  	border: 10px solid #ffffff !important;
}

/* The popup form - hidden by default */
#myForm {
  display: none;
  position: fixed;
  bottom: 30%;
  right: 35%;
  border: 10px solid <?php echo $secondary_colour; ?>;
  border-radius: 20px;
  z-index: 9;
  background-color: rgba(0,0,0,0.75);
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

.light-lightMode {
	background-color: #333333;
  	color: #e6e6e6;
}

#lightMode {
	border-radius: 10px;
	height: 30px;
	z-index: 9;
	position: fixed;
	bottom: 20px;
	left: 20px;
}

/* Use a media query to add a breakpoint at 800px: */
@media screen and (max-width: 600px){

	body {
		margin: 5%;
	}

	h1 {
		font-size: 40px;
		margin-bottom: 10px;
	}

	h1 img {
		width: 30px;
	}

	h2 {
		font-size: 30px;
	}

	.date { 
		font-size: 20px;
		float: left;
	}

	.loginLinks {
		padding: 1px;
	}

	.loginLinks a {
		font-size: 15px;
	}

	input[name="q"] {
		padding-left: 40px;
		height: 30px;
		width: 90%;
	}
}
