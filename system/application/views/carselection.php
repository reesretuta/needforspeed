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
    <div class="carselect-inner">
        <div class="header">
            <img class="logo" src="/media/images/signup/logo.png">
            <img class="in-theaters" src="/media/images/signup/in-theaters.png">
        </div>
        <div class="title">
            <img src="/media/images/dashboard/carselect/choose_your_car.png">
            <div class="tagline">
                Remember, choose your car wisely - you won’t be able to change it later
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content">
                <div class="bg-overlay"></div>
                <div class="bg-fade">
                    <div class="top"></div>
                    <div class="rest"></div>
                </div>
                <div class="title">
                    <img src="/media/images/dashboard/carselect/choose_your_car.png">
                    <div class="tagline">
                        Remember, choose your car wisely - you won’t be able to change it later
                    </div>
                </div>
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
                </div>
                <div class="nav" id="carselector-nav">
                    <div class="selector clearfix">
                        <a href="#" class="left"></a>
                        <div class="car-buttons">
                            <div class="car-buttons-inner">
                            <?php if ($dashboard['user']['phase'] == 1): ?>
                                <div class="car" data-target="#car-model-3">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/2015_Ford_Mustang/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-4">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/Sports_GT/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-5">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/VeloSport_MG/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>

                            <?php else: ?>
                                <div class="car" data-target="#car-model-0">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/GranTorino/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-1">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/Shelby_GT500/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-2">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/Spyder_XR/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                                <div class="car" data-target="#car-model-0">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/GranTorino/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-1">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/Shelby_GT500/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                                <div class="car" data-target="#car-model-2">
                                    <div class="car-inner">
                                        <div class="img-wrapper">
                                            <img src="/media/assets/Spyder_XR/111111.png">
                                        </div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <a href="#" class="right"></a>
                    </div>
                    <div class="btn-ctr">
                        <img class="accept cta" src="/media/images/dashboard/carselect/accept.png" />
                        <img class="speaker cta" src="/media/images/dashboard/carselect/speaker.png" />
                    </div>
                    <div class="buffer"></div>
                </div>
            </div>
        </div>
        <footer>
            <a href="http://www.magnaflow.com/" target="_blank">
                <img class="magnaflow" src="/media/images/dashboard/carselect/powered-by-magnaflow.png" />
            </a>
            <?php require('footer.php'); ?>
        </footer>
    </div>
</div>