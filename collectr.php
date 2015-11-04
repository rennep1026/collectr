<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>TKP - Web Dev</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/collectr.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Collectr</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Your Collections <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Full List</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Type 1</li>
                        <li><a href="#">Collection 1</a></li>
                        <li><a href="#">Collection 2</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Type 2</li>
                        <li><a href="#">Collection 3</a></li>
                        <li><a href="#">Collection 4</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1>Your Collections</h1>
    <div class="container collection list-group">
        <div class="item list-group-item">
            <div class="itemHead">
                <h2>Item1 <small>Desc1</small></h2>
            </div>
            <div class="itemBody">
                <span>Value1</span>
                <span>Value2</span>
            </div>
        </div>
        <div class="item list-group-item">
            <div class="itemHead">
                <h2>Item1 <small>Desc1</small></h2>
            </div>
            <div class="itemBody">
                <span>Value1</span>
                <span>Value2</span>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.waypoints.min.js"></script>
</body>
</html>