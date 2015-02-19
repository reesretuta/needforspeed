<?php



if(isset($dashboard)) {
	if ($dashboard['user']['car'] == null) {
		$carSelected = false;
	} else {
		$carSelected = true;
	}
    $firstname = $dashboard['user']['firstname'];
    $fb_id = $dashboard['user']['fbid'];
} else {
    $firstname = 'Jessica';
    $fb_id = '1202043';
}

?>
	<?php
	if (isset($dashboard['carselection'])) {
		echo $dashboard['carselection'];
        unset($dashboard['carselection']);
	}
	?>

    <?php
        foreach($dashboard['activities'] as $activity) {
            if($activity['activity_type'] == 'speedbump' && !isset($activity['speedbump_completed'])) {
                require_once("./system/application/views/modals/speedbump.php");
            }
        }
    ?>

    <header>
        <div class="top">
            <img src="/media/images/dashboard/toolbar/header-<?= $dashboard['user']['week'] ?>.png" usemap="#header" />
            <map name="header">
                <area shape="rect" coords="927,30,1032,85" href="http://ford.com" target="_blank" />
            </map>
        </div>

        <div class="toolbar">
            <div class="toolbar-ctr">

                <div class="pull-right">
                    <img src="/media/images/dashboard/toolbar/divider.png" />
                    <img class="rank-val-lbl" src="/media/images/dashboard/toolbar/your-rank.png" />
                    <div class="rank-val"></div>
                    <img src="/media/images/dashboard/toolbar/divider.png" />
                    <img class="points-val-lbl" src="/media/images/dashboard/toolbar/total-points.png" />
                    <div class="points-val"></div>
                    <img src="/media/images/dashboard/toolbar/divider.png" />
                </div>

                <img src="/media/images/dashboard/toolbar/divider.png" />
                <a class="how-to-play-btn">HOW TO PLAY</a>
                <img src="/media/images/dashboard/toolbar/divider.png" />
                <a class="view-map-btn">VIEW MAP & LEADERBOARD</a>
                <img src="/media/images/dashboard/toolbar/divider.png" />
                <div class="notification-qty cta">0</div>
                <div class="pin"></div>
                <div class="notification-well">
                    <div class="notify-head">
                        Recent Activity
                    </div>
                    <div class="notify-content">
                        <div class="notify-item">
                            No activities completed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
	<div id="dashboard" class="week-<?= $dashboard['user']['week'] ?>">
        <div class="dashboard-ctr">
            <div class="tacometer-section clearfix">
                <div class="recruit-ctr col">
                    <div class="arrow">
                        <a href="#" class="leftarrow">
                            <img class="left-arrow" src="/media/images/dashboard/crew_arrow_left.png" />
                        </a>
                    </div>
                    <div class="network-frame cta">
                        <img platform="facebook" src="/media/images/dashboard/recruit-facebook.png" />
                    </div>
                    <div class="arrow">
                        <a href="#" class="rightarrow">
                            <img class="right-arrow" src="/media/images/dashboard/crew_arrow_right.png" />
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="crew-size">RECRUIT YOUR CREW</div>
                </div>
                <div class="tacometer-ctr col">
                    <div class="tach base">
                        <img src="/media/images/dashboard/tach_base2.png" />
                        <div class="tach fill">
                            <div class="tach guage">
                                <div class="tach greeting">Hi, <?= $firstname ?></div>

                                <div class="tach cover">
                                    <img src="/media/images/dashboard/tach_cover2.png" />

                                    <div class="tach profile-img">
                                        <img class="profile-img" src="//graph.facebook.com/<?= $fb_id ?>/picture?width=200&height=200" />
                                    </div>

                                    <div class="tach score">
                                        <div class="week"></div>
                                        <div class="points-ctr">
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                            <div class="digit">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="crew-ctr col">
                   <div class="arrow">
                       <a href="#" class="leftcrew">
                           <img class="left-arrow" src="/media/images/dashboard/crew_arrow_left.png" />
                       </a>
                   </div>
                   <div class="crew-frame">
                       <img class="profile-img" src="/media/images/dashboard/sample_profile_img.jpg" />
                   </div>
                   <div class="arrow">
                       <a href="#" class="rightcrew">
                           <img class="right-arrow" src="/media/images/dashboard/crew_arrow_right.png" />
                       </a>
                   </div>
                    <div class="clearfix"></div>
                   <div class="crew-size"><span>0</span> FRIENDS RECRUITED</div>
               </div>
            </div>


            <div class="carousel-section clearfix">
                <div class="carousel-ctr">
                    <img src="/media/images/dashboard/prize-week<?= $dashboard['user']['week'] ?>.jpg" />
                </div>
                <div class="customize-tout-ctr">
                    <div class="car-ctn"></div>
                    <div class="car-type-text"><?php if($dashboard['user']['car'] != null) {echo '';} ?></div>
                </div>
            </div>


            <div class="tout-row clearfix">
                <?php
                    $dash = $dashboard;
                    $heroActivityObj = $dash['activities'][0];
                    unset($dash['activities'][0]);

                    $completed = false;
                    $disabled = false;
                    if(isset($heroActivityObj['completed']) && $heroActivityObj['completed'] == 'true') {
                        $completed = true;
                    }
                    if(strpos($heroActivityObj['tout'], 'disabled')) {
                        $disabled = true;
                    }
                ?>
                <div class="activity hero cta <?php if($disabled) { echo "disabled"; } ?>"
                        activity-type="<?php echo $heroActivityObj['activity_type']; ?>"
                        activity-id="<?php echo $heroActivityObj['activityid']; ?>"
                        activity-pts="<?php echo $heroActivityObj['pointvalue']; ?>">
                    <div class="inactive">
                        <img src="/media/images/dashboard/activity_lock.png">
                        <div class="clearfix"></div>
                        Coming Soon
                    </div>
                    <img src="<?php echo $heroActivityObj['tout']; ?>" />
                    <?php if(isset($heroActivityObj['pointvalue'])): ?>
                        <div class="finished-indicator <?php if($completed) echo "checked"; ?>">
                            <?php echo number_format($heroActivityObj['pointvalue']); ?> pts
                        </div>
                    <?php endif; ?>
                </div>
                <div class="prize-tout">
                    <a href="http://ford.com" target="_blank">
                        <img src="/media/images/dashboard/prize-tout.jpg" />
                    </a>
                </div>
            </div>


            <div class="grid-section">
                <div class="activity-grid-ctr <?php echo "week".$dash['user']['week']; ?>">
					<?php foreach($dash['activities'] as $key => $activity): ?>
                        <?php
                            $completed = false;
                            if(isset($activity['completed']) && $activity['completed'] == 'true') {
                                $completed = true;
                            }
                        ?>
                        <?php if(isset($activity['tout']) && $activity['activity_type'] != 'speedbump'): ?>
                        <div class="activity <?php if($completed) { echo "completed"; } ?>"
                                activity-type="<?php echo $activity['activity_type']; ?>"
                                activity-id="<?php echo $activity['activityid']; ?>"
                                activity-pts="<?php echo $activity['pointvalue']; ?>">
                            <img src="<?php echo $activity['tout']; ?>" />
                            <?php if(isset($activity['pointvalue'])): ?>
                                <div class="finished-indicator <?php if($completed) echo "checked"; ?>">
                                    <?php echo number_format($activity['pointvalue']); ?> pts
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
					<?php endforeach; ?>
                </div>
                <div class="social-grid-ctr">
                    <div class="countdown">
                        <div class="timer-ctr">
                            <h2 class="d"><span class="digits"></span><span>:</span></h2>
                            <h2 class="h"><span class="digits"></span><span>:</span></h2>
                            <h2 class="m"><span class="digits"></span><span>:</span></h2>
                            <h2 class="s"><span class="digits"></span></h2>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="hash"></div>
                    <div class="feed">
                        <div class="activity instagram">
                            <a target="_blank">
                                <div class="content"></div>
                            </a>
                            <div class="instagram-tag">Instagram</div>
                        </div>
                        <div class="activity twitter d1">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                        <div class="activity twitter d2">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                        <div class="activity twitter d3">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                        <div class="activity twitter d4">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                        <div class="activity twitter d5">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                        <div class="activity twitter d6">
                            <a target="_blank" >
                                <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                            </a>
                            <a target="_blank" >
                                <div class="content"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <footer class="dashboard">
        <?php require('footer.php'); ?>
    </footer>

	<?php if(isset($dashboard)): ?>
	<script type="text/javascript" charset="utf-8">
	var info = <?= json_encode($dashboard); ?>;
	var access_token = <?= json_encode($access_token); ?>;
	</script>
	<?php endif; ?>