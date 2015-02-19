<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>

	<meta charset="UTF-8">
	<title>Title!</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="stylesheet" href="/media/css/reset.css?v=1">
	<link rel="stylesheet" href="/media/css/style.css?v=1">

	
	<link rel="shortcut icon" href="/media/images/favicon.ico">
	<script type="text/javascript" src="/media/js/libs/modernizr-1.7.min.js"></script>

</head>


<body>


	
	
	
	<!-- main content wrapper end -->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="/media/js/plugins.js"></script>		
	<script type="text/javascript" src="/media/js/site.js"></script>
	<script type="text/javascript" charset="utf-8">
	$.ajax({
		url: '/api/quiz/question',
		type: 'get',
		success: function(r){
			console.log(r);
		}
	});
	</script>
</body>
</html>	