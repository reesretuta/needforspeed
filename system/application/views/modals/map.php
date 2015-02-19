<div class="dash modal fade week<?= $dashboard['user']['week'] ?>" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content leaderboard">
            <div class="title">
                <img src="/media/images/dashboard/leaderboard/header.png"/>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <img src="/media/images/dashboard/quiz/close-btn.png"/>
                </button>
            </div>
            <div class="content-wrapper">
                <div class="header">
                    <div class="title">
                        <div class="information">
                            Use this display to stay up to speed. The leader board on the left shows your ranking and
                            point total, while the map tracks your progress throughout the week. The highest scoring
                            racer receives a prize every week; runners-up may be eligible as well. The more friends you
                            invite to play, the more points you’ll earn.
                        </div>
                        <div id="leaderboard-week-leaders" class="clearfix" data-week="<?= $dashboard['user']['week'] ?>">
                            <a href="#" class="left-arrow"></a>
                            <img class="weeklyLeadersHeader"/>
                            <a href="#" class="right-arrow"></a>
                        </div>
                    </div>
                    <ul class="nav">
                        <li class="myRank">
                            <a href="#">
                                <div class="text">MY RANK</div>
                                <div class="underline"></div>
                            </a>
                        </li>
                        <li class="topLeaders">
                            <a href="#">
                                <div class="text">TOP 5</div>
                                <div class="underline"></div>
                            </a>
                        </li>
                        <li class="regional-map">
                            <div class="text">REGIONAL MAP</div>
                            <div class="box long">UNITED STATES</div>
                        </li>
                        <li class="position">
                            <div class="text">POSITION</div>
                            <div class="box medium"></div>
                        </li>
                        <li class="week">
                            <div class="text">WEEK</div>
                            <div class="box short"></div>
                        </li>
                    </ul>
                </div>
                <div class="content clearfix">
                    <a class="recruit-drivers" href="#">
                        <img src="/media/images/dashboard/leaderboard/recruit-drivers.png"/>
                    </a>
                    <div class="leaders-wrapper">
                        <div class="leaders" id="leaders">
                            <div class="leader place_1">
                                <div class="leader-info clearfix">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                    </div>
                                    <div class="right">
                                        <div class="picture">
                                            <img />
                                        </div>
                                    </div>
                                    <div class="slanted-shadow"></div>
                                    <div class="shadow"></div>
                                </div>
                            </div>
                            <div class="leader place_2">
                                <div class="leader-info clearfix">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                    </div>
                                    <div class="right">
                                        <div class="picture">
                                            <img />
                                        </div>
                                    </div>
                                    <div class="slanted-shadow"></div>
                                    <div class="shadow"></div>
                                </div>
                            </div>
                            <div class="leader place_3">
                                <div class="leader-info clearfix">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                    </div>
                                    <div class="right">
                                        <div class="picture">
                                            <img />
                                        </div>
                                    </div>
                                    <div class="slanted-shadow"></div>
                                    <div class="shadow"></div>
                                </div>
                            </div>
                            <div class="leader place_4">
                                <div class="leader-info clearfix">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                    </div>
                                    <div class="right">
                                        <div class="picture">
                                            <img />
                                        </div>
                                    </div>
                                    <div class="slanted-shadow"></div>
                                    <div class="shadow"></div>
                                </div>
                            </div>
                            <div class="leader place_5">
                                <div class="leader-info clearfix">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                    </div>
                                    <div class="right">
                                        <div class="picture">
                                            <img />
                                        </div>
                                    </div>
                                    <div class="slanted-shadow"></div>
                                    <div class="shadow"></div>
                                </div>
                            </div>
                            <div class="leader_rank place_1"></div>
                            <div class="leader_rank place_2"></div>
                            <div class="leader_rank place_3"></div>
                            <div class="leader_rank place_4"></div>
                            <div class="leader_rank place_5"></div>
                        </div>
                    </div>

                    <div class="map-wrapper">
                        <div class="points"></div>
                        <div class="map">
                            <div class="point-wrapper">
                                <div class="box">
                                    <div class="shadow">
                                        <div class="point"></div>
                                    </div>
                                    <div class="line-container">
                                        <div class="line-ctn-inner">
                                            <div class="line"></div>
                                        </div>
                                        <div class="userCar">
                                            <div class="shadow"></div>
                                            <div class="wheels"></div>
                                            <div class="spoiler"></div>
                                            <div class="color"></div>
                                            <div class="decal"></div>
                                            <div class="tint"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="leaderboard-overlay"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->