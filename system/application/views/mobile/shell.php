<?php
$antiCache = time();
?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <title>Need For Speed</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

	<meta name="description" content="Register now for the Need For Speed Movie Race to DeLeon to gain to access exclusive ford cars and for a chance to win a trip for two to NY to attend a VIP Need For Speed party! Need For Speed - in theaters, March 2014">
	<meta name="keywords" content="Need For Speed The Movie">
    <meta property="og:title" content="Need For Speed" />
    <meta property="og:url" content="https://www.racetodeleon.com" />
	<meta property="og:image" content="https://www.racetodeleon.com/media/images/nfs_logo_300x300.jpg?v=2" />
	<meta property="og:description" content="Register now for the Need For Speed Movie Race to DeLeon to gain to access exclusive ford cars and for a chance to win a trip for two to NY to attend a VIP Need For Speed party! Need For Speed - in theaters, March 2014" />


    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta http-equiv="cleartype" content="on">


    <link rel="shortcut icon" href="/media/images/favicon.ico">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="media/mobile/img/touch/apple-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#222222">


    <link rel="stylesheet" href="/media/mobile/css/normalize.css">
    <link rel="stylesheet" href="/media/mobile/css/main.css<?= (ENVIRONMENT === 'development') ? "?v={$antiCache}" : '';?>">
</head>
<body class="<?= $this->router->method ?>">
<!-- Add your site or application content here -->
<?php if (isset($content)): ?>
	<?= $content ?>
<?php endif; ?>



<footer>
    <?php if(isset($dashboard)) { ?>
    <div class="social">
        <div class="followus">
            <img src="/media/images/followus.png" alt="follow us"/>
        </div>

        <img src="/media/mobile/images/social-links.png" usemap="#social-btns"/>
        <map name="social-btns">
            <area shape="circle" coords="43,41, 29" href="https://www.facebook.com/needforspeed.na" alt="Facebook" target="_blank" />
            <area shape="circle" coords="120,41, 29" href="https://twitter.com/NeedforSpeed" alt="Twitter" target="_blank" />
            <area shape="circle" coords="195,41, 29" href="http://instagram.com/needforspeed" alt="Instagram" target="_blank" />
        </map>
    </div>
    <?php } ?>
    <div class="legal">
        <div class="rating">
            <img src="/media/images/PG-13.png" />
        </div>
        <a href="http://www.ford.com/" class="ford-logo" target="_blank">
            <img src="/media/images/ford-go-further.png"/>
        </a>


        <div class="copyright">
            © 2013 Dreamworks II Distribution Co., LLC Need For Speed™ and logo are trademarks of EA &nbsp;|&nbsp;
            <a href="http://disneytermsofuse.com/english/" target="_blank">Terms of Use</a> &nbsp;|&nbsp;
            <a href="http://disneyprivacycenter.com/" target="_blank">Privacy Policy</a> &nbsp;|&nbsp;
            <a href="/main/rules" target="_blank">Sweepstakes Official Rules</a> &nbsp;|&nbsp;
            <a href="/main/rules_challenge" target="_blank">Weekly Challenge Official Rules</a>
        </div>

        <div class="rules">
            * Race To DeLeon Weekly Challenge (“Challenge”) and Race To DeLeon Sweepstakes (“Sweeps”):  No Purchase Necessary.
            Void Where Prohibited.  Open to eligible legal residents of US (including DC) and Canada (excluding Quebec) 13 yrs+
            at time of entry.  If winner is a minor, parent/legal guardian will have to claim the prize.  Click on <a href="/main/rules_challenge" target="_blank">Challenge
            Official Rules</a> or <a href="/main/rules" target="_blank">Sweeps Official Rules</a> for details on entry instructions, prize details and limitations,
            restrictions, etc. Sponsor: WDSMP.  For Sweeps: Ends 3/16/14 at 11:59:59PM PST. To enter go to <a href="http://www.racetodeleon.com" target="_blank">www.racetodeleon.com</a>
            or send email to <a href="mailto:NFSsweeps@brandmovers.com">NFSsweeps@brandmovers.com</a>, with name, email address, state or province, and date of birth.  
            Limit 1 entry per person/email address. Odds of winning depend on number of eligible entries. For  Challenge:
            Ends 3/16/14 at 11:59:59PM PST (See Official Rules for Weekly Challenge Periods).  To enter go to <a href="http://www.racetodeleon.com" target="_blank">www.racetodeleon.com</a>.
            Weekly Challenge winners will be selected based on total point value or as otherwise provided in Official Rules.
        </div>
    </div>
