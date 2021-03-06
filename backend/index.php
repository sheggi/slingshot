<!DOCTYPE html>
<!--<?php 
$origin = "http://". $_SERVER["HTTP_HOST"] . "/slingshot/frontend/";
?>-->
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="<?php echo $origin; ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $origin; ?>css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php echo $origin; ?>css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-cloack="">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" ng-init="showMenu = true;">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" ng-click="showMenu=!showMenu">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" rel="home" title="Slingshot App">Slingshot App</a>
			</div>
			<div class="navbar-collapse" ng-class="{collapse: showMenu}">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" class="navbar-link">Signed in as Mark Otto</a></li>
					<li class="active"><a href="#">Dashboard <span class="sr-only">(current)</span></a></li>
					<li><a href="#login">Login</a></li>
				</ul>
			</div>
		</div>
	</nav>
<div class="container" style="margin-top:20px;">
	
	<div ng-controller="moneyCtrl as money">
		<button  type="button" class="btn btn-default" ng-click="logonAdmin();">Admin anmelden...</button>
		<h2>User: {{user.nick}}</h2>
		<accountlist></accountlist>
		<h3>Account: {{account.title}}</h3>
		
		<recordlist></recordlist>
			

	</div>
	
    <div data-ng-view="" id="ng-view" class="slide-animation"></div>
	

	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="<?php echo $origin; ?>js/angular.js"></script>
    <script src="<?php echo $origin; ?>js/ui-bootstrap-tpls-0.11.2.js"></script>
	<script src="<?php echo $origin; ?>js/money.js"></script>
	<script src="<?php echo $origin; ?>app/app.js"></script>
	<script src="<?php echo $origin; ?>app/data.js"></script>
	<script src="<?php echo $origin; ?>app/directives.js"></script>
	<script src="<?php echo $origin; ?>app/moneyCtrl.js"></script>
	
	<hr>
	<pre>
	<?php include "preview.php";?>
	</pre>
	<hr>
	
</div>
  </body>
</html>