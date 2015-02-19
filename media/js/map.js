//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/******************************************* LEADERBOARD YO **************************************/
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//******************************** Map/pointer Stuff ********************************
var MapPoint = function() {
    // Singleton
    if (arguments.callee._singletonInstance)
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;
};

MapPoint.prototype = (function() {
    var $mapPointWrapper, $mapPoint, $lineContainer, $userCar;

    var week = 0;

    function showLine(callbackFunction) {
        $lineContainer.transitionClass("active",callbackFunction);
    }
    function pulsate(callbackFunction) {
        $mapPoint.pulsate(60,130,0.75,4,callbackFunction);
    }

    return {
        init: function(modal) {
            if(modal) {
                $mapPointWrapper = modal.find(".point-wrapper");
                $mapPoint = modal.find(".point");
            } else {
                $mapPointWrapper = $(".leaderboard .point-wrapper");
                $mapPoint = $(".leaderboard .point");
            }
            $lineContainer = $mapPointWrapper.find(".line-container");
            $userCar = $mapPointWrapper.find(".userCar");
            if(typeof info !== 'undefined') {
                this.setPointerWeek(info.user.week);
            }
            this.hidePointer();
        },
        setPointerWeek: function(weekNum) {
            week = weekNum;
            $mapPointWrapper.addClass("week"+weekNum);

            return this;
        },
        updateUserCar: function(carHtml) {
            $userCar.html(carHtml);
            return this;
        },
        hidePointer: function() {
            $mapPointWrapper.addClass("inactive");
            $mapPoint.hide();

            return this;
        },
        showPointer: function(delay) {
            this.hidePointer();


            setTimeout(function() {
                $mapPointWrapper.transitionClass("inactive", function(){
                    pulsate();
                    showLine(function() {
                        $userCar.transitionClass("active");
                    });
                });
            }, delay);
        }
    };
})();

