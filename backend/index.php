<!DOCTYPE html>
<!--<?php 
$origin = "http://". $_SERVER["HTTP_HOST"] . "/slingshot/frontend/";
?>-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="<?php echo $origin; ?>css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body  ng-app="money">
    <h1>Backend Welcome</h1>
	
	
	
	<div ng-controller="MoneyController as money">
	
	
	<button ng-click="test1()">Test 1</button>
	<button ng-click="test2()">Test 2</button>
	<button ng-click="test3()">Test 3</button>
	<button ng-click="test4()">Test 4</button>
	<button ng-click="test5()">Test 5</button>
	<button ng-click="test6()">Test 6</button>
	
	

	<table class="table">
		
		<thead>
		<tr>
			<th>Date</th>
			<th>Description</th>
			<th>Mutation</th>
			<th>Summe</th>
			<th><span class="glyphicon glyphicon-star"></span></th>
		</tr>
		</thead>
		<tr ng-repeat="record in records">
			<td>{{record.datetime | date:'dd.MM.yyyy HH:mm:ss'}}</td>
			<td>{{record.hint}}</td>
			<td>{{record.amount}}</td>
			<td>{{record.saldo}}</td>
			<th>
				<button class="glyphicon glyphicon-edit"></button>
				<button class="glyphicon glyphicon-ok"></button>
				<button class="glyphicon glyphicon-remove"></button>
				<button class="glyphicon glyphicon-trash" ng-click="deleteRecord($index, record.id)"></button>
			</th>
		</tr>
		<tr>
			<td>{{datetime | date:'dd.MM.yyyy HH:mm:ss'}}</td>
			<td><input type="text" class="form-control" ng-model="hint" placeholder="Enter Description"></td>
			<td><input type="number" class="form-control" ng-model="amount" required="true" placeholder="Enter Mutation">
			</td>
			<th colspan="2">
				<button class="glyphicon glyphicon-ok" ng-click="newRecord()"></button>
				<button class="glyphicon glyphicon-remove"></button>
			</th>
		</tr>
	</table>
	

    <div style="display:inline-block; min-height:290px;">
        <datepicker ng-model="datetime" show-weeks="true" class="well well-sm"></datepicker>
		
    </div>
<timepicker ng-model="datetime" hour-step="1" minute-step="4" show-meridian="false"></timepicker>
  

	
	</div>
	
	
	<hr>
	<pre>
	<?php include "preview.php";?>
	</pre>
	<hr>
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $origin; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo $origin; ?>js/angular.js"></script>
    <script src="<?php echo $origin; ?>js/ui-bootstrap-tpls-0.11.2.js"></script>
	<script src="<?php echo $origin; ?>js/custome.js"></script>
  </body>
</html>