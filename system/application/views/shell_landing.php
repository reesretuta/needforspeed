<div class="logo">
	<img src="/media/images/signup/logo.png"/>
</div>
<div class="in-theaters">
    <img src="/media/images/signup/in-theaters.png"/>
</div>

<div id="landing" class="landing-wrapper wrapper">
    <div class="container">
        <img src="/media/images/signup/landing-mast.png" />

        <div class="buttons">
            <div class="join-ctr">
                <a><img class="join cta" src="/media/images/signup/join-the-race.png"/></a>
                <span class="returning">Returning User? Sign In</span>
            </div>
            <div class="trailer-ctr">
                <a class="trailer various" href="https://www.youtube.com/embed/e73J71RZRn8?showinfo=0" id="watch-trailer">
                    <img class="watch-trailer cta" src="/media/images/signup/watch-trailer.png" />
                </a>
            </div>
        </div>
    </div>
</div>

<div id="reconnect" class="modal wrapper">
    <div class="title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <img src="/media/images/dashboard/quiz/close-btn.png"/>
        </button>
    </div>
    <div class="modal-ctr">
        <img src="/media/images/signup/log-in.png" />
        <div class="content">
            Reconnect your Facebook profile to log in
        </div>
        <div class="toolbar">
            <img class="join cta" src="/media/images/signup/new-user-btn.png" />
            <img class="facebook-connect cta" src="/media/images/signup/facebook-connect.png" />
        </div>
    </div>
</div>

<div id="age-gate" class="modal wrapper">
    <div class="title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <img src="/media/images/dashboard/quiz/close-btn.png"/>
        </button>
    </div>
    <div class="modal-ctr">
        <img class="header" src="/media/images/signup/your-information.png" />

        <form name="register">
            <div class="email-ctr">
                <div class="field-lbl">Email</div>
                <input type="text" name="email" />
                <div class="error">Please enter a valid email address</div>
            </div>
            <div class="dob-ctr">
                <div class="field-lbl">Date of Birth</div>

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
            <div class="clearfix"></div>
            <div class="opt-ins">
                <label>
                    <input type="checkbox" name="terms" />
                    I agree to the <a href="http://disneytermsofuse.com/english/" target='_blank'>Terms of Use</a>
                    and the <a href="/main/rules" target='_blank'>Official Rules</a>
                    for the Race To DeLeon Sweepstakes.
                </label>
                <label>
                    <input type="checkbox" name="weekly" />
                    I agree to the <a href="/main/rules_challenge" target='_blank'>Official Rules</a>
                    for the Race To DeLeon Weekly Challenge (optional).
                </label>
                <div class="info">
                    Upon your first entry into the sweepstakes, you will be receiving Facebook
                    notifications from the “Need For Speed App” throughout the Race To DeLeon Promotion.
                </div>
            </div>
            <div class="clearfix"></div>
        </form>

        <div class="toolbar">
            <img class="submit cta" src="/media/images/signup/facebook-connect.png" />
            <span class="returning">Returning User? Sign In</span>
        </div>
    </div>
</div>

<div id="ineligible" class="modal wrapper">
    <div class="modal-ctr">
        We're sorry, you are ineligible to participate in the race at this time.
    </div>
</div>

<div id="repermission" class="modal wrapper">
    <div class="title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <img src="/media/images/dashboard/quiz/close-btn.png"/>
        </button>
    </div>
    <div class="clearfix"></div>
    <div class="modal-ctr">
        <div class="content">
            <h1>Rules of the Road</h1>
            Welcome back<span class="name"></span>! Please accept the rules to continue.
            <label>
                <input type="checkbox" name="terms" />
                I agree to the <a href="http://disneytermsofuse.com/english/" target='_blank'>Terms of Use</a>
                and the <a href="/main/rules" target='_blank'>Official Rules</a>
                for the Race To DeLeon Sweepstakes.
            </label>
            <label>
                <input type="checkbox" name="weekly" />
                I agree to the <a href="/main/rules_challenge" target='_blank'>Official Rules</a>
                for the Race To DeLeon Weekly Challenge (optional).
            </label>
        </div>
        <div class="toolbar">
            <img class="repermission-submit cta" src="/media/images/signup/submit.png" />
        </div>
    </div>
</div>

<div id="transition" class="modal wrapper">
    <div class="title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <img src="/media/images/dashboard/quiz/close-btn.png"/>
        </button>
    </div>
    <div class="clearfix"></div>
    <div class="modal-ctr">
        <h1>Restart your engines, it's a whole new race</h1>
        <div class="content">
            <img src="/media/images/signup/transition.jpg" />
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
</div>

<div id="sweepstakes" class="modal wrapper">
    <div class="title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <img src="/media/images/dashboard/quiz/close-btn.png"/>
        </button>
    </div>
    <div class="clearfix"></div>
    <div class="modal-ctr">
        <div class="content">
            <h1>You're In!</h1>
            You have been entered into the Need For Speed sweepstakes. We will contact you via email if you're a winner.
            Good luck! You still have a chance to join the Race To DeLeon Weekly Challenge. Please accept the terms to continue.
            A prize is given away every week.
            <label>
                <input type="checkbox" name="weekly" />
                I agree to the <a href="/main/rules_challenge" target='_blank'>Official Rules</a>
                for the Race To DeLeon Weekly Challenge (optional).
            </label>
        </div>
        <div class="toolbar">
            <img class="sweepstakes-submit cta" src="/media/images/signup/join-the-race.png" />
        </div>
    </div>
</div>

<footer>
	<?php require_once('footer.php'); ?>
</footer>
