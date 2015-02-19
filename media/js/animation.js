var dashboardAnim = {
    init: function() {
        dashboardAnim.animate();
    },

    radians: function(degrees) {
        return degrees * (Math.PI / 180);
    },

    degrees: function(radians) {
        return Math.round(radians * (180 / Math.PI));
    },

    animate: function() {
        //////////////////////////////////////////////
        // Fill animation
        //////////////////////////////////////////////

        var currentAngle = 140;
        var maxAngle = getMaxAngle(100);
        function drawArc() {
            var canvas = document.getElementById('fill-canvas');
            var context = canvas.getContext('2d');
            var x = canvas.width / 2;
            var y = canvas.height / 2;
            var radius = 133;
            var startAngle = dashboardAnim.radians(90);
            var endAngle = dashboardAnim.radians(currentAngle += 1);
            var counterClockwise = false;

            context.clearRect(0, 0, canvas.width, canvas.height);
            context.beginPath();
            context.arc(x, y, radius, startAngle, endAngle, counterClockwise);
            context.lineWidth = 30;

            // line color
            var my_gradient = context.createLinearGradient(100, 450, 350, 0);
            my_gradient.addColorStop(0, "#ff0000");
            my_gradient.addColorStop(1, "#ff6600");
            context.strokeStyle = my_gradient;
            context.stroke();
            context.closePath();

            if(currentAngle == maxAngle) {
                clearInterval(animateFill);
            }
        }

        function getMaxAngle(level) {
            var minDeg = 140;
            var maxDeg = 351;
            var diff = maxDeg - minDeg;
            return diff * (level / 100) + minDeg;
        }

        //////////////////////////////////////////////
        // Score animation
        //////////////////////////////////////////////

        var animateScore = setInterval(animatePoints, 40);


        $('header .points-val').text(numberWithCommas(info.user.points_total));
        $('header .rank-val').text(numberWithCommas(info.user.rank));

        function animatePoints() {
             var rand = Math.floor((Math.random()*9999999)+1);
             dashboardAnim.drawPoints(rand);

             setTimeout(function() {
                 clearInterval(animateScore);
                 if(typeof info.user.total_weekpoints === 'undefined' || info.user.total_weekpoints === null) {
                     info.user.total_weekpoints = 0;
                 }
                 dashboardAnim.drawPoints(info.user.total_weekpoints);
             }, 3000);
        }
    },

    drawPoints: function(points) {
        if(points < 0 || points > 9999999 || typeof points === 'undefined' || points === null) {
            return;
        }
        var digits = 7;
        points = points.toString();
        //console.log('Points', points, 'Length', points.length);

        var x;
        if(points === '0') {
            for(x = 0; x<digits; x++) {
                $('.points-ctr :nth-child('+(x+1)+')').text('0');
            }
            return;
        }
        for(x = 0; x<digits; x++) {
            //console.log(x);
            if(x <= (digits - points.length)) {
                $('.points-ctr :nth-child('+x+')').text('0');
            } else {
                //console.log('index', x);
                for(var y=0; y<points.length; y++) {
                    //console.log(y, points.charAt(y));
                    $('.points-ctr :nth-child('+(x+y)+')').text(points.charAt(y));
                }
                return;
            }
        }
    }
};
if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    dashboardAnim.init();
});