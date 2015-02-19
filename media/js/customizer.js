var CarCustomizer = function() {
    // Singleton
    if (arguments.callee._singletonInstance)
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;

    var me = this;

    var customizerLoader;


    var leaderboard;
    var player;
    /************************************ Semaphore ****************************/
    var categoryLock = new Semaphore();


    //The All Mighty Modal
    var modal;

    var $closeButton,$submitBtn,$modifications;

    var $myCarCtn;
    var $customOverlay;
    var $activeCategory, $activeOption;
    var $options = {};
    var $categories, $enabledCategories;
    var $select;
    var $carTypeImg;

    var myCarSettings;

    var $myCarImgs = {};

    var $customizerTout;


    /*********************************** Private Functions ******************************/
    function categoryIsSelected($target) {
        if(info.ismobile) {
            return $target[0].value == $activeCategory[0].value;
        } else {
            return $target.hasClass('selected');
        }
    }
    function changeCategory(e) {
        var $target;
        if(info.ismobile) {
            if(typeof $enabledCategories[e.target.value] === 'undefined')
                return false;
            $target = $(e.target).find('option:selected');
        } else {
            $target = $(e.target);
        }

        if(categoryLock.call() && !categoryIsSelected($target)) {
            categoryLock.acquire();

            var selectedCat = $target.attr('cat');
            $activeOption = modal.find("input:checked");

            if(!info.ismobile) {
                $target.addClass('selected');
                $activeCategory.removeClass("selected");
            } else {
                $select.attr('data-category',selectedCat);
            }

            $activeCategory = $target;

            if($activeOption[0].value != myCarSettings[selectedCat]) {
                $activeOption[0].checked = false;
                $activeOption = $options[myCarSettings[selectedCat]];
                $activeOption[0].checked = true;
            }

            categoryLock.release();
        }
        return false;
    }

    function commitNewCarSource() {
        leaderboard.updateMapCar(CarCustomizer.myCar[0].outerHTML);
        $customizerTout.html(CarCustomizer.myCar[0].outerHTML);
    }

    function submitChanges() {
        if(typeof info !== 'undefined') {
            var modsString = '' +
                myCarSettings.shadow +
                myCarSettings.wheels +
                myCarSettings.spoiler +
                myCarSettings.color +
                myCarSettings.tint +
                myCarSettings.decal;

            if(info.user.car_mods != modsString) {
                me.showSpinner("submit");

                $.ajax({
                    url: "/api/car/customize",
                    type: "post",
                    data: {
                        mods : modsString
                    },
                    success: function(response) {
                        if(response.status == "success") {
                            info.user.car_mods = modsString;
                            commitNewCarSource();
                        }
                        me.hideSpinner("submit");
                        me.hide();
                    },
                    error: function(response) {
                        me.hideSpinner("submit");
                        me.hide();
                    }
                });
            } else {
                me.hideSpinner("submit");
                me.hide();
            }
        }
        return false;
    }

    function updateCar(target) {
        var category = $activeCategory.attr('cat');
        var mod = target.value;

        if(mod != myCarSettings[category] && typeof me.myCarModel !== 'undefined') {
            if((category == 'decal' || category == 'spoiler') && mod == '1') {
                $myCarImgs[category].attr('src', '');
            } else {
                var img = new Image();
                img.onload = function() {
                    $myCarImgs[category].attr('src', this.src);
                    me.hideSpinner();
                };
                me.showSpinner();
                img.src = '/media/carparts/' + me.myCarModel + '/' + category + '/' + mod +'.png';
            }
            myCarSettings[category] = mod;
        }
        return false;
    }

    function resetAttributes() {
        if(typeof info !== 'undefined') {
            if(info.user.car_mods !== null) {
                var mods = info.user.car_mods.split('');
                myCarSettings.shadow = mods[0];
                myCarSettings.wheels = mods[1];
                myCarSettings.spoiler = mods[2];
                myCarSettings.color = mods[3];
                myCarSettings.tint = mods[4];
                myCarSettings.decal = mods[5];
            }
        }
        return false;
    }

    function setHeader() {
        if(info.user.car !== null) {
            $carTypeImg.attr('src','/media/images/dashboard/customize/titles/'+info.user.car+'.png');
        }
    }
    /*********************************** Public Functions ******************************/
    this.initialize = function() {
        modal = $('#customize-modal');
        $customOverlay = $('#customizer-loader-overlay');

        leaderboard = new Leaderboard();
        player = new SoundPlayer();

        $closeButton = modal.find('.title .close');
        $submitBtn = modal.find('.apply-changes');
        $myCarCtn = modal.find(".car-ctn");
        $carTypeImg = modal.find("img.car-type-header");
        $modifications = modal.find('.modifications input[type=radio]');

        if(info.ismobile) {
            $select = modal.find('.detail-ctr select');
            customizerLoader = new Spinner({
                color: '#ddd',
                shadow: true,
                top: '40%'
            });
        } else {
            customizerLoader = new Spinner({
                color: '#ddd',
                shadow: true,
                top: '250',
                left: '450'
            });
        }


        var week = info.user.week;


        $categories = modal.find('.cat');


        if(typeof info !== 'undefined') {
            if(info.ismobile) {
                $enabledCategories = {};
                var i=0;
                $categories.each(function() {
                    if(i < week) {
                        $enabledCategories[this.value] = this.value;
                        this.disabled = '';
                    } else {
                        switch(this.value) {
                            case 'color':
                                this.innerHTML += ' - Available January 31';
                                break;
                            case 'tint':
                                this.innerHTML += ' - Available February 10';
                                break;
                            case 'wheels':
                                this.innerHTML += ' - Available February 17';
                                break;
                            case 'spoiler':
                                this.innerHTML += ' - Available February 24';
                                break;
                            case 'decal':
                                this.innerHTML += ' - Available March 03';
                                break;
                            case 'shadow':
                                this.innerHTML += ' - Available March 10';
                                break;
                            default:
                                break;
                        }
                    }
                    i++;
                });

            } else {
                $categories.filter(':lt('+week+')').addClass('enabled');
            }
        }


        $modifications.each(function() {
            $options[this.value] = $(this);
        });

        myCarSettings = {
            'color' : 1,
            'shadow' : 1,
            'tint' : 1,
            'spoiler' : 1,
            'wheels' : 1,
            'decal' : 1
        };

        if(!info.ismobile)
            $customizerTout = $(".customize-tout-ctr .car-ctn");
        else
            $customizerTout = $(".customize-tout .car-ctn");

        $activeCategory = $categories.filter(":first");


        /*************************** Event Listeners ******************/


        //hide modal
        $closeButton.on('click', function(){
            me.hide();
        });

        modal.on('shown.bs.modal',function() {
            player.play(getSoundUrl(info.user.car));
        });

        //change category
        if(info.ismobile) {
            $select.change(changeCategory);
            $select.attr('data-category',$activeCategory[0].cat);
        } else {
            $activeCategory.addClass('selected');
            $categories.on('click', changeCategory);
        }

        //reset car source
        modal.on('hidden.bs.modal', resetAttributes);

        //apply and save changes
        $submitBtn.on('click', submitChanges);

        //update preview
        $modifications.click(function(e) {
            if((!info.ismobile && $activeCategory.hasClass('enabled') || (info.ismobile && !$activeCategory.attr('disabled')))) {
                updateCar(this);
            } else {
                e.preventDefault();
            }
        });


        me.buildCar();

        $activeOption = $options[myCarSettings[$activeCategory.attr("cat")]];
        if(typeof $activeOption !== 'undefined')
            $activeOption.click();

        modal.find('.speaker').on('click', function() {
            player.play(getSoundUrl(info.user.car));
        });
    };
	
	
	this.buildCar = function() {

        if(typeof info === 'undefined')
            return;
        if(info.user.car === null || info.user.car_mods === null)
            return;

        resetAttributes();
        setHeader();

		var mods = info.user.car_mods.split("");
		var mymodel = '';
		me.myCarModel = '';
		switch (info.user.car.toString()) {
            case '0':
                mymodel = 'GranTorino';
                break;
            case '1':
                mymodel = 'Shelby_GT500';
                break;
            case '2':
                mymodel = 'Spyder_XR';
                break;
            case '3':
                mymodel = '2015_Ford_Mustang';
                break;
            case '4':
                mymodel = 'Sports_GT';
                break;
            case '5':
                mymodel = 'VeloSport_MG';
                break;
		}
		
		me.myCarModel = mymodel;

        var decal,tint,base,spoiler,wheels,shadow;
		tint = '/media/carparts/'+mymodel+'/tint/'+mods[4]+'.png';
		base = '/media/carparts/'+mymodel+'/color/'+mods[3]+'.png';
		wheels = '/media/carparts/'+mymodel+'/wheels/'+mods[1]+'.png';
        shadow = '/media/carparts/'+mymodel+'/shadow/'+mods[0]+'.png';

        if(mods[2] !== '1')
            spoiler = '/media/carparts/'+mymodel+'/spoiler/'+mods[2]+'.png';
        else
            spoiler = '';
        if(mods[5] !== '1')
            decal = '/media/carparts/'+ mymodel+'/decal/'+mods[5]+'.png';
        else
            decal = '';


		var mycar = $("<div class=mycar><div class='shadow'><img /></div><div class='wheels'><img /></div><div class='spoiler'><img /></div><div class='color'><img /></div><div class='tint'><img /></div><div class='decal'><img /></div>");


        if(typeof info !== 'undefined') {
            if(info.ismobile) {
                mycar.append('<div class="empty-space"></div>');
            }
        }

        var carLoadingLock = new Semaphore(commitNewCarSource);
        function imageLoaded() {
            carLoadingLock.release();
        }

        carLoadingLock.acquire(4);
        $myCarImgs.decal = mycar.find('.decal > img');
        if(decal !== '') {
            carLoadingLock.acquire();
            $myCarImgs.decal[0].onload = imageLoaded;
        }
        $myCarImgs.decal[0].src = decal;

        $myCarImgs.tint = mycar.find('.tint > img');
        $myCarImgs.tint[0].onload = imageLoaded;
        $myCarImgs.tint[0].src = tint;

        $myCarImgs.color = mycar.find('.color > img');
        $myCarImgs.color[0].onload = imageLoaded;
        $myCarImgs.color[0].src = base;

        $myCarImgs.spoiler = mycar.find('.spoiler > img');
        if(spoiler !== '') {
            carLoadingLock.acquire();
            $myCarImgs.spoiler[0].onload = imageLoaded;
        }
        $myCarImgs.spoiler[0].src = spoiler;

        $myCarImgs.wheels = mycar.find('.wheels > img');
        $myCarImgs.wheels[0].onload = imageLoaded;
        $myCarImgs.wheels[0].src = wheels;

        $myCarImgs.shadow = mycar.find('.shadow > img');
        $myCarImgs.shadow[0].onload = imageLoaded;
        $myCarImgs.shadow[0].src = shadow;

        CarCustomizer.myCar = mycar;

		$myCarCtn.html(CarCustomizer.myCar);
		
	};

    this.setCarModel = function(carId) {
        modal.addClass('car'+carId);
        if(typeof info !== 'undefined')
            info.user.car = carId;
        me.buildCar();

    };

    /*********************************** Loading Functions ******************************/
    this.show = function() {
        showModal(modal, function() {
            player.play(getSoundUrl(info.user.car));
        });
    };
    this.hide = function() {
        hideModal(modal);
    };

    this.showSpinner = function(overlayClass) {
        if(typeof overlayClass === 'undefined') {
            overlayClass = 'active';
        }
        $customOverlay.addClass(overlayClass);
        customizerLoader.spin($customOverlay[0]);
    };
    this.hideSpinner = function(overlayClass) {
        if(overlayClass === null) {
            overlayClass = 'active';
        }
        $customOverlay.removeClass(overlayClass);
        customizerLoader.stop();
    };
};
var customizer = new CarCustomizer();

if(typeof executeOnLoad === 'undefined') {
    var executeOnLoad = [];
}
executeOnLoad.push(function(){
    customizer.initialize();
});