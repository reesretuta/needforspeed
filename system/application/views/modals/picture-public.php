<div class="dash modal fade" id="picture-public-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-show="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="title">
                <h1>
                    <?php
                        if(isset($_GET['caption'])) {
                            echo $_GET['caption'];
                        }
                    ?>
                </h1>
                    <img class="close" src="/media/images/dashboard/quiz/close-btn.png"/>
            </div>
            <div class="clearfix"></div>
            <div class="modal-content-ctr">
                <div class="ctr-content">
                    <img src="<?php echo $_GET['share']; ?>" />
                </div>
            </div>
            <div class="dismiss-ctr">
                <div class="cta">
                    <img src="/media/images/dashboard/activity/sb-spot/join-the-race-btn.png" />
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->