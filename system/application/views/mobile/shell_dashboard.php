<?php
if(isset($dashboard)) {
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
<nav>
    <div class="rank row">
        <img src="/media/mobile/images/dashboard/menu/your-rank.png" />
        <span>50000</span>
    </div>
    <div class="score row">
        <img src="/media/mobile/images/dashboard/menu/total-score.png" />
        <span>50000</span>
    </div>
    <div class="my-car row button">My Car</div>
    <div class="map-leaderboard row button">Map & Leaderboard</div>
    <div class="how-to row button">How To Play</div>
</nav>

<div id="dashboard" class="full-page-wrapper">
    <div class="header clearfix">
        <div class="notification-qty cta">0</div>
        <img class="nav-btn" src="/media/mobile/images/dashboard/nav-btn.png" />
    </div>

    <div class="all-dashboard-content">
        <div class="dashboard">
            <img class="background" src="/media/mobile/images/dashboard/tach.png" />
            <div class="hello-outer">
                <div class="hello-inner"><?= $firstname ?></div>
            </div>
            <div class="profile-outer">
                <img class="profile-img" src="//graph.facebook.com/<?= $fb_id; ?>/picture?width=200&height=200"/>
            </div>
            <div class="tach score">
                <div class="empty-space"></div>
                <img src="/media/mobile/images/dashboard/score.png">
                <div class="week"></div>
                <div class="points-wrapper">
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
            <div class="empty-space"></div>
            <div class="pts">
                <img src="/media/mobile/images/dashboard/total-score.png" />
                <span></span>
            </div>
        </div>

        <div class="customize-tout">
            <div class="empty-space"></div>
            <div class="car-ctn"></div>
        </div>

        <div class="recruit-ctr">
            <img src="/media/mobile/images/dashboard/recruit-header.png"/>
            <div class="network-frame">
                <img platform="facebook" src="/media/mobile/images/dashboard/recruit-facebook.png"/>
                <img platform="twitter" src="/media/mobile/images/dashboard/recruit-twitter.png"/>
            </div>
        </div>

        <div class="prize">
            <img src="/media/mobile/images/dashboard/prize-week<?php echo $dashboard['user']['week']; ?>.jpg"/>
        </div>

        <div class="modules">
            <img src="/media/mobile/images/dashboard/weekly-activities.png" />

            <?php foreach($dashboard['activities'] as $key => $activity): ?>
                <?php
                $completed = false;
                $disabled = false;
                if(isset($activity['completed']) && $activity['completed'] == 'true') {
                    $completed = true;
                }
                if(isset($activity['tout']) && strpos($activity['tout'], 'disabled') && $activity['activity_type'] == 'youtube') {
                    $disabled = true;
                }
                ?>
                <?php if(isset($activity['tout']) && $activity['activity_type'] != 'speedbump'): ?>
                    <div class="activity <?php if($completed && $activity['activity_type'] != "youtube") { echo "completed"; } ?> <?php if($disabled) { echo "disabled"; } ?>"
                         activity-type="<?php echo $activity['activity_type']; ?>"
                         activity-id="<?php echo $activity['activityid']; ?>"
                         activity-pts="<?php echo $activity['pointvalue']; ?>">
                        <?php if(isset($activity['pointvalue'])): ?>
                            <div class="finished-indicator <?php if($completed) echo "checked"; ?>">
                                <?php echo number_format($activity['pointvalue']); ?> pts
                            </div>
                        <?php endif; ?>
                        <?php $activity['tout'] = str_replace('/media/images', '/media/mobile/images', $activity['tout']); ?>
                        <img src="<?php echo $activity['tout']; ?>" />
                        <div class="inactive">
                            <img src="/media/images/dashboard/activity_lock.png">
                            <div class="clearfix"></div>
                            Coming Soon
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="start-engines">
            <img src="/media/mobile/images/dashboard/countdown.png"/>
            <div class="countdown-ctn">
                <div class="countdown">
                    <div class="timer-ctr">
                        <h2 class="d"><span class="digits"></span><span>:</span></h2>
                        <h2 class="h"><span class="digits"></span><span>:</span></h2>
                        <h2 class="m"><span class="digits"></span><span>:</span></h2>
                        <h2 class="s"><span class="digits"></span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="social-media">
            <div class="module-content">
                <div class="hash"></div>
                <div class="feed">
                    <div class="activity instagram">
                        <a target="_blank">
                            <div class="content"></div>
                        </a>
                        <div class="instagram-tag">Instagram</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="activity twitter d1">
                        <a target="_blank">
                            <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                        </a>
                        <a target="_blank">
                            <div class="content"></div>
                        </a>
                    </div>
                    <div class="activity twitter d2">
                        <a target="_blank">
                            <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                        </a>
                        <a target="_blank">
                            <div class="content"></div>
                        </a>
                    </div>
                    <div class="activity twitter d3">
                        <a target="_blank">
                            <img class="network-icon" src="/media/images/dashboard/twitter.png" />
                        </a>
                        <a target="_blank">
                            <div class="content"></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="empty-space"></div>
        </div>
    </div>
</div>
