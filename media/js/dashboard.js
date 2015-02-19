var Dashboard = function() {
    // Singleton
    if ( arguments.callee._singletonInstance )
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;
};
Dashboard.prototype = (function() {
    var me = this;
    var carCustomizer,carSelect,leaderboard;
    var $howToPlayBtn, $header, $pointsVal, $rankVal;
    var howToPlaySeq = 1;

    return {
        accessToken: null,
        crewPosition: 0,
        init: function() {
            carCustomizer = new CarCustomizer();
            leaderboard = new Leaderboard();
            if(typeof CarSelector === 'function')
                carSelect = new CarSelector();
            $header = $("header");

            $howToPlayBtn = $header.find('.how-to-play-btn');
            $rankVal = $header.find('.rank-val');

            if(info.ismobile) {
                $pointsVal = $("#dashboard").find("div.pts span");
            } else {
                $pointsVal = $header.find('.points-val');
            }

            $(".hero1-facebook").on('mouseup',function(){
                //disable sharing
                return false;
                //disable sharing
                dash.shareApp('facebook');
                gaEvent('recruit_fb');
                return false;
            });

            $(".hero1-twitter").on('mouseup',function(){
              //disable sharing
              return false;
              //disable sharing
                dash.shareApp('twitter');
                gaEvent('recruit_twitter');
                return false;
            });

            $(".tumblr-trailer").on('mouseup',function(){
              //disable sharing
              return false;
              //disable sharing
                dash.shareTrailer('tumblr');
                gaEvent('trailer_tumblr');
                return false;
            });

            $(".twitter-trailer").on('mouseup',function(){
              //disable sharing
              return false;
              //disable sharing
                dash.shareTrailer('twitter');
                gaEvent('trailer_twitter');
                return false;
            });

            $(".crew-ctr .leftcrew").on('mouseup',function(){
                dash.browseCrew('left');
                return false;
            });
            $(".crew-ctr .rightcrew").on('mouseup',function(){
                dash.browseCrew('right');
                return false;
            });

            $('.carousel-section a.trailer').on('click',function(){
                gaEvent('watch_trailer_dashboard');
            });

            $(".view-map-btn").click(function() {
                leaderboard.showLeaderboard();
                return false;
            });


            document.onkeydown = function(e) {
                if(carSelect !== null) {
                    if(e.keyCode == '39') {
                        carSelect.addClickToQueue("next");
                    } else if(e.keyCode == '37') {
                        carSelect.addClickToQueue("prev");
                    }
                }
            };

            if(info.ismobile)
                $('.customize-tout').on('click', function(){
                    closeMenu();
                    carCustomizer.show();
                });
            else
                $('.customize-tout-ctr').on('click', carCustomizer.show);

            dash.initCrew();

            var today = new Date();
            var eventDate = {
                year: 2014,
                month: 3,
                day: 14,
                hour: 17
            };
            var event = new Date(eventDate.year, eventDate.month-1, eventDate.day, eventDate.hour);
            if(event > today) {
                $('.countdown').show();
                var countdown = setInterval(function() {
                    dash.countdownInit(eventDate.year, eventDate.month, eventDate.day, eventDate.hour);
                }, 1000);
            }

            dash.getSocialFeed();

            dash.initTwitter();
            // dash.initFacebook();

            dash.initHowToPlay();
            dash.initRecruit();
            // dash.updateCustomizerPreview();
        },

        initCrew: function(){
            if (info.crew.length > 0) {
                $(".crew-size span:first").text(info.crew.length);
                $(".crew-frame .profile-img").attr('src','//graph.facebook.com/'+info.crew[dash.crewPosition].fbid+'/picture?width=200&height=200');
            }
            $('.tach .week').text('Week '+info.user.week);
        },

        browseCrew: function(direction){
            if (direction == 'right') {
                dash.crewPosition++;
                if(dash.crewPosition == info.crew.length) {
                    dash.crewPosition = 0;
                }
            }else if(direction == 'left'){
                dash.crewPosition--;
                if(dash.crewPosition == -1) {
                    dash.crewPosition = info.crew.length-1;
                }
            }
            $(".crew-frame .profile-img").attr('src','//graph.facebook.com/'+info.crew[dash.crewPosition].fbid+'/picture?width=200&height=200');
        },

        initTwitter: function() {
            window.twttr = (function (d,s,id) {
                var t, js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
                js.src="https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
                return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f); } });
            }(document, "script", "twitter-wjs"));
        },

        shareApp: function(platform){
          //disable sharing
          return false;
          //disable sharing
          
            if (platform == 'facebook') {
                FB.ui(
                    {
                        method: 'feed',
                        name: 'Need For Speed - Race To Deleon',
                        link: window.location.origin + '/share/' + info.user.fbid,
                        picture: window.location.origin+'/media/images/nfs_logo_75x75.jpg',
                        caption: 'Need For Speed - in theaters, March 14 2014',
                        description: 'Register now for the Need For Speed Movie Race to DeLeon for a chance to win a 2015 Ford Mustang and other prizes.'
                    },
                    function(response) {
                        if (response && response.post_id) {
                            // alert('Post was published.');
                        } else {
                            // alert('Post was not published.');
                        }
                    }
                );
            }else{
                // 'https://www.youtube.com/watch?v=e73J71RZRn8'
                var url = encodeURIComponent(window.location.origin + '/share/' + info.user.fbid),
                    text = encodeURIComponent('Register now for the Need For Speed Movie Race to DeLeon for a chance to win a 2015 Ford Mustang and other prizes.');
                var shareurl = 'http://twitter.com/intent/tweet?url='+url+"&text="+text;
                window.open(shareurl,'_blank',"width=600,height=400");
            }
        },

        shareTrailer: function(platform){
            var shareurl;
            if (platform == 'tumblr') {
               
               
                //http://www.tumblr.com/share?s=&t=Tumblr+Button%3A+Basic+share+button&u=http%3A%2F%2Fwww.tumblr.com%2Fexamples%2Fshare%2Fbasic-share-button.html&v=3
                var t = encodeURIComponent('Enter the Need For Speed Movie Race, chance to win a trip for two to NY to attend a VIP Need For Speed event! Need For Speed - in theaters, March 2014');
                shareurl = encodeURIComponent('https://www.youtube.com/watch?v=e73J71RZRn8'); //https://youtu.be/e73J71RZRn8
                // var shareurl = 'http://www.tumblr.com/share?s=&t='+t+'&u='+shareurl+'&v=3';
                // window.open('http://www.tumblr.com/share?v=3&u='+shareurl+'&t=asdf&s=');
                // window.open('http://www.tumblr.com/share?v=3&u=http%3A%2F%2Fwww.tumblr.com%2Fexamples%2Fshare%2Fbasic-share-button.html&t=asdf&s=');
                var toopen = 'http://www.tumblr.com/share/video?embed=%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Ciframe%20src%3D%22http%3A%2F%2Fwww.youtube.com%2Fembed%2Fe73J71RZRn8%22%20width%3D%22600%22%20height%3D%22480%22%20title%3D%22YouTube%20video%20player%22%20frameborder%3D%220%22%20allowfullscreen%3D%22%22%3E%3C%2Fiframe%3E%0A%20%20%20%20%20%20%20%20&caption='+t;
                window.open(toopen,'_blank',"width=600,height=400");

            } else {
                var url = encodeURIComponent('https://www.youtube.com/watch?v=e73J71RZRn8'),
                    text = encodeURIComponent('Need For Speed - in theaters, March 2014');
                shareurl = 'http://twitter.com/intent/tweet?url='+url+"&text="+text;
                window.open(shareurl,'_blank',"width=600,height=400");
            }

            $.ajax({
                url:'/api/nfs/sharetrailer',
                post: 'get',
                data: 'access_token='+access_token,
                success: function(){
                }
            });

        },

        countdownInit: function(yr, m, d, h) {
            /*
             Count down until any date script-
             By JavaScript Kit (www.javascriptkit.com)
             Over 200+ free scripts here!
             */
            var montharray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var today = new Date();
            var todayy = today.getYear();
            if (todayy < 1000) {
                todayy += 1900;
            }
            var todaym = today.getMonth();
            var todayd = today.getDate();
            var todayh = today.getHours();
            var todaymin = today.getMinutes();
            var todaysec = today.getSeconds();
            var todaystring = montharray[todaym] + " " + todayd + ", " + todayy + " " + todayh + ":" + todaymin + ":" + todaysec;

            futurestring = montharray[m - 1] + " " + d + ", " + yr + " " + h + ":00:00" ;
            dd = Date.parse(futurestring) - Date.parse(todaystring);
            dday = Math.floor(dd / (60 * 60 * 1000 * 24) * 1);
            dhour = Math.floor((dd % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
            dmin = Math.floor(((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
            dsec = Math.floor((((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);

            if(dsec < 0) {
                $('.countdown').hide();
                return null;
            } else {
                dday = ("0" + dday).slice(-2);
                dhour = ("0" + dhour).slice(-2);
                dmin = ("0" + dmin).slice(-2);
                dsec = ("0" + dsec).slice(-2);
                $('.countdown h2.d span.digits').text(dday);
                $('.countdown h2.h span.digits').text(dhour);
                $('.countdown h2.m span.digits').text(dmin);
                $('.countdown h2.s span.digits').text(dsec);
            }
        },

        feedInterval: null,
        twitterFeedPosition: 0,
        instagramFeedPosition: 0,

        getSocialFeed: function() {
            $.ajax('/api/socialfeed/composite', {
                success: function(data, textStatus, jqXHR) {

                    var twitterFeed = dash.parseData(data.tweets, 'twitter');
                    var instagramFeed = dash.parseData(data.instagram, 'instagram');

                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 1);
                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 2);
                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 3);
                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 4);
                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 5);
                    dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 6);
                    dash.addInstagramFeedItem(instagramFeed[getPosition('instagram')]);
                    $('.feed').animate({
                        opacity: 1
                    });

                    setInterval(function() {
                        $('.feed').animate({
                            opacity: 0
                        }, function() {
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 1);
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 2);
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 3);
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 4);
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 5);
                            dash.addTwitterFeedItem(twitterFeed[getPosition('twitter')], 6);
                            dash.addInstagramFeedItem(instagramFeed[getPosition('instagram')]);
                            $('.feed').animate({
                                opacity: 1
                            });
                        });

                    }, 30000);

                    function getPosition(type) {
                        if(type == 'twitter') {
                            if(dash.twitterFeedPosition == twitterFeed.length-1) {
                                dash.twitterFeedPosition = 0;
                                return 0;
                            } else {
                                return ++dash.twitterFeedPosition;
                            }
                        } else if(type == 'instagram') {
                            if(dash.instagramFeedPosition == instagramFeed.length-1) {
                                dash.instagramFeedPosition = 0;
                                return 0;
                            } else {
                                return ++dash.instagramFeedPosition;
                            }
                        }
                    }
                }
            });
        },

        addTwitterFeedItem: function(item, position) {
            if(!item) {return;}
            var socialItem = $('.feed .twitter.d'+position);
            socialItem.find('.content').html(item.content);
            socialItem.find('.content').parent('a').attr('href', item.link);
            socialItem.find('.network-icon').parent('a').attr('href', item.link);
            socialItem.find('a .content').css({
                'margin-top': -socialItem.find('.content').height()/2
            });
        },

        addInstagramFeedItem: function(item) {
            if(!item) {return;}
            var socialItem = $('.feed .instagram');
            socialItem.addClass('instagram');
            socialItem.find('.network-icon').remove();
            socialItem.find('.instagram-tag').show();
            socialItem.find('.content').html('<img src=\"'+item.image_src.replace('http://', '//')+'\" />');
            socialItem.find('.content').parent('a').attr('href', item.link);
        },

        parseData: function(data, type) {

            var parsedData = [];

            if(type == 'twitter') {
                $.each(data, function(index, item) {
                    parsedData.push({
                        type: 'tweet',
                        content: dash.replaceURLWithHTMLLinks(item.text),
                        timestamp: new Date(Date.parse(item.created_at)),
                        link: 'https://twitter.com/'+item.user.screen_name+'/status/'+item.id_str
                    });
                });
            } else if(type == 'instagram') {
                $.each(data, function(index, item) {
                    parsedData.push({
                        type: 'instagram',
                        image_src: item.images.low_resolution.url,
                        timestamp: new Date(item.created_time * 1000),
                        link: item.link
                    });
                });
            }

            var sorted = _.sortBy(parsedData, function(item) {
                return item.timestamp;
            });

            return sorted;
        },

        replaceURLWithHTMLLinks: function(text) {
            var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            return text.replace(exp, '<a class="url" href="$1" target=\"_blank\">$1</a>');
        },

        initHowToPlay: function() {
            var modal = $('#how-to-play-modal');
            var mobile = info.ismobile ? 'mobile/' : '';
            howToPlaySeq = 1;

            $howToPlayBtn.on('click', this.showHowToPlay);

            modal.find('.toolbar > img').on('click', function() {
                howToPlaySeq = Number(modal.find('.modal-content-ctr').attr('seq'));
                if(howToPlaySeq < 3) {
                    modal.find('.modal-content-ctr > img').attr('src', '/media/'+mobile+'images/dashboard/how-to-play/'+(howToPlaySeq+1)+'.jpg');
                    modal.find('.modal-content-ctr').attr('seq', howToPlaySeq+1);
                    if(info.ismobile) { window.scrollTo(0, 0); }
                    if(howToPlaySeq+1 == 3) {
                        modal.find('.toolbar img').attr('src', '/media/'+mobile+'images/dashboard/how-to-play/ready-btn.png');
                    }
                } else {
                    hideModal(modal, function() {
                        activities.initSpeedbump();
                        return;
                    });
                }
            });

            modal.find('.title .close').on('click', function() {
                hideModal(modal, function() {
                    activities.initSpeedbump();
                });
            });
        },

        showHowToPlay: function() {
            var modal = $('#how-to-play-modal');
            var mobile = info.ismobile ? 'mobile/' : '';

            showModal(modal);
            howToPlaySeq = 1;
            modal.find('.modal-content-ctr').attr('seq', 1);
            modal.find('.modal-content-ctr > img').attr('src', '/media/'+mobile+'images/dashboard/how-to-play/'+howToPlaySeq+'.jpg');
            modal.find('.toolbar img').attr('src', '/media/'+mobile+'images/dashboard/how-to-play/next-btn.png');
            gaEvent('howtoplay');
        },

        markActivityComplete: function(activityType, activityId, points) {
            if(!activityType || !activityId || points < 0) {
                //console.error('markActivityComplete: Missing Parameter');
                return;
            }
            var checkbox = $('.activity[activity-type='+activityType+'][activity-id='+activityId+'] .finished-indicator');
            $('.activity[activity-type='+activityType+'][activity-id='+activityId+']').addClass('completed');
            checkbox.addClass('checked');
            checkbox.text(numberWithCommas(points) + ' pts');
            dash.addPoints(points);
        },

        addPoints: function(pointValue) {

            pointValue = Number(pointValue);

            info.user.total_weekpoints = Number(info.user.total_weekpoints) + pointValue;
            info.user.points_total = Number(info.user.points_total) + pointValue;

            $pointsVal.text(numberWithCommas(info.user.points_total));

            dashboardAnim.drawPoints(info.user.total_weekpoints);
            var notify = $('.notification-qty');
            var notifyQty = Number(notify.text());
            notify.text(++notifyQty);
        },

        initRecruit: function() {
            $('.recruit-ctr .leftarrow, .recruit-ctr .rightarrow').on('click', function() {
                var image = $('.recruit-ctr .network-frame img');
                var platform = image.attr('platform');
                if(platform == 'facebook') {
                    image.attr('src', '/media/images/dashboard/recruit-twitter.png');
                    image.attr('platform', 'twitter');
                } else {
                    image.attr('src', '/media/images/dashboard/recruit-facebook.png');
                    image.attr('platform', 'facebook');
                }
            });
            $('.recruit-ctr .network-frame').on('click', function(e) {
                dash.shareApp($(e.target).attr('platform'));
            });
        },
        updateUserRank: function(rank) {
            if(!info.ismobile)
                $rankVal.text(rank);
        }
    };
})();
var dash = new Dashboard();

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    dash.init();
    gaPage('dashboard');
    
    
    
    
    //localization
    $('toolbar img, .recruit-drivers img').css('cursor','default');
    
});