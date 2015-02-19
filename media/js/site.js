var landing = {
    accessToken: null,
    $ageGate: null,
	init: function(){
		landing.initEventHandlers();
        landing.$ageGate = $("#age-gate");

        $(".trailer").click(function() {
            $.fancybox({
                'padding'		: 0,
                'autoScale'		: false,
                'transitionIn'	: 'none',
                'transitionOut'	: 'none',
                'title'			: this.title,
				'href'			: this.href,
				'type'			: 'iframe',
                'swf'			: {
                    'wmode'		: 'transparent',
                    'allowfullscreen'	: 'true'
                },
                beforeLoad: function() {
                    
                }
            });
			gaEvent('landing-trailer');
            return false;
        });

        var $cs = $('.carbon').customSelect();

        if(readCookie('ineligible')) {
            $('#landing').hide();
			$('#ineligible').show();
            return;
        }
		
		$('.social-btns area').on('mousedown',function(){
			//window tablets don't recognize 'click' JS event with image maps
			if ($(this).attr('alt') == 'Twitter') {
				gaEvent('follow_twitter');
			}
			if ($(this).attr('alt') == 'Facebook') {
				gaEvent('follow_fb');
			}
			if ($(this).attr('alt') == 'Instagram') {
				gaEvent('follow_instagram');
			}
		});
        
	},
	
	start: function(){
		FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and connected to your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                // console.log('all is good');
                var uid = response.authResponse.userID;
                landing.accessToken = response.authResponse.accessToken;
                if(document.URL.indexOf("?mobile") != -1) {
                    window.location.href = '/main/start?a='+landing.accessToken+"&mobile";
                } else {
                    window.location.href = '/main/start?a='+landing.accessToken;
                }
                // landing.showLaunchModal(response);
            } else if (response.status === 'not_authorized') {
              // console.log("the user is logged in to Facebook, but not connected to the app");
            } else {
              // console.log("the user isn't even logged in to Facebook.");
            }
        });
	},

    transition: function(elToShow, fade) {
        window.scrollTo(0, 0);
        var elToHide = $('.wrapper:visible');
        if(fade) {
            $(elToHide).fadeOut(250, function() {
                $(elToShow).css({
                    left: 0,
                    opacity: 1
                }).fadeIn(250);
            });
        } else {
            $(elToHide).animate({
                left: -100,
                opacity: 0
            }, 250, function() {
                $(elToHide).hide();
                $(elToShow).css({
                    left: 100,
                    opacity: 0
                }).show().animate({
                    left: 0,
                    opacity: 1
                }, 250);
            });
        }
    },
	
	initEventHandlers: function(){
        $('.close').on('click', function(e) {
            if($(this).parents('.modal')[0].id != 'picture-public-modal') {
                e.stopPropagation();
                e.preventDefault();
                //Clear errors
                landing.$ageGate.find('.error').hide();
                $('input[type=checkbox]').parents('label').css({
                    color: 'inherit'
                });
                $('input[type=checkbox]').attr('checked', false);
                landing.transition('#landing', true);
            }
        });
		$('.join').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            landing.transition('#age-gate');
			gaPage('instructions');
			gaEvent('join_the_race');
        });
        $(".create-account").on('click',function(){
			//since we check FBloginStatus upon page load, if user IS ABLE click the "connect button" they are 1) new users or 2) old users just not logged into facebook
			//prompt user for age gate (dedicated page or modal).
            landing.transition('#age-gate');
			gaPage('age_gate'); //going to go to age_gate
			gaEvent('prequalify');
		});
        $('.go-to-dash').on('click', function() {
            landing.start();
        });
        $('.returning').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            landing.transition('#reconnect');
        });
        $(".facebook-connect").on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            gaEvent('returning_user');
            loadMask('#reconnect');
            FB.login(function(response) {
                if(response.authResponse) {
                    $.ajax({
                        url: '/api/landing/lookupuser',
                        type: 'POST',
                        data: {
                            access_token: FB.getAccessToken()
                        },
                        complete: function(response, status) {
//                            console.log('Lookup User', arguments);
                            removeMask('#reconnect');
                            if(status == 'error' || $.isEmptyObject(response)) {
                                return;
                            }
                            if(response.responseJSON.user === undefined || !response.responseJSON.user) {
                                landing.transition('#age-gate');
                                return;
                            }
                            var agree_sweeps = false;
                            var agree_weekly = false;
                            if(response.responseJSON.user.agree_sweeps == 'yes') {
                                agree_sweeps = true;
                            }
                            if(response.responseJSON.user.agree_weekly == 'yes') {
                                agree_weekly = true;
                            }

                            if(agree_sweeps && agree_weekly) {
                                //If previously accepted weekly contest
                                loadMask('body');
                                landing.start();
                            } else if(agree_sweeps && !agree_weekly) {
                                //If previously accepted sweeps
                                landing.transition('#sweepstakes');
                            } else {
                                //First time back to phase II app
                                $('#repermission .name').text(', '+response.responseJSON.user.firstname);
                                landing.transition('#repermission');
                            }
                        }
                    });
                }
            });
        });
        $(".repermission-submit").on('click', function(e) {
            //Clear error

            $('#transition label').css({
                color: 'inherit'
            });
            if(!($('#repermission input[name=terms]').is(':checked'))) {
                $('#repermission input[name=terms]').parents('label').css({
                    color: 'red'
                });
                return;
            }
            loadMask('#repermission');
            $.ajax({
                url: '/api/landing/updateuser',
                type: 'POST',
                data: {
                    access_token: FB.getAccessToken(),
                    agree_sweeps: function() {
                        if($('#repermission input[name=terms]').is(':checked')) {
                            return 'yes';
                        } else {
                            return 'no';
                        }
                    },
                    agree_weekly: function() {
                        if($('#repermission input[name=weekly]').is(':checked')) {
                            return 'yes';
                        } else {
                            return 'no';
                        }
                    }
                },
                complete: function(response, status) {
//                    console.log('Update User', arguments);
                    removeMask('#repermission');
                    if(status == 'success') {
                        if($('#repermission input[name=terms]').is(':checked')) {
                            if($('#repermission input[name=weekly]').is(':checked')) {
                                landing.transition('#transition');
                                return;
                            }
                            landing.transition('#sweepstakes');
                        }
                    } else {
                        alert('An error occurred. Please try again later.');
                    }
                }
            });
			gaEvent('repermission');
        });
        $(".sweepstakes-submit").on('click', function(e) {
            //Clear error
            $('#sweepstakes label').css({
                color: 'inherit'
            });
            if(!$('#sweepstakes input[name=weekly]').is(':checked')) {
                $('#sweepstakes input[name=weekly]').parents('label').css({
                    color: 'red'
                });
                return;
            }
            loadMask('#sweepstakes');
            $.ajax({
                url: '/api/landing/updateuser',
                type: 'POST',
                data: {
                    access_token: FB.getAccessToken(),
                    agree_sweeps: 'yes',
                    agree_weekly: 'yes'
                },
                complete: function(response, status) {
//                    console.log('Update User', arguments);
                    removeMask('#sweepstakes');
                    if(status == 'success') {
                        if(response.responseJSON.phase == 1) {
                            // Existing user
                            landing.transition('#transition');
                        } else if(response.responseJSON.phase == 2) {
                            // New user
                            loadMask('body');
                            landing.start();
                        }
                    } else {
                        alert('An error occurred. Please try again later.');
                    }
                }
            });
        });
        $(".transition-join").on('click', function(e) {
            loadMask('body');
            landing.start();
        });
        $('form[name=register]').on('submit', function(e) {
            e.preventDefault();
            submitRegForm();
        });
        $(".submit").on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            submitRegForm();
        });

        function parseDate(input) {
            var parts = input.split('-');
            // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
            return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
        }

        function submitRegForm() {
            $('.error').hide();
            var modal = landing.$ageGate;
            modal.find('.opt-ins input[name=terms]').parents('label').css({
                color: 'inherit'
            });

            var email = $('form input[name=email]').val();
            var dob_m = $('form select[name=month]').val();
            var dob_d = $('form select[name=day]').val();
            var dob_y = $('form select[name=year]').val();
            var optin = $('form input[name=optin]').is(':checked');
            var terms = $('form input[name=terms]').is(':checked');
            var form_valid = true;

            if(!email) {
                modal.find('.email-ctr .error').slideDown('fast');
                form_valid = false;
            }
            if(!/^[a-zA-Z0-9._%+-]+?@[a-zA-Z0-9.-]+?\.[a-zA-Z]{2,3}$/.test(email)) {
                modal.find('.email-ctr .error').slideDown('fast');
                form_valid = false;
            }
            if(!dob_m || !dob_d || !dob_y) {
                modal.find('.dob-ctr .error').slideDown('fast');
                form_valid = false;
            }
            if(!terms) {
                modal.find('.opt-ins input[name=terms]').parents('label').css({
                    color: 'red'
                });
                form_valid = false;
            }

            if(form_valid) {
                var user_dob = parseDate(dob_y+"-"+dob_m+"-"+dob_d);
                var diff = Math.abs(new Date() - user_dob);
                var min = 410200000000; // 13 years
                if(diff < min) {
                    createCookie('ineligible', true, 1000);
                    landing.transition('#ineligible');
                    gaEvent('failed_age_gate');
                    return;
                }
                landing.addUser({
                    access_token: FB.getAccessToken(),
                    opt_communication: function() {
                        if(landing.$ageGate.find('input[name=terms]').is(':checked')) {
                            return 'yes';
                        } else {
                            return 'no';
                        }
                    },
                    email: email,
                    dob: user_dob.getFullYear()+"-"+(user_dob.getMonth()+1)+"-"+user_dob.getDate(),
                    agree_sweeps: function() {
                        if(landing.$ageGate.find('input[name=terms]').is(':checked')) {
                            return 'yes';
                        } else {
                            return 'no';
                        }
                    },
                    agree_weekly: function() {
                        if(landing.$ageGate.find('input[name=weekly]').is(':checked')) {
                            return 'yes';
                        } else {
                            return 'no';
                        }
                    }
                });
            }
            gaEvent('submit');
        }
	},

    addUser: function (userdata) {
        FB.login(function (response) {
            if (response.authResponse) {
                // $("#registrationform .fbid").val(response.authResponse.userID); //hidden field for FBID
                // var userdata = $("#registrationform").serialize();
                userdata.access_token = response.authResponse.accessToken;
                loadMask('#age-gate');
                $.ajax({
                    url: '/api/landing/adduser',
                    data: userdata,
                    type: 'post',
                    dateType: 'json',
                    complete: function (response, status) {
//                        console.log('Add User', arguments);
                        removeMask('#age-gate');
                        if(status == 'success') {
                            if(response.responseJSON.phase !== undefined) {
                                //Phase is only returned for existing users
                                if(userdata.agree_sweeps() == 'yes' && userdata.agree_weekly() == 'no') {
                                    //If user agreed to sweeps
                                    landing.transition('#sweepstakes');
                                    return;
                                } else if(userdata.agree_sweeps() == 'yes' && userdata.agree_weekly() == 'yes') {
                                    //If user agreed to weekly
                                    landing.transition('#transition');
                                    return;
                                }
                            } else {
                                if(userdata.agree_sweeps() == 'yes' && userdata.agree_weekly() == 'no') {
                                    //If user agreed to sweeps
                                    landing.transition('#sweepstakes');
                                    return;
                                } else if(userdata.agree_sweeps() == 'yes' && userdata.agree_weekly() == 'yes') {
                                    //If user agreed to weekly
                                    loadMask('body');
                                    landing.start();
                                    return;
                                }
                            }
                        } else if(status == 'error') {
                            alert('An error occurred. Please try again later.');
                        }
                    }
                });
            } else {
                // console.log('User cancelled login or did not fully authorize.');
                gaEvent('incomplete_fb_authorization');
            }
        });

		gaEvent('addUser');
    },

    spinner: null,
    loadMask: function(element) {
        $(element).append('<div class="load-overlay"></div>');
        $(element+' .load-overlay').fadeIn(function() {
            landing.spinner = new Spinner({
                color: '#ddd',
                shadow: true
            }).spin($(element).get(0));
        });
    },
    removeMask: function(element) {
        $(element).find('.load-overlay').remove();
        try {
            landing.spinner.stop();
        } catch(e) {
            setTimeout(function() {
                landing.spinner.stop();
            }, 500);
        }
    }
};

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    landing.init();
    if ($("body").hasClass('index')) {
        gaPage('landing');
    }
});