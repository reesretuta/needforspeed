<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<title>Need For Speed</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<meta name="description" content="">
	<meta name="keywords" content="">

    <meta property="og:title" content="Need For Speed" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.racetodeleon.com" />
    <meta property="og:image" content="http://www.racetodeleon.com/media/images/logo.png" />

	<link rel="stylesheet" href="/media/css/reset.css?v=1">
	<link rel="stylesheet" href="/media/js/fancybox/source/jquery.fancybox.css">
	<link rel="stylesheet" href="/media/css/app.css?v=1">
	<link rel="shortcut icon" href="/media/images/favicon.ico">
	
    <style>
        body {
            background: url('/media/images/signup/bg.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>
<body>
	<div id="fb-root"></div>
	<div class="logo-ctr">
		<img src="/media/images/logo.png"/>
	</div>

    <div id="rules" class="modal">
        <div class="modal-ctr">
            <img class="header" src="/media/images/signup/pre-qualify-now.png" />
            <div class="rules">
                <ul>
                    <li>Sign up to pre-qualify for the race to de leon</li>
                    <li>Recruit a friend as your right seat driver</li>
                    <li>Watch and share the trailer with your friends</li>
                </ul>
            </div>
            <div class="toolbar">
                <img class="create-account" src="/media/images/signup/create-account.png" />
                <img class="watch-trailer" src="/media/images/signup/watch-trailer.png" />
                <span class="returning">Returning User? Sign In</span>
            </div>
        </div>
    </div>

    
    <div id="age-gate" class="modal">
        <div class="modal-ctr">
            <img class="header" src="/media/images/signup/your-information.png" />

            <form>
                <div class="email-ctr">
                    <div>Email</div>
                    <input type="text" />
                </div>
                <div class="dob-ctr">
                    <div>Date of Birth</div>

                    <select name="month" class="carbon">
                        <option></option>
                        <option value="January">Jan</option>
                        <option value="Febuary">Feb</option>
                        <option value="March">Mar</option>
                        <option value="April">Apr</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">Aug</option>
                        <option value="September">Sept</option>
                        <option value="October">Oct</option>
                        <option value="November">Nov</option>
                        <option value="December">Dec</option>
                    </select>

                    <select name="day" class="carbon">
                        <option></option>
                        <?php for($x=1; $x<=31; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php } ?>
                    </select>

                    <select name="year" class="carbon">
                        <option></option>
                        <?php for($x=2014; $x>=1900; $x--) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="opt-ins">
                    <label>
                        <input type="checkbox" />
                        I agree to the terms, privacy and rules agreement
                    </label>
                    <label>
                        <input type="checkbox" />
                        Sign me up for the newsletter
                    </label>
                </div>
            </form>

            <div class="toolbar">
                <img class="create-account" src="/media/images/signup/facebook-connect.png" />
                <span class="returning">Returning User? Sign In</span>
            </div>
        </div>
    </div>

    
    <div id="ready" class="modal">
        <div class="modal-ctr">
            <div class="profile">
                <img src="/media/images/signup/profile-frame.png" />
                <img class="profile-img" src="/media/images/dashboard/sample_profile_img.jpg" />
            </div>
            <div class="info">
                <img src="/media/images/signup/you-are-ready.png" alt="You Are Ready!"/>
                <img class="go-to-dash" src="/media/images/signup/go-to-dash.png" alt="Go To Dashboard"/>
            </div>
            <div class="toolbar">

            </div>
        </div>
    </div>


    <footer>
        <div class="social-btns">
            <img src="/media/images/signup/footer-social-btns.png" usemap="#footer-social-btns" />
            <map name="footer-social-btns">
                <area shape="circle" coords="35,31,17" alt="Twitter" href="#twitter">
                <area shape="circle" coords="86,31,17" alt="Facebook" href="#facebook">
                <area shape="circle" coords="136,31,17" alt="Share Link" href="#link">
            </map>
        </div>
        <div class="copyright">
            © 2013 Dreamworks II Distribution Co., LLC<br/>
            Need For Speed™ and logo are trademarks of EA<br/>
            <a href="#">Terms of Use</a> &nbsp;|&nbsp;
            <a href="#">Privacy Policy</a> &nbsp;|&nbsp;
            <a href="#">Official Rules</a>
        </div>
        <!--
        <a href="#" id="connect"><img src="/media/images/connect.png"></a>
        -->
    </footer>

	<script>
	  window.fbAsyncInit = function() {
	    // init the FB JS SDK
	    FB.init({
	      appId      : "<?= APPID ?>", 		// App ID from the app dashboard
	      channelUrl : '//'+location.hostname+'/channel.html', // Channel file for x-domain comms
	      status     : true,                                 // Check Facebook Login status
	      xfbml      : true                                  // Look for social plugins on the page
	    });
		
		// landing.start();

		
	    // Additional initialization code such as adding Event Listeners goes here
	  };

	  // Load the SDK asynchronously
	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/all.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="/media/js/libs/jquery.fancybox.js"></script>
    <script type="text/javascript" src="/media/js/libs/jquery.customSelect.min.js"></script>
	<script type="text/javascript" src="/media/js/site.js"></script>
</body>
</html>	