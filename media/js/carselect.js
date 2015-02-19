
//======================================================================================================================
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Das Vroom Vroom Selektor Ya ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//======================================================================================================================

/******************************** Car Selector Object *********************************/
var CarSelector = function() {
    // Singleton
    if (arguments.callee._singletonInstance)
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;

    /********************************** Class Pointers **********************************/
    var carCustomizer, dashboard, player, leaderboard;

    /********************************** Semaphores **********************************/
    var imageLoadLock = new Semaphore(showCarSelector), animationLock = new Semaphore();
    //********************************** Constants ********************************
    var me = this;
    var animationSpeed = 300;
    //******************************** Jquery & DOM Objects  **************************
    var $body;
    var $carSelectionDiv;
    var $carSelectOverlay;

    var $allCars;
    var $carPointers = {};

    var $buttonPointers = {};
    /********************************* Event Listeners ***********************************/
    var $carButtons,$leftArrow,$rightArrow,$acceptBtn;

    /********************************* Private Functions ***********************************/
    function setCarPointers($div) {
        $carPointers.active = ($div)? $div : $allCars.filter(".active:first");

        $carPointers.next = $carPointers.active.nextOrFirst('.car',$allCars).addClass('next');
        $carPointers.prev = $carPointers.active.prevOrLast('.car',$allCars).addClass('prev');
    }

    function setButtonPointers($div) {
        $buttonPointers.active = ($div)? $div : $carButtons.filter(".active:first");

        $buttonPointers.next = $buttonPointers.active.nextOrFirst('.car',$carButtons).addClass('next');
        $buttonPointers.prev = $buttonPointers.active.prevOrLast('.car',$carButtons).addClass('prev');
        $buttonPointers.nextnext = $buttonPointers.next.nextOrFirst('.car',$carButtons).addClass('nextnext');
        $buttonPointers.prevprev = $buttonPointers.prev.prevOrLast('.car',$carButtons).addClass('prevprev');
    }

    function startLoadingDashboard() {
        $body.addClass("carselect");
        $carSelectionDiv.removeClass("active");      //allows the main dashboard to start loading
    }
    function showCarSelector() {
        spinner.stop();         //stop spinner
        $carSelectOverlay.hide(function() {     //hide overlay
            $(this).remove();
            $carSelectionDiv.transitionClass("loaded",function() {
                //animate car coming in from right.
                setTimeout(function() {

                    $carPointers.active.transitionClass("unloaded",function() {
                        startLoadingDashboard();
                    });
                }, 50);
            },"carselector-nav");
        });
        var model = $('.cars .car.active').attr('data-model');
        player.play(getSoundUrl(model));
    }
    function oppositeOfDirection(dir) {
        return (dir == "prev") ? "next" : "prev";
    }
    function animateDiv($div, class1, class2, setAsNewActive) {

        $div.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e) {
            if(e.target == e.currentTarget) {
                $div.off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                $div.removeClass("inmotion");
                if(setAsNewActive) {

                    if(typeof $div.data('model') !== 'undefined') {
                        player.play(getSoundUrl($div.data('model')));
                        setCarPointers($div);
                    } else {
                        setButtonPointers($div);
                    }
                }

                animationLock.release();
            }

        });
        $div.toggleClass(class1 + " inmotion " + class2);
    }
    function animateCars(dir) {
        animationLock.acquire(2);
        var $tempPointers = $.extend({},$carPointers);

        $tempPointers[oppositeOfDirection(dir)].removeClass(oppositeOfDirection(dir));
        animateDiv($tempPointers.active,oppositeOfDirection(dir),'active');
        animateDiv($tempPointers[dir],'active',dir,true);

    }
    function animateButtons(dir) {
        animationLock.acquire(4);
        var $tempPointers = $.extend({},$buttonPointers);

        $tempPointers[new Array(3).join(oppositeOfDirection(dir))].removeClass(new Array(3).join(oppositeOfDirection(dir)));
        animateDiv($tempPointers[oppositeOfDirection(dir)],oppositeOfDirection(dir),new Array(3).join(oppositeOfDirection(dir)));
        animateDiv($tempPointers.active,oppositeOfDirection(dir),'active');
        animateDiv($tempPointers[dir],'active',dir,true);
        animateDiv($tempPointers[new Array(3).join(dir)], dir, new Array(3).join(dir));
    }
    function carSelectScheduler(direction) {
        animateCars(direction);
        animateButtons(direction);
    }
    function setUserCarInfo(modelId,car_mods) {
        info.user.car = modelId.toString();
        info.user.car_mods = car_mods.toString();
        if(typeof carCustomizer === 'undefined' && typeof CarCustomizer === 'function') {
            carCustomizer = new CarCustomizer();
        }

        carCustomizer.setCarModel(modelId);
    }


    //************************ Public Functions & Variables ************************

    this.isActive = function() {
        return $carSelectionDiv.hasClass('in');
    };
    this.carImageLoaded = function() {
        if(imageLoadLock.release()) {
            imageLoadLock.unset();
        }
    };

    this.initVariables = function() {
        carCustomizer = new CarCustomizer();
        dashboard = new Dashboard();
        leaderboard = new Leaderboard();
        player = new SoundPlayer();

        $carSelectionDiv = $("#carselect");
        $body = $("body");
        $carSelectOverlay = $("#carselect-loader-overlay");
        $allCars = $carSelectionDiv.find(".cars .car");

        // Event Listeners
        $carButtons = $carSelectionDiv.find(".car-buttons .car");
        $leftArrow = $carSelectionDiv.find("a.left");
        $rightArrow = $carSelectionDiv.find("a.right");
        $acceptBtn = $carSelectionDiv.find(".accept");

        $allCars.each(function(){
            player.add(getSoundUrl($(this).data('model')));
        });

		$allCars.filter(":nth-child(2)").addClass('active');
		$carButtons.filter(":nth-child(2)").addClass('active');
        setCarPointers();
        setButtonPointers();

        if(typeof carsLoaded !== 'undefined') {
            if(!imageLoadLock.acquire($allCars.length - carsLoaded)) {
                spinner.spin($carSelectOverlay[0]);
            } else {
                imageLoadLock.unset();
            }
        }
    };

    this.initEventListeners = function() {
        $leftArrow.click(function() {
            me.addClickToQueue("prev");
            return false;
        });

        $rightArrow.click(function() {
            me.addClickToQueue("next");
            return false;
        });

        $acceptBtn.click(function(){
            me.submitCar();
            return false;
        });

        $carButtons.click(function(){
            if(!$(this).hasClass('inmotion')) {
                me.addClickToQueue($(this).hasClass('next') ? 'next' : $(this).hasClass('prev') ? 'prev' : '');
            }
        });

        if(typeof Hammer === 'function') {
            Hammer($carSelectionDiv.find('.cars')[0]).on("swipeleft swiperight", function(ev) {
                setTimeout(function() {
                    me.addClickToQueue(ev.type === 'swipeleft' ? 'next' : 'prev');
                }, 50);
            });
            return true;
        }

        $carSelectionDiv.find('.speaker').on('click', function() {
            var model = $('.cars .car.active').attr('data-model');
            player.play(getSoundUrl(model));
        });
    };



    this.addClickToQueue = function(direction) {
        if(animationLock.call() && direction)
            carSelectScheduler(direction);
    };

    this.submitCar = function(modelNum) {
        if(!modelNum) {
            modelNum = $carPointers.active.data('model');
        }
        $.ajax({
            url: "/api/car/model",
            type: "post",
            data: {
                carmodel : modelNum
            },
            success: function(response) {
                if(response.status == "success") {
                    setUserCarInfo(modelNum,response.car_mods);

                    setTimeout(function(){
                        me.hide();
                    }, 300);
                }
            },
            error: function(response) {

            }
        });
    };

    this.hide = function() {
        $body.removeClass("carselect");
        $carSelectionDiv.fadeOut(animationSpeed, function() {
            $(this).remove();
            dashboard.showHowToPlay();
        });
    };
	
	

};

/********************************************* Load Car Assets *******************************************/
var carSelector = new CarSelector();

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    carSelector.initVariables();
    carSelector.initEventListeners();
});