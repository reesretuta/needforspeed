// menu functionality
function closeMenu(){
    $('.full-page-wrapper').css({
        left: '0'
    }).off('click');

    $('html').css({'position': 'static'});

    $('nav').removeAttr('style').removeClass('nav-active');
}

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    var transEndEventNames = {
            'WebkitTransition' : 'webkitTransitionEnd',
            'MozTransition'    : 'transitionend',
            'OTransition'      : 'oTransitionEnd otransitionend',
            'msTransition'     : 'MSTransitionEnd',
            'transition'       : 'transitionend'
        },
        transEndEventName = transEndEventNames[ Modernizr.prefixed('transition') ];

    var $landing = $('#landing'), $rules = $('#rules'), $ageGate = $('#age-gate');

    $landing.find('.join-mobile').on('click', function() {
        transition($landing, $rules);
    });

    $rules.find('.join-race').on('click', function() {
        transition($rules, $ageGate);
    });

    function transition(elToHide, elToShow) {
        $(elToHide).fadeOut(function() {
            $(this).removeClass("active");
            elToShow.fadeIn(function() {
                $(this).addClass("active");
            });
        });
    }


    $('.watch-trailer').on('click', function() {
        $('.trailer-overlay').fadeIn();
        $('.close-btn').on('click', function() {
            $('.trailer-overlay').fadeOut();
        });
    });

    $('.header img.nav-btn').on('click', function() {
        if($('nav').hasClass('nav-active')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    if(typeof info !== 'undefined') {
        $('.dashboard .pts span').text(numberWithCommas(info.user.points_total));
    }

    if(typeof Dashboard === 'function') {
        var dashboard = new Dashboard();
        $('nav > .how-to').on('click', function() {
            $('.full-page-wrapper').on(transEndEventName, {function: dashboard.showHowToPlay}, onMenuClosed);
            closeMenu();
        });
    }

    if(typeof CarCustomizer === 'function') {
        var customizer = new CarCustomizer();
        $("nav > .my-car").on('click',function() {
            closeMenu();
            customizer.show();
        });
    }

    if(typeof Leaderboard === 'function') {
        var leaderboard = new Leaderboard();
        $("nav > .map-leaderboard").on("click",function(){
            closeMenu();
            leaderboard.showLeaderboard();
        });
    }

    function openMenu(){
        // update points and rank to make sure we have the latest before showing them to the user
        if(typeof info !== 'undefined') {
            $('nav > .rank > span').html(numberWithCommas(info.user.rank));
            $('nav > .score > span').html(numberWithCommas(info.user.points_total));
        }

        $('.full-page-wrapper').css({
            left: '75%'
        })
            .addClass('dimmed');

        $('html').css({
            'position': 'fixed'
        });

        $('nav').css({'display': 'block'})
            .addClass('nav-active');
    }


    function onMenuClosed(event){
        if(parseInt(event.target.style.left) === 0)
        {
            $(this).off(transEndEventName);

            $('nav').css({
                'display': ''
            });

            if(event.data.function) {
                event.data.function();
            } else if(event.data.modalObject) {
                showModal(event.data.modalObject);
            }
        }
    }
});

