<script>
    //called from div.car img "onload" event
    var carsLoaded = 0;
    function carSelectorAssetLoaded(modelNum) {
        if(typeof carSelector !== 'undefined')
            carSelector.carImageLoaded(modelNum);
        else
            carsLoaded++;
    }
</script>
<div id="carselect">
    <div id="carselect-loader-overlay"></div>
    <div class="content-wrapper">
        <div class="content">
            <div class="title">
                <img class="logo" src="/media/mobile/images/carselect/logo.png">
                <img class="choose-your-car" src="/media/mobile/images/carselect/choose_your_car.png">
                <div class="tagline">
                    You won't be able to change your car during the game so choose wisely!
                </div>
            </div>
            <div class="cars-ctn">
                <div class="cars">
                    <?php if ($dashboard['user']['phase'] == 1): ?>
                        <div class="car" id="car-model-3" data-model="3">
                            <img src="/media/assets/2015_Ford_Mustang/111111.png" onload="carSelectorAssetLoaded(3)">
                        </div>
                        <div class="car active unloaded" id="car-model-4" data-model="4">
                            <img src="/media/assets/Sports_GT/111111.png" onload="carSelectorAssetLoaded(4)">
                        </div>
                        <div class="car" id="car-model-5" data-model="5">
                            <img src="/media/assets/VeloSport_MG/111111.png" onload="carSelectorAssetLoaded(5)">
                        </div>
                    <?php endif; ?>
                    <div class="car" id="car-model-0" data-model="0">
                        <img src="/media/assets/GranTorino/111111.png" onload="carSelectorAssetLoaded(0)">
                    </div>
                    <div class="car<?php if($dashboard['user']['phase'] == 2){echo ' active unloaded';}?>" id="car-model-1" data-model="1">
                        <img src="/media/assets/Shelby_GT500/111111.png" onload="carSelectorAssetLoaded(1)">
                    </div>
                    <div class="car" id="car-model-2" data-model="2">
                        <img src="/media/assets/Spyder_XR/111111.png" onload="carSelectorAssetLoaded(2)">
                    </div>
                    <div class="car-titles">
                        <div class="car-titles-inner">
                            <!-- phase 1, all 6-->
                            <?php if ($dashboard['user']['phase'] == 1): ?>
                                <div class="title car-model-3">2015 Ford Mustang</div>
                                <div class="title car-model-4">Sports GT</div>
                                <div class="title car-model-5">Velo Sport MG</div>
                            <?php endif; ?>
                            <div class="title car-model-0">Gran Torino</div>
                            <div class="title car-model-1">Shelby GT500</div>
                            <div class="title car-model-2">Spyder XR</div>
                        </div>
                    </div>
                    <div class="empty-space"></div>
                </div>
            </div>
            <div class="nav" id="carselector-nav">
                <div class="nav-inner">
                    <div class="selector">
                        <div class="empty-space"></div>
                        <div class="selector-inner">
                            <a href="#" class="left"></a>
                            <div class="car-buttons">
                                <div class="car-buttons-inner">
                                    <?php if ($dashboard['user']['phase'] == 1): ?>
                                        <div class="car" data-target="#car-model-3">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/2015_Ford_Mustang/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="car" data-target="#car-model-4">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/Sports_GT/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="car" data-target="#car-model-5">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/VeloSport_MG/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <div class="car" data-target="#car-model-0">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/GranTorino/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="car" data-target="#car-model-1">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/Shelby_GT500/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="car" data-target="#car-model-2">
                                            <div class="car-inner">
                                                <div class="more-car">
                                                    <img src="/media/assets/Spyder_XR/111111.png">
                                                    <div class="empty-space"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="car" data-target="#car-model-0">
                                        <div class="car-inner">
                                            <div class="more-car">
                                                <img src="/media/assets/GranTorino/111111.png">
                                                <div class="empty-space"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="car" data-target="#car-model-1">
                                        <div class="car-inner">
                                            <div class="more-car">
                                                <img src="/media/assets/Shelby_GT500/111111.png">
                                                <div class="empty-space"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="car" data-target="#car-model-2">
                                        <div class="car-inner">
                                            <div class="more-car">
                                                <img src="/media/assets/Spyder_XR/111111.png">
                                                <div class="empty-space"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="empty-space"></div>
                                </div>
                            </div>
                            <a href="#" class="right"></a>
                        </div>
                    </div>
                    <div class="btn-ctr">
                        <img class="accept" src="/media/mobile/images/carselect/accept-btn.png">
                        <img class="speaker" src="/media/images/dashboard/carselect/speaker.png">
                    </div>
                    <div class="clearfix"></div>
                    <a href="http://www.magnaflow.com" target="_blank">
                        <img class="magnaflow" src="/media/images/dashboard/carselect/powered-by-magnaflow.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>