</footer>

<?php
if(isset($modals)) {
    foreach ($modals as $key => $value) {
        echo $value;
    }
}
?>

<script type="text/javascript" charset="utf-8">
<?php if(isset($dashboard)): ?>
    var info = <?= json_encode($dashboard); ?>;
    var access_token = <?= json_encode($access_token); ?>;
<?php endif; ?>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-37522835-8', 'racetodeleon.com');
    ga('send', 'pageview');
	function gaPage(page){
	  ga('send', 'pageview', '/'+page);

	}
	function gaEvent(element){
		ga('send', 'event', 'button', 'click', element);
	}

    //facebook
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

    //Modernizr with Prefixer
    window.Modernizr=function(a,b,c){function w(a){i.cssText=a}function x(a,b){return w(prefixes.join(a+";")+(b||""))}function y(a,b){return typeof a===b}function z(a,b){return!!~(""+a).indexOf(b)}function A(a,b){for(var d in a){var e=a[d];if(!z(e,"-")&&i[e]!==c)return b=="pfx"?e:!0}return!1}function B(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:y(f,"function")?f.bind(d||b):f}return!1}function C(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+m.join(d+" ")+d).split(" ");return y(b,"string")||y(b,"undefined")?A(e,b):(e=(a+" "+n.join(d+" ")+d).split(" "),B(e,b,c))}var d="2.7.1",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l="Webkit Moz O ms",m=l.split(" "),n=l.toLowerCase().split(" "),o={},p={},q={},r=[],s=r.slice,t,u={}.hasOwnProperty,v;!y(u,"undefined")&&!y(u.call,"undefined")?v=function(a,b){return u.call(a,b)}:v=function(a,b){return b in a&&y(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=s.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(s.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(s.call(arguments)))};return e}),o.audio=function(){var a=b.createElement("audio"),c=!1;try{if(c=!!a.canPlayType)c=new Boolean(c),c.ogg=a.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,""),c.mp3=a.canPlayType("audio/mpeg;").replace(/^no$/,""),c.wav=a.canPlayType('audio/wav; codecs="1"').replace(/^no$/,""),c.m4a=(a.canPlayType("audio/x-m4a;")||a.canPlayType("audio/aac;")).replace(/^no$/,"")}catch(d){}return c};for(var D in o)v(o,D)&&(t=D.toLowerCase(),e[t]=o[D](),r.push((e[t]?"":"no-")+t));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)v(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},w(""),h=j=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._domPrefixes=n,e._cssomPrefixes=m,e.testProp=function(a){return A([a])},e.testAllProps=C,e.prefixed=function(a,b,c){return b?C(a,b,c):C(a,"pfx")},e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

    libraries = <?= json_encode(isset($scripts['libraries']) ? $scripts['libraries'] : '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'); ?>;
    jqueryLibraries = <?= json_encode(isset($scripts['jqueryLibraries']) ? $scripts['jqueryLibraries'] : ''); ?>;
    siteJs = <?= json_encode(isset($scripts['js']) ? $scripts['js'] : ''); ?>;

    Modernizr.load([ {
        test: ((typeof info !== 'undefined') ? info.ismobile : false) || Modernizr.touch,
        yep: '/media/js/libs/hammer.min.js',
        both: libraries,
        complete: function () {
            if (!window.jQuery) {
                Modernizr.load('/media/js/libs/jquery-1.10.2.min.js');
            }
            if(typeof Spinner === 'function' && typeof info !== 'undefined') {
                if(info.user.car === null) {
                    spinner = new Spinner({
                        color: '#ddd',
                        shadow: true
                    });
                    spinner.spin(document.getElementById('carselect-loader-overlay'));
                }
            }
        }
    }, {
        load: jqueryLibraries
    }, {
        load: siteJs,
        complete: function() {
            if(typeof executeOnLoad !== 'undefined') {
                $(function() {
                    var i, len;
                    for(i = 0, len = executeOnLoad.length; i < len; i++) {
                        executeOnLoad[i]();
                    }
                });
            }
        }
    }
    ]);
</script>

</body>
</html>
