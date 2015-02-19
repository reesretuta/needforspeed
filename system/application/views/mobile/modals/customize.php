<?php
if($dashboard['user']['car'] != null) {
    $class = "car" . $dashboard['user']['car'];
} else {
    $class = '';
}
?>
<div class="dash-modal <?php echo $class; ?>" id="customize-modal">
    <div class="modal-content">
        <div class="title">
            <img class="close" src="/media/images/dashboard/quiz/close-btn.png" />
        </div>
        <div class="modal-content-ctr" seq="1">
            <div id="customizer-loader-overlay"></div>

            <div class="customize-your-ride">
                <img src="/media/mobile/images/carcustomizer/customize-your-ride.png"/>
            </div>

            <div class="car-ctn">
                <div class="mycar">
                    <div class="shadow"></div>
                    <div class="wheels"></div>
                    <div class="spoiler"></div>
                    <div class="color"></div>
                    <div class="decal"></div>
                    <div class="tint"></div>
                    <div class="empty-space"></div>
                </div>
            </div>


            <div class="detail-ctr">
                <div class="select-bg"></div>
                <select data-category='color'>
                    <option class="cat" disabled value="color" cat="color">Color</option>
                    <option class="cat" disabled value="tint" cat="tint">Tint</option>
                    <option class="cat" disabled value="wheels" cat="wheels">Wheels</option>
                    <option class="cat" disabled value="spoiler" cat="spoiler">Spoiler</option>
                    <option class="cat" disabled value="decal" cat="decal">Decals</option>
                    <option class="cat" disabled value="shadow" cat="shadow">Neon</option>
                </select>

                <div class="modifications">
                    <div class="mod-ctn">
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

            <div class="submit-ctn">
                <img class="apply-changes" src="/media/mobile/images/carcustomizer/apply.png" />
                <img class="speaker" src="/media/images/dashboard/carselect/speaker.png" />
            </div>

            <a href="http://www.magnaflow.com" target="_blank">
                <img class="magnaflow" src="/media/images/dashboard/carselect/powered-by-magnaflow.png" />
            </a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->