var Leaderboard = function() {
    // Singleton
    if (arguments.callee._singletonInstance)
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;

    var me = this;
    /************************************ Loader ************************************/
    var leaderSpinner = new Spinner({
        color: '#ddd',
        shadow: true,
        top: 380,
        left: 490
    });

    /************************************ Semaphores ************************************/
    var leadersAnimationLock;
    var showLeadersLock;
    /************************************ Variables ************************************/

    var dashboard;
    var mapPointer;
    var leaderBoard = {};

    var $overlay;
    var modal;

    var $navItems, $positionBox, $weekBox, $weekLeadersHeader, $weekLeadersHeaderImg, $leftArrow, $rightArrow;


    var $leaderPointers = {};
    var $leaderLabelPointers = {};
    var $allLeadersCtn;

    /************************************ Helper Functions ************************************/
    function leaderboardPointsFormat(val,target) {
        var valString = val.toString();
        valString = new Array(target.toString().length - valString.length + 1).join('0').concat(valString);
        return numberWithCommas(valString);
    }
    function formatPosition(num) {
        var lastDigit = parseInt(String(num).slice(-1));
        return num + ((lastDigit > 3)?'th':(lastDigit == 1)?'st':(lastDigit == 2)?'nd':'rd');
    }

    function updateUserInfo(rank) {
        if(typeof dashboard === 'undefined') {
            if(typeof Dashboard === 'function') {
                dashboard = new Dashboard();
                dashboard.updateUserRank(rank);
            } else {
                //wait for script to load
            }
        } else {
            dashboard.updateUserRank(rank);
        }
        me.updateUserRank(rank);
    }
    //******************************** Data Functions ********************************
    function structureLeaderboardData(data) {
        if(data === null)
            return -1;
        if(typeof data.all === 'undefined' || typeof data.rank === 'undefined') {
            return -1;
        }

        var newBoard = {
            'myRank' : {},
            'topLeaders' : {},
            'leadersById' : {}
        };

        $.each(data.all,function(i,leaderData) {

            if(leaderData.weekpoints === null) leaderData.weekpoints = 0;

            if(leaderData.rank <= 5) {
                newBoard.topLeaders[leaderData.rank] = {
                    'name' : leaderData.firstname + " " + leaderData.lastname,
                    'image' : getFacebookPictureUrl(leaderData.fbid),
                    'points' : leaderData.weekpoints,
                    'rank' : leaderData.rank,
                    'id' : leaderData.fbid,
                    'duration' : leaderData.duration_week,
                    'place' : {
                        'myRank' : '',
                        'topLeaders' : leaderData.rank
                    }
                };
                newBoard.leadersById[leaderData.fbid] = newBoard.topLeaders[leaderData.rank];
            } else {
                newBoard.leadersById[leaderData.fbid] = {
                    'rank' : leaderData.rank,
                    'place' : {
                        'myRank' : '',
                        'topLeaders' : ''
                    }
                };
            }
        });

        if(typeof data.personal !== 'undefined') {
            $.each(data.personal, function(i, leaderData) {
                if(leaderData.weekpoints === null) leaderData.weekpoints = 0;
                var myPlace = i + 1, placeOnLeaderboard = '';

                if(leaderData.rank <= 5) {
                    placeOnLeaderboard = leaderData.rank;
                    newBoard.topLeaders[leaderData.rank].place.myRank = myPlace;
                }
                //adjust top leaders too

                newBoard.myRank[i+1] = {
                    'name' : leaderData.firstname + " " + leaderData.lastname,
                    'image' : getFacebookPictureUrl(leaderData.fbid),
                    'points' : leaderData.weekpoints,
                    'rank' : leaderData.rank,
                    'id' : leaderData.fbid,
                    'duration' : leaderData.duration_week,
                    'place' : {
                        'myRank' : myPlace,
                        'topLeaders' : placeOnLeaderboard
                    }
                };
                newBoard.leadersById[leaderData.fbid].place.myRank = myPlace;
            });
        }
        return newBoard;
    }

    //makes ajax call, gets data and calls function to handle new data
    function getLeaderBoardData(week, callback) {
        leadersAnimationLock.lock = 0;
        var delay = 200, wait;
        var now = new Date().getTime();

        if(!week) {
            week =  $weekLeadersHeader.data('week')? $weekLeadersHeader.data('week') : info.user.week;
        }
        $.ajax({
            url: "/api/nfs/leaderboard",
            type: "post",
            data: {
                week: week
            },
            success: function(response) {
                if(typeof response.leaderboard !== 'undefined') {
                    var newBoard = structureLeaderboardData(response.leaderboard);

                    if(typeof callback === 'function') {
                        callback(newBoard);
                    } else {
                        var now2 = new Date().getTime();
                        wait = now2-now;

                        setTimeout(function() {
                            leaderSpinner.stop();
                            $overlay.fadeOut(300);
                            if(typeof info !== 'undefined') {
                                updateUserInfo(newBoard.leadersById[info.user.fbid].rank);
                            }
                            updateOrShowBoard(newBoard);
                        }, (delay - wait < 0) ? 0 : delay - wait);
                    }
                }
            },
            error: function(response,status) {

            }
        });
    }
    //******************************** Animation Functions ********************************
    //adds new leader to the html, returns the jquery object
    function addNewLeader(leaderInfo,classes) {

        var $leader = $($leaderPointers[1][0].outerHTML);

        $leader.find('.name')[0].innerHTML = leaderInfo.name.toUpperCase();   //set name
        $leader.find('.picture > img')[0].src = leaderInfo.image;  //set picture
        $leader.find('.points')[0].innerHTML = leaderInfo.points;
        $leader.removeClass().addClass('leader ' + classes);

        $allLeadersCtn.prepend($leader);
        return $leader;
    }
    function animateInNewLeader(leaderInfo,direction,animationClasses,place) {
        var $newLeader = addNewLeader(leaderInfo,"active "+direction);

        leadersAnimationLock.acquire();
        //for some reason the div doesn't animate moving when this setTimeout is removed
        //I have no idea why, but it stays in.
        setTimeout(function(){
            $newLeader
                .transitionClass(animationClasses,function(){
                    leadersAnimationLock.release();

                }).removeClass(direction).removeClass("gotoplace_"+place);
            $leaderPointers[parseInt(place)] = $newLeader;    //update pointer for nth place to this leader
        }, 0);
    }

    //animate leader off the top or bottom and delete him.
    function removeLeader($leader,direction) {
        leadersAnimationLock.acquire();
        $leader.transitionClass(direction,function() {
            $leader.remove();
            leadersAnimationLock.release();
            }).removeClass(function (index, css) {
            return (css.match (/\bplace_-\S+/g) || []).join(' ');
        });

    }

    function updateLeaderRankLabel(rank,place) {
        $leaderLabelPointers[place].text(rank);
    }

    function rollupPoints($pointsDiv,oldPoints,newPoints) {
        if(typeof oldPoints === 'undefined') oldPoints = 0;
        $({someValue: oldPoints}).animate({someValue: newPoints}, {
            duration: 1500,
            easing:'swing',
            step: function() {  // called on every step
                // Update the element's text with rounded-up value:
                $pointsDiv.text(leaderboardPointsFormat(Math.round(this.someValue),newPoints));
            },
            complete: function() {  //to ensure the value is correct
                $pointsDiv.text(leaderboardPointsFormat(newPoints,newPoints));
            }
        });
    }

    function updateOrShowBoard(newBoard) {
        var $activeNavItem = $navItems.filter('.active');

        if($activeNavItem.length === 0 || Object.keys(leaderBoard).length === 0) {
            mapPointer.showPointer(1000);
            leaderBoard = newBoard;
            hideThenShowNewBoard('myRank');
        } else if($activeNavItem.hasClass('myRank')) {
            updateBoard('myRank',newBoard);
        } else if($activeNavItem.hasClass('topLeaders')) {
            updateBoard('topLeaders',newBoard);
        }
    }

    function showNewLeader($leader, delay, oldPoints, newPoints) {
        leadersAnimationLock.acquire();
        var target = (info.ismobile) ? 'leader-info' : 'middle';

        setTimeout(function() {
            $leader.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e) {
                if(e.target.className == target) {
                    $leader.off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                    leadersAnimationLock.release();
                }
            });
            $leader.addClass('active');
            rollupPoints($leader.find('.points'),oldPoints,newPoints);
        }, delay);
    }

    function hideLeaders() {
        showLeadersLock.acquire(5);
        $.each($leaderPointers, function(index,$leader) {
            $leader.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',function(e) {
                $(this).off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                setTimeout(function() { //short delay
                    showLeadersLock.release();
                },100);
            });
            $leader.removeClass('active');
        });
    }

    function hideThenShowNewBoard(boardType) {

        var $activeNavItem = $navItems.filter('.active');
        if(!$activeNavItem.hasClass(boardType)) {
            $activeNavItem.removeClass('active');
            $navItems.filter('.'+boardType).addClass('active');
        }
        showLeadersLock.setParams(boardType);

        if($leaderPointers[1].hasClass('active') || showLeadersLock.lock > 0) {
            hideLeaders();
        } else {
            showLeadersLock.call();
        }

    }
    function updateBoard(boardType,newBoard) {
        var $oldLeaderPointers = $.extend({}, $leaderPointers);
        $.each(newBoard[boardType],function(place,leader) {
            var oldleaderInfo = leaderBoard.leadersById[leader.id];
            var newClasses = "gotoplace_%num% place_%num%".replace(/%num%/g,place);

            updateLeaderRankLabel(leader.rank,place);

            if(typeof oldleaderInfo === 'undefined') {
                animateInNewLeader(leader,"offscreen-bottom", newClasses, place);
            } else {
                if(!oldleaderInfo.place[boardType]) {
                    animateInNewLeader(leader,
                        (oldleaderInfo.rank < newBoard[boardType][1].rank) ? "offscreen-top" : "offscreen-bottom",
                        newClasses,
                        place
                    );
                } else {
                    if(oldleaderInfo.place[boardType] != place) {  //move to current place
                        leadersAnimationLock.acquire();
                        $oldLeaderPointers[oldleaderInfo.place[boardType]]
                            .transitionClass(newClasses,function(){
                                leadersAnimationLock.release();
                            }).removeClass("place_"+oldleaderInfo.place[boardType])
                            .removeClass("gotoplace_"+place);
                        $leaderPointers[place] = $oldLeaderPointers[oldleaderInfo.place[boardType]];    //update pointer
                    }
                    var $points = $oldLeaderPointers[oldleaderInfo.place[boardType]].find(".points");
                    var oldPoints = $points.html().replace(/,/g, '');

                    rollupPoints($points,oldPoints,leader.points);
                }
            }
        });

        //find old leaders that have either moved up off the board or off the bottom
        $.each(leaderBoard[boardType],function(place,leader) {
            if(!newBoard.leadersById[leader.id].place[boardType]) {
                removeLeader($oldLeaderPointers[place],
                    (newBoard.leadersById[leader.id].rank > newBoard[boardType][1].rank) ?
                        "offscreen-bottom" : "offscreen-top"
                );
            }
        });
        leaderBoard = newBoard;
    }

    function showLeaders(boardType) {

        var delayIncrement = 200;
        $.each(leaderBoard[boardType],function(place,leader){
            place = parseInt(place);
            $leaderPointers[place].find('.name').text(leader.name.toUpperCase());   //set name
            $leaderPointers[place].find('.picture > img').attr('src',leader.image);  //set picture
            $leaderLabelPointers[place].text(leader.rank);       //set new rank
        });

        for(var i=1; i<6; i++) {
            if(typeof leaderBoard[boardType][i] !== 'undefined') {
                var points = parseInt(leaderBoard[boardType][i].points);
                showNewLeader(
                    $leaderPointers[i],
                    (i-1) * delayIncrement,
                    0,
                    points
                );
            }
        }
    }


    function changeWeek(newWeek) {
        var board = $navItems.filter('.active').hasClass('myRank') ? 'myRank' : 'topLeaders';

        showLeadersLock.acquire();
        $overlay.show();
        leaderSpinner.spin($overlay[0]);

        getLeaderBoardData(newWeek, function(newBoard) {
            leaderBoard = newBoard;
            leaderSpinner.stop();
            $overlay.fadeOut(300);
            setTimeout(function(){
                showLeadersLock.release();
            },200);
        });
        hideThenShowNewBoard(board, newWeek);

        me.setWeek(newWeek);
    }

    //******************************** Public Functions ********************************
    this.initialize = function() {
        dashboard = new Dashboard();

        leadersAnimationLock = new Semaphore();
        showLeadersLock = new Semaphore(showLeaders);

        $overlay = $('#leaderboard-overlay');
        modal = $('#map-modal');

        $weekLeadersHeader = $("#leaderboard-week-leaders");
        $weekLeadersHeaderImg = $weekLeadersHeader.find('img.weeklyLeadersHeader');
        $leftArrow = $weekLeadersHeader.find('a.left-arrow');
        $rightArrow = $weekLeadersHeader.find('a.right-arrow');

        $allLeadersCtn = modal.find(".leaders");
        $navItems = modal.find('ul.nav li');
        $positionBox = $navItems.filter(".position").find(".box");
        $weekBox = $navItems.filter(".week").find(".box");


        for(var i=1;i<6;i++) {
            $leaderPointers[i] = $allLeadersCtn.find('.leader.place_'+i);
            $leaderLabelPointers[i] = $allLeadersCtn.find('.leader_rank.place_'+i);
        }

        mapPointer = new MapPoint();
        mapPointer.init(modal);

        this.setWeek(info.user.week);

        /*************************** Event Listeners ***************************/
        modal.find('.close').click(function() {
            me.hideLeaderboard();
            return false;
        });

        $navItems.filter('.myRank').find('a').click(function() {
            if(!$(this).parent().hasClass('active') && leadersAnimationLock.call()) {
                hideThenShowNewBoard('myRank');
            }
            return false;
        });

        $navItems.filter('.topLeaders').find('a').click(function() {
            if(!$(this).parent().hasClass('active') && leadersAnimationLock.call()) {
                hideThenShowNewBoard('topLeaders');
            }
            return false;
        });
		
		modal.find('a.recruit-drivers').on('click',function(){
			dash.shareApp('facebook');
			return false;
		});

        $leftArrow.click(function() {
            if($weekLeadersHeader.data('week') != 1 && leadersAnimationLock.call()) {
                changeWeek($weekLeadersHeader.data('week') - 1);
            }
            return false;
        });
        $rightArrow.click(function() {
            if(parseInt($weekLeadersHeader.data('week')) < parseInt(info.user.week) && leadersAnimationLock.call()) {
                changeWeek($weekLeadersHeader.data('week') + 1);
            }
            return false;
        });
    };

    this.showLeaderboard = function() {
        $overlay.show();
        leaderSpinner.spin($overlay[0]);
        showModal(modal, getLeaderBoardData);
    };

    this.hideLeaderboard = function() {
        hideModal(modal);
    };

    this.updateMapCar = function(carHtml) {
        mapPointer.updateUserCar(carHtml);
    };

    this.updateUserRank = function(rank) {
        $positionBox.text(formatPosition(rank));
    };
    this.setWeek = function(week) {
        week = parseInt(week);
        $weekLeadersHeader.data('week',week);
        $weekLeadersHeaderImg[0].src = '/media/images/dashboard/leaderboard/week' + week + 'leaders.png';
        $weekBox.text(week + '/6');

        if(week < parseInt(info.user.week)) {
            $rightArrow.removeClass('inactive');
        } else {
            $rightArrow.addClass('inactive');
        }

        if(week === 1) {
            $leftArrow.addClass('inactive');
        } else {
            $leftArrow.removeClass('inactive');
        }
    };
};

var leaderboard = new Leaderboard();

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    leaderboard.initialize();
});
