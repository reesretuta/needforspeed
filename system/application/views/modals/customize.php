<?php
if($dashboard['user']['car'] != null) {
    $class = " car" . $dashboard['user']['car'];
} else {
    $class = '';
}
?>
<div class="dash modal fade<?= $class ?>" id="customize-modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="title">
                <img src="/media/images/dashboard/customize/customize-your-ride.png"/>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <img src="/media/images/dashboard/quiz/close-btn.png"/>
                </button>
            </div>
            <div class="modal-content-ctr">
                <div id="customizer-loader-overlay"></div>
                <div class="car-type-ctr">
                    <img class="car-type-header" src="" />
                </div>
                <div class="car-ctn">
                    <div class="mycar">
                        <div class="shadow"></div>
                        <div class="wheels"></div>
						<div class="spoiler"></div>
                        <div class="color"></div>
						<div class="decal"></div>
                        <div class="tint"></div>
					</div> 
                </div>
                <div class="detail-wrapper">
                    <div class="detail-ctr">
                        <div class="cat" cat="color">Color</div>
                        <div class="cat" cat="tint">Tint</div>
                        <div class="cat" cat="wheels">Wheels</div>
                        <div class="cat" cat="spoiler">Spoiler</div>
                        <div class="cat" cat="decal">Decals</div>
                        <div class="cat" cat="shadow">Neon</div>

                        <div class="modifications-wrapper">
                            <div class="modifications-overlay">
                                <div class="bg"></div>
                                <div class="lock">
                                    <img src="/media/images/dashboard/activity_lock.png"/>
                                </div>
                            </div>
                            <div class="modifications">
                                <div class="mod-inner-wrapper clearfix">
                                    <div class="mod-option">
                                        <input id="mod-option-1" type="radio" name="carLayerValue" value="1">
                                        <label for="mod-option-1"></label>
                                        <div class="none"></div>
                                        <div class="color"></div>
                                        <div class="wheel"></div>
                                        <div class="border"></div>
                                        <div class="none-border"></div>
                                    </div>
                                    <div class="mod-option">
                                        <input id="mod-option-2" type="radio" name="carLayerValue" value="2">
                                        <label for="mod-option-2"></label>
                                        <div class="color"></div>
                                        <div class="decal"></div>
                                        <div class="neon"></div>
                                        <div class="border"></div>
                                        <div class="wheel"></div>
                                        <div class="spoiler"></div>
                                        <div class="border"></div>
                                    </div>
                                    <div class="mod-option">
                                        <input id="mod-option-3" type="radio" name="carLayerValue" value="3">
                                        <label for="mod-option-3"></label>
                                        <div class="color"></div>
                                        <div class="decal"></div>
                                        <div class="neon"></div>
                                        <div class="wheel"></div>
                                        <div class="spoiler"></div>
                                        <div class="border"></div>
                                    </div>
                                    <div class="mod-option">
                                        <input id="mod-option-4" type="radio" name="carLayerValue" value="4">
                                        <label for="mod-option-4"></label>
                                        <div class="color"></div>
                                        <div class="decal"></div>
                                        <div class="wheel"></div>
                                        <div class="spoiler"></div>
                                        <div class="border"></div>
                                    </div>
                                    <div class="mod-option">
                                        <input id="mod-option-5" type="radio" name="carLayerValue" value="5">
                                        <label for="mod-option-5"></label>
                                        <div class="color"></div>
                                        <div class="decal"></div>
                                        <div class="spoiler"></div>
                                        <div class="border"></div>
                                    </div>
                                    <div class="mod-option">
                                        <input id="mod-option-6" type="radio" name="carLayerValue" value="6">
                                        <label for="mod-option-6"></label>
                                        <div class="color"></div>
                                        <div class="border"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-ctn">
                    <img class="apply-changes" src="/media/images/dashboard/customize/apply-changes.png" />
                    <img class="speaker" src="/media/images/dashboard/carselect/speaker.png" />
                </div>
            </div>
        </div><!-- /.modal-content -->
        <a href="http://www.magnaflow.com" target="_blank">
            <img class="magnaflow" src="/media/images/dashboard/carselect/powered-by-magnaflow.png" />
        </a>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->