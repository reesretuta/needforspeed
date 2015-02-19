<div class="dash-modal" id="map-modal">
    <div class="modal-content leaderboard">
        <div class="title">
            <img class="close" src="/media/images/dashboard/quiz/close-btn.png" />
        </div>
        <div class="modal-content-ctr" seq="1">
            <div class="map week-<?= $dashboard['user']['week'] ?>">
                <div class="empty-space"></div>
                <div class="point-wrapper">
                    <div class="empty-space"></div>
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

            <div class="header">
                <div class="week-title clearfix" id="leaderboard-week-leaders" data-week="<?= $dashboard['user']['week'] ?>">
                    <a href="#" class="left-arrow"></a>
                    <div class="weeklyLeadersWrapper">
                        <img class="weeklyLeadersHeader"/>
                    </div>
                    <a href="#" class="right-arrow"></a>
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
                </ul>
            </div>

            <div class="content">
                <div class="leaders" id="leaders">
                    <div class="leader place_1">
                        <div class="leader-info">
                            <div class="leader-info-inner clearfix">
                                <div class="left"></div>
                                <div class="middle">
                                    <div class="middle-inner">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                        <div class="middle-repeat">
                                            <div class="empty-space"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="middle-right"></div>
                                    </div>
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
                        <div class="empty-space"></div>
                    </div>
                    <div class="leader place_2">
                        <div class="leader-info">
                            <div class="leader-info-inner clearfix">
                                <div class="left"></div>
                                <div class="middle">
                                    <div class="middle-inner">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                        <div class="middle-repeat">
                                            <div class="empty-space"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="middle-right"></div>
                                    </div>
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
                        <div class="empty-space"></div>
                    </div>
                    <div class="leader place_3">
                        <div class="leader-info">
                            <div class="leader-info-inner clearfix">
                                <div class="left"></div>
                                <div class="middle">
                                    <div class="middle-inner">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                        <div class="middle-repeat">
                                            <div class="empty-space"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="middle-right"></div>
                                    </div>
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
                        <div class="empty-space"></div>
                    </div>
                    <div class="leader place_4">
                        <div class="leader-info">
                            <div class="leader-info-inner clearfix">
                                <div class="left"></div>
                                <div class="middle">
                                    <div class="middle-inner">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                        <div class="middle-repeat">
                                            <div class="empty-space"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="middle-right"></div>
                                    </div>
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
                        <div class="empty-space"></div>
                    </div>
                    <div class="leader place_5">
                        <div class="leader-info">
                            <div class="leader-info-inner clearfix">
                                <div class="left"></div>
                                <div class="middle">
                                    <div class="middle-inner">
                                        <div class="fadeOut"></div>
                                        <div class="name"></div>
                                        <div class="points"></div>
                                        <div class="middle-repeat">
                                            <div class="empty-space"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="middle-right"></div>
                                    </div>
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
                        <div class="empty-space"></div>
                    </div>
                    <div class="leader_rank place_1"></div>
                    <div class="leader_rank place_2"></div>
                    <div class="leader_rank place_3"></div>
                    <div class="leader_rank place_4"></div>
                    <div class="leader_rank place_5"></div>
                </div>

                <a class="recruit-drivers" href="#">
                    <img src="/media/images/dashboard/leaderboard/recruit-drivers.png"/>
                </a>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->