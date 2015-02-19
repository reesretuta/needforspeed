var activities = {
    init: function() {
        if(typeof info !== 'undefined' ? info.ismobile : false) {
            $('.notification-qty').on('click', function(e) {
                activities.toggleNotifications(e);
            });
        } else {
            $('body').on('click',function(e){
                activities.toggleNotifications(e);
            });
        }
        activities.initSpeedbump();
        activities.initWeeklyPrize();
        activities.initNotifications();
        activities.initSharePicture();
        activities.initShareVideo();
        activities.initShareActivities();
        activities.initLinkOut();
        activities.initCheckin();
    },

    initWeeklyPrize: function() {
        $('.carousel-ctr img').attr('src', '/media/images/dashboard/prize-week'+info.user.week+'.jpg');
    },

    initSharePicture: function() {
        $('.activity[activity-type=picture]').on('click', function() {
            var activityObj = activities.findActivity($(this).attr('activity-type'), $(this).attr('activity-id'));
            var modal = $('#picture-modal');
			modal.find('.facebook-share, .twitter-share, .tumblr-share').off();
            showModal(modal);
            modal.find('h1').text(activityObj.title);
            modal.find('.modal-content-ctr img').attr('src', activityObj.photo);
            modal.find('.facebook-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                FB.ui({
                    method: 'feed',
                    link: activityObj.share_url,
                    picture: window.location.origin+'/'+activityObj.photo,
                    caption: activityObj.fb_share
                }, function(response){});
                activities.completePhotoVideoShare('facebook', activityObj);
				gaEvent('activity-picture-sharefb');
            });
            modal.find('.twitter-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                var url = encodeURIComponent(activityObj.share_url),
                    text = encodeURIComponent(activityObj.twitter_share);
                var shareurl = 'http://twitter.com/intent/tweet?url='+url+"&text="+text;
                window.open(shareurl,'_blank',"width=600,height=400");
                activities.completePhotoVideoShare('twitter', activityObj);
				gaEvent('activity-picture-sharetwitter');
            });
            modal.find('.tumblr-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                var tumblrImg = window.location.origin+'/'+activityObj.photo;
                var toOpen = 'http://www.tumblr.com/share/image?embed=' + encodeURIComponent(tumblrImg) + '&caption='+ activityObj.tumblr_share;
                window.open(toOpen,'_blank',"width=600,height=400");
                activities.completePhotoVideoShare('tumblr', activityObj);
				gaEvent('activity-picture-sharetumblr');
            });
            modal.find('.title .close').on('click', function() {
                hideModal(modal);
            });
        });
		gaEvent('activity-picture-open');
    },

    initShareVideo: function() {
        $('.activity[activity-type=youtube]').on('click', function() {
            var activityObj = activities.findActivity($(this).attr('activity-type'), $(this).attr('activity-id'));
            var modal = $('#youtube-modal');
			modal.find('.facebook-share, .twitter-share, .tumblr-share').off();
            modal.find('iframe').attr('src', '//www.youtube.com/embed/'+activityObj.youtubeid);
            modal.find('h1').text(activityObj.title);
            showModal(modal);
            modal.find('.facebook-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                FB.ui({
                    method: 'feed',
                    link: 'https://www.youtube.com/watch?v='+activityObj.youtubeid,
                    caption: activityObj.fbshare
                }, function(response){});
                activities.completePhotoVideoShare('facebook', activityObj);
				gaEvent('activity-video-sharefb');
            });
            modal.find('.twitter-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                var url = encodeURIComponent('http://youtu.be/'+activityObj.youtubeid),
                    text = encodeURIComponent(activityObj.twittershare);
                var shareurl = 'http://twitter.com/intent/tweet?url='+url+"&text="+text;
                window.open(shareurl,'_blank',"width=600,height=400");
                activities.completePhotoVideoShare('twitter', activityObj);
				gaEvent('activity-video-sharetwitter');
            });
            modal.find('.tumblr-share').on('click', function() {
              //disable sharing
              return false;
              //disable sharing
                var tumblrIframe = '<iframe src="http://www.youtube.com/embed/'+ activityObj.youtubeid +'" width="600" height="480" frameborder="0" allowfullscreen=""></iframe>';
                var toOpen = 'http://www.tumblr.com/share/video?embed=' + encodeURIComponent(tumblrIframe) + '&caption='+ encodeURIComponent(activityObj.tumblrshare + ' http://youtu.be/'+activityObj.youtubeid);
                window.open(toOpen,'_blank',"width=600,height=400");
                activities.completePhotoVideoShare('tumblr', activityObj);
				gaEvent('activity-video-sharetumblr');
            });
            modal.find('.title .close').on('click', function() {
                hideModal(modal);
            });
            $('#youtube-modal').on('hidden.bs.modal', function (e) {
                modal.find('iframe').attr('src', '');
            });
        });
		
		gaEvent('activity-video-open');
    },

    completePhotoVideoShare: function(platform, activityObj) {
        var url;
        if(activityObj.activity_type == 'picture') {
            url = '/api/activity/pictureshare';
        } else if(activityObj.activity_type == 'youtube') {
            url = '/api/activity/youtube';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                aid: activityObj.activityid,
                platform: platform
            },
            complete: function(response, status) {
                if(status == 'success') {
                    dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                }
            }
        });
    },

    initShareActivities: function() {
        var timeout = 0;
        var tofollowurl = '',tout_large = '',activityObj,type;
        var modal = $('#follow-modal');
        var $facebookSharePic = modal.find('.facebook-share'),
            $twitterSharePic = modal.find('.twitter-share'),
            $tumblrSharePic = modal.find('.tumblr-share');

        var $followImg = modal.find('.modal-content-ctr img'), $followLink = modal.find('.modal-content-ctr a');

        function completeFollowActivity() {
            setTimeout(function() {
                $.ajax({
                    url: '/api/activity/follow',
                    type: 'POST',
                    data: {
                        aid: activityObj.activityid,
                        activity_type: type
                    },
                    timeout: 200000,
                    complete: function(response, status) {
                        if(status == 'success') {
                            dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                        }
                    }
                });
            }, timeout);
        }
        function listenersOff() {
            $followImg.off();
            $facebookSharePic.off();
            $twitterSharePic.off();
            $tumblrSharePic.off();
        }

        function facebookShare() {
          //disable sharing
          return false;
          //disable sharing
            FB.ui({
                method: 'feed',
                name: 'Need for Speed - The Movie',
                link: tofollowurl,
                picture: window.location.origin+'/'+tout_large,
                caption: 'Enter the RacetoDeLeon.com/share/'+info.user.fbid+' for a chance to win a $100 Fandango gift card & signed movie poster! #NFSMovie is in theaters this Friday!'
            }, function(response){});
            completeFollowActivity();
            gaEvent('activity-follow-'+type+'-sharefb');
        }
        function twitterShare() {
          //disable sharing
          return false;
          //disable sharing
            var url = encodeURIComponent(tofollowurl),
                text = encodeURIComponent('Enter the RacetoDeLeon.com/share/'+info.user.fbid+' for a chance to win a $100 Fandango gift card & signed movie poster! #NFSMovie is in theaters this Friday!');
            console.log('url', tofollowurl, url);
            var shareurl = 'http://twitter.com/intent/tweet?text='+text;

            window.open(shareurl,'_blank',"width=600,height=400");
            completeFollowActivity();
            gaEvent('activity-follow-'+type+'-sharetwitter');
        }
        function tumblrShare() {
          //disable sharing
          return false;
          //disable sharing
            var text = encodeURIComponent('Enter the RacetoDeLeon.com for a chance to win a $100 Fandango gift card & signed movie poster! #NFSMovie is in theaters this Friday!');
            var url = encodeURIComponent(tofollowurl);
            var toOpen = 'http://www.tumblr.com/share?v=3&u='+url+'&t='+text;
            window.open(toOpen,'_blank',"width=600,height=400");
            activities.completePhotoVideoShare('tumblr', activityObj);
            completeFollowActivity();
            gaEvent('activity-follow-'+type+'-sharetumblr');
        }

        modal.find('.title .close').on('click', function() {
            hideModal(modal);
        });

        $('.activity[activity-type=fblike], .activity[activity-type=twitter], .activity[activity-type=tumblr]').on('click', function() {
            type = $(this).attr('activity-type');
            activityObj = activities.findActivity(type, $(this).attr('activity-id'));

            listenersOff();

			modal.find('h1').text(activityObj.title);
            if(type == 'fblike' || type == 'twitter' || type == 'tumblr') {
                switch(type) {
                    case 'fblike':
                        tofollowurl = activityObj.fburl;
                        tout_large = activityObj.fblikes_img_large;
                        break;
                    case 'twitter':
                        tofollowurl = activityObj.twitteraccount;
                        tout_large = activityObj.twitters_img_large;
                        break;
                    case 'tumblr':
                        tofollowurl = activityObj.tumblraccount;
                        tout_large = activityObj.tumblrs_img_large;

                        break;
                }
            }
            $followImg.attr('src', getMobilePath(tout_large));
            $followLink.attr('href', tofollowurl);

            $followImg.on('click',completeFollowActivity);
            $facebookSharePic.on('click', facebookShare);
            $twitterSharePic.on('click', twitterShare);
            $tumblrSharePic.on('click', tumblrShare);
			
			showModal(modal);
			gaEvent('activity-follow-'+type+'-open');
        });
    },

    findActivity: function(activityType, activityId) {
        var activityObj;
        if(activityId) {
            activityObj = _.findWhere(info.activities, {
                activity_type: activityType,
                activityid: String(activityId)
            });
        } else {
            activityObj = _.findWhere(info.activities, {
                activity_type: activityType
            });
        }
        if(_.isObject(activityObj)) {
            return activityObj;
        } else {
			//speedbump
            //console.error('Could not find activity', activityType, activityId);
            return null;
        }
    },

    toggleNotifications: function(e) {
        var target = $(e.target);
        var well = $('header .notification-well');
        var pin = $('header .pin');
        var isVisible = well.is(':visible');

        if(typeof info !== 'undefined' ? info.ismobile : false) {
            well = $('.notification-well');
            if(target.hasClass('notification-qty')) {
                showModal($('#notifications-modal'));
                well.fadeIn(250);
                pin.fadeIn(250);
                updateNotifications();
            }
            $('#notifications-modal .close').on('click', function() {
                well.fadeOut(250, function() {
                    hideModal($('#notifications-modal'));
                });
                pin.fadeOut(250);
            });
            return;
        }
        if(isVisible) {
            if(target.hasClass('notification-qty') ||
                (target.parents('.notification-well').length === 0 && !target.hasClass('notification-well')) ) {
                well.hide();
                pin.hide();
            }
        } else if(target.hasClass('notification-qty')) {
            well.fadeIn(250);
            pin.fadeIn(250);
            updateNotifications();
        }
        function updateNotifications() {
            $.ajax({
                url: '/api/activity/history',
                success: function(response) {
                    activities.initNotifications(response.history);
                }
            });
        }
    },

    initNotifications: function(history) {
        var descriptions = {
            youtube:     'Shared Video',
            twitter:     'Twitter Follow',
            tumblr:      'Tumblr Follow',
            texttrivia:  'Movie Quiz',
            picture:     'Shared Picture',
            phototrivia: 'Photo Trivia',
            fblike:      'Facebook Like',
            checkin:     'Event Checkin',
            link:        'Visited Link',
            recruit:     'Recruited Friend',
            speedbump:   'Speedbump',
            instagram:   'Instagram Follow'
        };
        var scroll = $('.notification-well').niceScroll();
        $(scroll.rail[0]).find('div').css({
            'background-color': 'rgba(0, 0, 0, 0.6)',
            'border': 'none'
        });
        $('.notify-content').empty();
        var weekNumber = Number(info.user.week);
        var weeks = info.history;
        if(history) {
            weeks = history;
        }
        if(weeks === false) {
            $('<div class="notify-item">No activities completed</div>').appendTo('.notify-content');
            return;
        } else {
            $('.notification-qty').text(weeks[weekNumber-1].activities.length);
        }
        var x, appendActivityEvent = function(index, activity) {
            appendEvent((x+1), activity);
        };
        for(x = weekNumber-1; x >= 0; x--) {
            var currentWeek = '';
            if(x == weekNumber-1) {
                currentWeek = 'current-week';
            }
            if(x == weekNumber-1) {
                appendWeekSubhead('This Week');
            } else if(x == weekNumber-2) {
                appendWeekSubhead('Last Week');
            } else {
                appendWeekSubhead('Week '+(x+1));
            }
            if(weeks[x].activities.length == 0) {
                $('<div class="notify-item '+currentWeek+'">No activities completed</div>').appendTo('.notify-content');
            }
            $.each(weeks[x].activities, appendActivityEvent);
        }
        function appendWeekSubhead(weekString) {
            $('<div class="notify-subhead">'+weekString+'</div>').appendTo('.notify-content');
        }
        function appendEvent(week, activity) {
            var currentWeek = '';
            if(week == info.user.week) {
                currentWeek = 'current-week';
            }
            $('<div class="notify-item '+currentWeek+'">'+descriptions[activity.activity_type]+
                '<div class="points">+ '+numberWithCommas(activity.pointvalue)+' pts</div></div>').appendTo('.notify-content');
        }
    },

    initLinkOut: function() {
        $('.activity[activity-type=link]').on('click', function() {
            var activityObj = activities.findActivity($(this).attr('activity-type'), $(this).attr('activity-id'));
            window.open(activityObj.linkout_url);
            $.ajax({
                url: '/api/activity/linkout',
                type: 'POST',
                data: {
                    aid: activityObj.activityid
                },
                complete: function(response, status) {
                    if(status == 'success') {
                        dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                    }
                }
            });
        });
    },

    initSpeedbump: function() {
        var modal = $('#speedbump-modal');
        var speedBumpObj = activities.findActivity('speedbump');

        if(speedBumpObj === null || info.user.car === null || modal.length === 0) {
            return;
        }
        if(speedBumpObj.speedbump_completed === true || info.speedbump_complete === true) {
            return;
        }

        modal.find('img.speedbump-img').attr('src', getMobilePath(speedBumpObj.tout));
        modal.find('.copy').text(speedBumpObj.speedbump_question);
        modal.find('.choices .yes').text(speedBumpObj.yes_answer);
        modal.find('.choices .no').text(speedBumpObj.no_answer);
        showModal(modal);

        modal.find('.btn').on('click', function(e) {
            loadMask('#speedbump-modal');
            var answer = $(e.target).attr('answer');
            $.ajax({
                url: '/api/activity/speedbump',
                type: 'POST',
                data: {
                    aid: speedBumpObj.activityid,
                    a: answer
                },
                complete: function(response, status) {
                    removeMask('#speedbump-modal');
                    if(status == 'success') {
                        modal.find('.choices').hide();
                        modal.find('.ok-btn-ctr').show();
                        if(response.responseJSON.correct == 'yes') {
                            modal.find('.copy').text(response.responseJSON.correct_response);
                            modal.find('.points span').text('+'+numberWithCommas(Number(speedBumpObj.pointvalue)));
                            modal.find('.points').addClass('correct');
                        } else {
                            modal.find('.copy').text(response.responseJSON.incorrect_response);
                            modal.find('.points span').text('0');
                            modal.find('.points').addClass('incorrect');
                        }
                        dash.markActivityComplete(speedBumpObj.activity_type, speedBumpObj.activityid, speedBumpObj.pointvalue);
                        info.speedbump_complete = true;
                        modal.find('.watch-out').hide();
                        modal.find('.points').show();
                        modal.find('.copy').addClass('result');
                        $('.btn').off('click');
                        modal.find('.ok-btn').on('click', function() {
                            hideModal(modal);
                        });
                    } else {
                        alert('An error occurred. Please try again later.');
                        hideModal(modal);
                    }
                }
            });
        });
    },

    initCheckin: function() {
        $('.activity').on('click', function() {
            var type = $(this).attr('activity-type');
            var activityObj = activities.findActivity(type, $(this).attr('activity-id'));
            if(type == 'checkin') {
                var modal = $('#checkin-modal');
                var virtualTab = modal.find('.virtual-tab');
                var physicalTab = modal.find('.physical-tab');
                var virtualCtr = modal.find('.virtual-ctr');
                var physicalCtr = modal.find('.physical-ctr');
                var physicalFormCtr = modal.find('.physical-form-ctr');

                virtualTab.removeClass('active');
                physicalTab.addClass('active');
                physicalFormCtr.hide();
                virtualCtr.hide();
                physicalCtr.show();
                modal.find('.msg').text('');
                modal.find('.toolbar h1').hide();
                modal.find('.steps span.tag').text('#'+activityObj.checkinhash);
                modal.find('.virtual-ctr .image-ctr img.image').attr('src', activityObj.checkin_share_img);
                showModal(modal);

                physicalTab.on('click', function() {
                    $(this).addClass('active');
                    virtualTab.removeClass('active');
                    physicalCtr.show();
                    physicalFormCtr.hide();
                    virtualCtr.hide();
                });
                modal.find('.virtual-tab').on('click', function() {
                    $(this).addClass('active');
                    physicalTab.removeClass('active');
                    physicalCtr.hide();
                    physicalFormCtr.hide();
                    virtualCtr.show();
                });
                modal.find('.continue-btn').on('click', function() {
                    physicalCtr.hide();
                    physicalFormCtr.show();
                });
                modal.find('.close-btn').on('click', function() {
                    hideModal(modal, cleanup);
                });
                modal.find('.screening-accordion').on('click', function() {
                    modal.find('.screening-ctr').toggleClass('collapsed');
                });
                modal.find('.share-btn').on('click', function(e) {
                    var platform = $(e.target).attr('platform');
                    switch(platform) {
                        case 'facebook':
                            facebookShare();
                            break;
                        case 'twitter':
                            twitterShare();
                            break;
                        case 'tumblr':
                            tumblrShare();
                            break;
                    }
                    $.ajax({
                        url: '/api/activity/checkin',
                        type: 'POST',
                        data: {
                            aid: activityObj.activityid,
                            physical: 'no',
                            platform: platform
                        },
                        complete: function(response, status) {
                            if(status) {
                                dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                                disableTab('physical');
                            }
                        }
                    });
                });

                function facebookShare() {
                  //disable sharing
                  return false;
                  //disable sharing
                    FB.ui({
                        method: 'feed',
                        name: 'Need for Speed - The Movie',
                        link: 'https://www.racetodeleon.com?share='+activityObj.checkin_share_img,
                        picture: 'https://www.racetodeleon.com'+activityObj.checkin_share_img,
                        caption: activityObj.checkin_share_fb
                    }, function(response){});
                    gaEvent('activity-follow-'+type+'-sharefb');
                }
                function twitterShare() {
                  //disable sharing
                  return false;
                  //disable sharing
                    var text = encodeURIComponent(activityObj.checkin_share_twitter);
                    var shareurl = 'http://twitter.com/intent/tweet?text='+text;
                    window.open(shareurl,'_blank',"width=600,height=400");
                    gaEvent('activity-follow-'+type+'-sharetwitter');
                }
                function tumblrShare() {
                  //disable sharing
                  return false;
                  //disable sharing
                    var tumblrImg = 'https://www.racetodeleon.com'+activityObj.checkin_share_img;
                    var toOpen = 'http://www.tumblr.com/share/photo?source='+encodeURIComponent(tumblrImg)+'&caption='+ encodeURIComponent(activityObj.checkin_share_tumblr);
                    window.open(toOpen,'_blank',"width=600,height=400");
                    activities.completePhotoVideoShare('tumblr', activityObj);
                    gaEvent('activity-follow-'+type+'-sharetumblr');
                }
                function disableTab(ctr) {
                    if(ctr == 'physical') {
                        modal.find('.disabled').text("Physical event check-in has been disabled because you've already earned virtual check-in points this week. Check back next week for another chance to check in.");
                        modal.find('physical-ctr').hide();
                    } else if(ctr == 'virtual') {
                        modal.find('.disabled').text("Virtual event check-in has been disabled because you've already earned physical check-in points this week. Check back next week for another chance to check in.");
                        modal.find('virtual-ctr').hide();
                    }
                    modal.find('.disabled').css({
                        display: 'table-cell'
                    });
                }
                modal.find('.check').on('click', function(e) {
                    var username, platform;
                    var targetParent = $(e.target).parent('.network-ctr');
                    if(targetParent.hasClass('instagram')) {
                        username = targetParent.find('input[type=text]').val();
                        platform = 'instagram';

                    } else if(targetParent.hasClass('twitter')) {
                        username = targetParent.find('input[type=text]').val();
                        platform = 'twitter';
                    }
                    modal.find('.toolbar h1').hide();
                    modal.find('.error').text('');
                    if(username === '') {
                        modal.find('.toolbar h1').hide();
                        modal.find('.error').text('Please enter a valid username.');
                        return;
                    }
                    loadMask('#checkin-modal .modal-content');
                    modal.find('.title .tab').css({
                        'pointer-events': 'none'
                    });
                    $.ajax({
                        url: '/api/activity/checkin',
                        type: 'POST',
                        data: {
                            aid: activityObj.activityid,
                            physical: 'yes',
                            platform: platform,
                            username: username
                        },
                        complete: function(response, status) {
                            removeMask('#checkin-modal .modal-content');
                            modal.find('.title .tab').css({
                                'pointer-events': 'auto'
                            });
                            if(status == 'success') {
                                if(response.responseJSON.post_verified == false) {
                                    modal.find('.msg').addClass('error').text('Sorry, we were unable to verify your check-in. Please try again later.');
                                } else {
                                    modal.find('.toolbar h1').show();
                                    dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                                }
                            } else {
                                modal.find('.msg').addClass('error').text('Connection error. Please try again later.');
                            }
                        }
                    });
                });
                modal.find('.close, .collect-btn').on('click', function() {
                    hideModal(modal, cleanup);
                });
                modal.on('hidden.bs.modal', cleanup);
                function cleanup() {
                    modal.find('.screening-accordion').off();
                }
            }
        });
    }
};

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    activities.init();
});