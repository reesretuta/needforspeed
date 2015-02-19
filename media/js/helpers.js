if(!window.location.origin) {
    window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
}

function createCookie(name,value,days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires="+date.toGMTString();
    }
    else
        expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}



/***************************************** jQuery Extension *****************************************/
$.fn.extend({
    pulsate: function(fadeOutSpeed,fadeInSpeed,ratio,n,callback){
        if(n > 0) {
            $(this).fadeOut(fadeOutSpeed, function() {
                $(this).fadeIn(fadeInSpeed, function() {
                    $(this).pulsate(fadeOutSpeed*ratio,fadeInSpeed*ratio,ratio,n-1,callback);
                });
            });
        } else if(typeof callback === 'function') {
            callback();
        }
        return $(this);
    },
    transitionClass: function(classString,callback,targetId) {
        this.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e) {

            if(typeof targetId !== 'undefined') {
                if($(e.target).attr("id") == targetId) {
                    $(this).off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                    if(typeof callback === 'function') {
                        callback();
                    }
                }
            } else if(e.target == e.currentTarget) {
                $(this).off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                if(typeof callback === 'function') {
                    callback();
                }
            }
        });
        this.toggleClass(classString);
        return this;
    },
    nextOrFirst: function(selector,parent) {
        var next = this.next(selector);
        return (next.length) ? next : parent ? parent.filter(selector+":first") : this.prevAll(selector).last();
    },
    prevOrLast: function(selector,parent) {
        var prev = this.prev(selector);
        return (prev.length) ? prev : parent ? parent.filter(selector+":last") : this.nextAll(selector).last();
    }
});


/************************************ Loader ************************************/
function getFacebookPictureUrl(facebookId) {
    return '//graph.facebook.com/'+facebookId+'/picture?width=200&height=200';
}
var Semaphore = function(callbackFunc, initLock) {
    if(initLock)
        this.lock=initLock;
    else
        this.lock=0;
    this.func = callbackFunc;
    this.params = null;
};
Semaphore.prototype = {
    call : function() {
        if(this.lock === 0) {
            if(this.func) {
                this.func(this.params);
            }
            return true;
        } else {
            return false;
        }
    },
    acquire : function(num){
        if(typeof num === 'number') {
            this.lock += num;
        } else {
            this.lock++;
        }
        return this.call();
    },
    release : function(num) {
        if(typeof num === 'number') {
            this.lock -= num;

        } else {
            this.lock--;
        }
        return this.call();
    },
    unset : function(){
        this.func = null;
        this.params = null;
    },
    setParams : function(params) {
        this.params = params;
    },
    setFunction : function(callback) {
        this.func = callback;
    }
};
var SoundPlayer = function(files){
    // Singleton
    if (arguments.callee._singletonInstance)
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;


    var me = this;
    var soundOn = true;
    var sounds = {};
    var volume = 0.6;

    if(typeof files !== 'undefined') {
        $.each(files,function(i,file){
            me.add(file);
        });
    }

    this.on = function() {
        soundOn = true;
    };
    this.off = function() {
        soundOn = false;
    };
    this.add = function(filePath) {
        if(typeof sounds[filePath] === 'undefined')
            sounds[filePath] = new Audio(filePath);
    };
    this.play = function(filePath) {
        this.add(filePath);
        if(soundOn) {
            sounds[filePath].volume = volume;
            sounds[filePath].play();
        }
    };

    this.setVolume = function(num) {
        volume = num;
    };
};

function showModal(modal, callback) {
    if(info.ismobile) {
        window.scrollTo(0, 0);
        if(typeof callback === 'function')
            modal.fadeIn({complete: callback});
        else {
            modal.fadeIn();
        }

        $('nav, .full-page-wrapper, footer').addClass('modal-active');
    } else {
        if(typeof callback === 'function') {
            modal.on('shown.bs.modal',function() {
                $(this).off('shown.bs.modal');
                callback();
            });
        }
        modal.modal('show');
    }
}
function hideModal(modal, callback) {
    if(info.ismobile) {
        $('nav, .full-page-wrapper, footer').removeClass('modal-active');
        if(typeof callback === 'function')
            modal.fadeOut({complete: callback});
        else {
            modal.fadeOut();
        }
    } else {
        if(typeof callback === 'function') {
            modal.on('hidden.bs.modal',function() {
                $(this).off('hidden.bs.modal');
                callback();
            });
        }
        modal.modal('hide');
    }
}
function getSoundUrl(modelId) {
    var sound = '';
    switch(parseInt(modelId)) {
        case 0:
            sound = '/media/sounds/Black_generic_Start';
            break;
        case 1:
            sound = '/media/sounds/ShelbyGT500_2013_Start';
            break;
        case 2:
            sound = '/media/sounds/Gold_Generic_Start';
            break;
        case 3:
            sound = '/media/sounds/Mustang_2012_Start';
            break;
        case 4:
            sound = '/media/sounds/ShelbyGT500_Launch_Start';
            break;
        case 5:
            sound = '/media/sounds/Yellow_Generic_Start';
            break;
    }
    sound += ((typeof Modernizr === 'undefined') ? '.mp3' :
        (typeof Modernizr.audio === 'undefined') ? '.mp3' :
                             Modernizr.audio.ogg ? '.ogg' :
                             Modernizr.audio.mp3 ? '.mp3' :
                                                   '.m4a');
    return sound;
}

function getMobilePath(path) {
    return info.ismobile ? path.replace('/media/', '/media/mobile/') : path;
}

function loadMask(element) {
    var $overlay = $('<div class="load-overlay"></div>');
    $(element).append($overlay);
    $overlay.fadeIn(function() {
        spinner = new Spinner({
            color: '#ddd',
            shadow: true
        }).spin($(element).get(0));
    });
}
function removeMask(element) {
    $(element).find('.load-overlay').remove();
    try {
        spinner.stop();
    } catch(e) {
        setTimeout(function() {
            spinner.stop();
        }, 500);
    }
}



$(function(){
    if(typeof info !== 'undefined') {
        if(!info.ismobile) {
            var imagePreloader = new Image();

            //customizer
            imagePreloader.src = '/media/images/dashboard/customize/bg.jpg';
            imagePreloader.src = '/media/images/dashboard/customize/detail-ctr-fill.png';

            //leaderboard
            imagePreloader.src = '/media/images/dashboard/leaderboard/map' + info.user.phase +'.png';
            imagePreloader.src = '/media/images/dashboard/leaderboard/leaderbg-left.png';
            imagePreloader.src = '/media/images/dashboard/leaderboard/leaderbg-middle.png';
            //also add in activity backgrounds
        }
    }
});

