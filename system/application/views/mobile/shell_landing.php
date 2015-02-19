<div class="full-page-wrapper">
    <div class="connect-pages">
        <div id="landing" class="landing-wrapper wrapper active">
            <div class="landing-cell">
                <img class="header" src="/media/mobile/images/signup/race-to-deleon.png" />
                <div class="text">
                    Find out if you have what it takes to win the Race to DeLeon. Join street racer Tobey Marshall
                    (Aaron Paul) on a near impossible cross-country race for revenge. Register now for a chance to win
                    a 2015 Ford Mustang and other weekly prizes.
                </div>
                <div class="buttons">
                    <a href="#" class="join">
                        <img src="/media/mobile/images/signup/join-race.png"/>
                    </a>
                    <a href="https://www.youtube.com/embed/e73J71RZRn8" target="_blank">
                        <img class="watch-trailer" src="/media/images/signup/watch-trailer.png" />
                    </a>
                </div>
                <div class="returning">Returning User? Sign In</div>
            </div>
        </div>

        <div class="age-gate wrapper" id="age-gate">
            <img class="header" src="/media/images/signup/your-information.png"/>
            <form>
                <div class="email-ctr">
                    EMAIL<br/>
                    <input type="email" name="email">
                    <div class="error">Please enter a valid email address</div>
                </div>
                <div class="dob-ctr">
                    <div>Date of Birth</div>

                    <select name="month" class="carbon">
                        <option></option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">Aug</option>
                        <option value="9">Sept</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>

                    <select name="day" class="carbon">
                        <option></option>
                        <?php for($x=1; $x<=31; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php } ?>
                    </select>

                    <select name="year" class="carbon">
                        <option></option>
                        <?php for($x=2014; $x>=1900; $x--) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php } ?>
                    </select>
                    <div class="error">Please enter a valid date of birth</div>
                </div>
                <div class="opt-ins">
                    <div class="error">Please accept the terms to continue</div>
                    <label>
                        <div>
                            <input type="checkbox" name="terms" />
                        </div>
                        <div class="terms">
                            I agree to the <a href="http://disneytermsofuse.com/english/" target="_blank">Terms of Use</a> and the <a href="/main/rules" target="_blank">Official Rules</a> for the Race To DeLeon Sweepstakes.
                        </div>
                    </label>
                    <label>
                        <div>
                            <input type="checkbox" name="weekly" />
                        </div>
                        <div>
                            I agree to the <a href="/main/rules_challenge" target="_blank">Official Rules</a> for the Race To DeLeon Weekly Challenge (optional).
                        </div>
                    </label>
                    <div class="clearfix"></div>
                    <div class="info">
                        Upon your first entry into the sweepstakes, you will be receiving Facebook notifications from the “Need For Speed App” throughout the Race To DeLeon Promotion.
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="connect">
                <img class="submit cta" src="/media/mobile/images/signup/submit.png" />
                <span class="returning">Returning User? Sign In</span>
            </div>
        </div>

        <div id="reconnect" class="wrapper">
            <div class="content">
                <img src="/media/images/signup/log-in.png" /><br/>
                Reconnect your Facebook profile to log in
            </div>
            <div class="toolbar">
                <img class="join cta" src="/media/mobile/images/signup/new-user.png" />
                <img class="facebook-connect cta" src="/media/mobile/images/signup/facebook-connect.png" />
            </div>
        </div>

        <div class="signup wrapper" id="rules">
            <img class="logo" src="/media/mobile/images/logo.png" />
            <div class="description">
                <div class="title">
                    <img src="/media/mobile/images/signup/race-to-deleon.png"/>
                </div>
                <div>
                    <ul>
                        <li>Register now for a chance to win a trip for two to New York & attend a Need For Speed VIP event.</li>
                        <li>Share the trailer via Twitter & Tumblr for an extra chance to win</li>
                        <li>Recruit a friend to be your right seat driver and earn bonus points for access to exclusive <img src="/media/images/signup/ford.png" alt="Ford" /> cars</li>
                    </ul>
                </div>
            </div>
            <div class="connect">
                <a href="#" class="join-race">
                    <img src="/media/images/signup/register.png" />
                </a>
                <span class="returning">Returning User? Sign In</span>
            </div>
        </div>

        <div id="ineligible" class="modal wrapper">
            <div class="modal-ctr">
                We're sorry, you are ineligible to participate in the race at this time.
            </div>
        </div>

        <div id="repermission" class="modal wrapper">
            <div class="modal-ctr">
                <div class="content">
                    <img src="/media/mobile/images/signup/rules-header.png" />
                    <div class="copy">
                        Welcome back<span class="name"></span>! Please accept the rules to continue.
                        <div class="opt-ins">
                            <label>
                                <div>
                                    <input type="checkbox" name="terms" />
                                </div>
                                <div class="terms">
                                    I agree to the <a href="http://disneytermsofuse.com/english/" target="_blank">Terms of Use</a> and the <a href="/main/rules" target="_blank">Official Rules</a> for the Race To DeLeon Sweepstakes.
                                </div>
                            </label>
                            <label>
                                <div>
                                    <input type="checkbox" name="weekly" />
                                </div>
                                <div>
                                    I agree to the <a href="/main/rules_challenge" target="_blank">Official Rules</a> for the Race To DeLeon Weekly Challenge (optional).
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="toolbar">
                    <img class="repermission-submit cta" src="/media/images/signup/submit.png" />
                </div>
            </div>
        </div>

        <div id="transition" class="modal wrapper">
            <div class="content">
                <img class="header" src="/media/mobile/images/signup/transition-header.png" />
                <img src="/media/mobile/images/signup/transition.jpg" />
                <div class="story">
                    <p>
                        Congratulations! As a pre-qualified racer you've earned access to THREE exclusive cars including a
                        Gran Torino and a Shelby. Make your selection now and get ready to start your engines.
                    </p>
                </div>
            </div>
            <div class="toolbar">
                <img class="transition-join cta" src="/media/images/signup/join-the-race.png" />
            </div>
        </div>

        <div id="sweepstakes" class="modal wrapper">
            <div class="content">
                <img class="header" src="/media/mobile/images/signup/sweepstakes-header.png" />
                You have been entered into the Need For Speed sweepstakes. We will contact you via email if you're a winner.
                Good luck! You still have a chance to join the Race To DeLeon Weekly Challenge. Please accept the terms to continue.
                A prize is given away every week.
                <div class="opt-ins">
                    <label>
                        <div>
                            <input type="checkbox" name="weekly" />
                        </div>
                        <div>
                            I agree to the <a href="/main/rules_challenge" target="_blank">Official Rules</a> for the Race To DeLeon Weekly Challenge (optional).
                        </div>
                    </label>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="toolbar">
                <img class="sweepstakes-submit cta" src="/media/images/signup/join-the-race.png" />
            </div>
        </div>
    </div>
</div>
<?php if(isset($ismobile)): ?>
<script>
    var isMobile = <?= $ismobile; ?>;
</script>
<?php endif; ?>