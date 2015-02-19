$(function() {
    var $quiz = $(".quiz");
    var $quizModal = $("#quiz-modal");
    var footerDOM = document.getElementById('quiz-footer');
    var $submit = $quizModal.find(".submit-btn");
    var $photoAnswer = $quizModal.find("div.media img.answer");
    var submitted = false;
    var resultMsg = $quizModal.find('.result-message');
    var activityObj;

    /************************************ Loader ************************************/
    var quizSpinner = new Spinner({
        color: '#ddd',
        shadow: true
    });
    /************************************ Overlay Functions ************************************/
    var closeOverlay = function() {
        hideModal($quizModal);
        stopSpinner();
        return false;
    };

    function startSpinner() {
        if(!submitted) {
            quizSpinner.spin(footerDOM);
        }
    }
    function stopSpinner() {
        submitted = true;
        quizSpinner.stop();
    }

    /************************************ Photo/Quiz Functions ************************************/
    function resetOverlay(quizType) {
        if(quizType == "photo")
            $quiz.removeClass("text").addClass("photo");
        else
            $quiz.removeClass("photo").addClass("text");

        $photoAnswer.removeClass("active");
        $quizModal.find("input:radio").removeClass("correct incorrect").attr('disabled',false).prop('checked', false);
        resultMsg.hide();
        $quizModal.find('.submit-btn').css({
            display: 'block'
        });
        showModal($quizModal);
    }
    var openPhotoTrivia = function() {
        submitted = false;
        resetOverlay("photo");
        activityObj = activities.findActivity($(this).attr('activity-type'), $(this).attr('activity-id'));
        $('.photo .media .hint').attr('src', activityObj.img_small);
        getPhotoTriviaQuestions();
        return false;
    };
    var openQuiz = function() {
        submitted = false;
        resetOverlay("quiz");
        activityObj = activities.findActivity($(this).attr('activity-type'), $(this).attr('activity-id'));
        //get information from server to set up quiz including questions & possible answers
        getQuizQuestions();
        return false;
    };


    function checkQuizAnswers(answer1, answer2, answer3) {
        $.ajax('/api/activity/texttrivia', {
            type: 'POST',
            data: {
                aid: activityObj.activityid,
                a1: answer1.toLowerCase(),
                a2: answer2.toLowerCase(),
                a3: answer3.toLowerCase()
            },
            complete: function(response, status) {
                stopSpinner();
                if(status == 'error') {
                    showMsg('Connection error. Please try again later.');
                    return;
                }
                if(response.responseJSON.answer) {
                    if(response.responseJSON.correct_count > 0) {
                        showMsg('Way to go! You get '+numberWithCommas(response.responseJSON.earned)+' points.');
                    } else {
                        showMsg('Better luck next time.');
                    }
                    dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, response.responseJSON.earned);
                    for(var a=0; a<3; a++) {
                        var checkedRadio = $quizModal.find('div.content.text input[name=q'+(a+1)+'-Answer]:checked');
                        var answer = response.responseJSON.answer[a].toUpperCase();
                        if(checkedRadio.attr('value') != answer) {
                            $quizModal.find('div.content.text input[name=q'+(a+1)+'-Answer][value='+answer+']').addClass('incorrect');
                        }
                    }
                }
            }
        });
    }

    function getQuizQuestions(){
        //simulate calling php script from ajax
        //when information is returned, hide loader gif and fade in content
        //do this by adding "active" to #quiz, css should handle the rest.

        for(var q=0; q<activityObj.questions.length; q++) {
            $quizModal.find('.text .question.q'+(q+1)).text((q+1)+'. '+activityObj.questions[q].question);
            for(var a=0; a<activityObj.questions[q].answers.length; a++) {
                var letters = ['A', 'B', 'C', 'D'];
                $quizModal.find('.text .answers label[for=q'+(q+1)+'-'+letters[a]+']').text(letters[a]+'. '+activityObj.questions[q].answers[a]);
            }
        }
    }

    function checkPhotoTriviaAnswers(userAnswer) {
        var results = [];

        $.ajax('/api/activity/phototrivia', {
            type: 'POST',
            data: {
                aid: activityObj.activityid,
                a: userAnswer.toLowerCase()
            },
            complete: function(response, status) {
                stopSpinner();
                if(status == 'error') {
                    showMsg('Connection error. Please try again later.');
                    return;
                }

                if(response.responseJSON.answer) {
                    results[0] = response.responseJSON.answer;
                    if(userAnswer == response.responseJSON.answer.toUpperCase()) {
                        results[0] = 'Correct';
                        showMsg('Way to go! You get '+numberWithCommas(activityObj.pointvalue)+' points.');
                        dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, activityObj.pointvalue);
                    } else {
                        showMsg('Better luck next time.');
                        var checkedRadio = $quizModal.find('div.content.photo input:checked');
                        var answer = response.responseJSON.answer.toUpperCase();
                        if(checkedRadio.attr('value') != answer) {
                            $quizModal.find('div.content.photo input[value='+answer+']').addClass('incorrect');
                        }
                        $quizModal.find('.photo input[type=radio][value='+response.responseJSON.answer+']:not(checked)').addClass('incorrect');
                        dash.markActivityComplete(activityObj.activity_type, activityObj.activityid, 0);
                    }
                    $photoAnswer.attr("src", response.responseJSON.img_large).css({
                        opacity: 1
                    });
                }
            }
        });

        return results;
    }

    function getPhotoTriviaQuestions() {
        //simulate calling php script from ajax
        //when information is returned, hide loader gif and fade in content
        //do this by adding "active" to #quiz, css should handle the rest.
        $quizModal.find('.photo .question.q1').text(activityObj.question);
        $quizModal.find('.photo .answers label[for=photo-q1-A]').text('A. '+activityObj.a);
        $quizModal.find('.photo .answers label[for=photo-q1-B]').text('B. '+activityObj.b);
        $quizModal.find('.photo .answers label[for=photo-q1-C]').text('C. '+activityObj.c);
        $quizModal.find('.photo .answers label[for=photo-q1-D]').text('D. '+activityObj.d);
    }



    function submitQuizAnswers() {
        if(!isFormValid($('.text'))) {
            return;
        }

        $submit.fadeOut(200,function(){
            $(this).addClass("inactive");
            $(this).removeAttr("style");
            startSpinner();
        });

        var answers = [];
        answers.q1 = $quizModal.find('.text input[name=q1-Answer]:checked').val();
        answers.q1 = ((typeof answers.q1 === 'undefined')? "":answers.q1);

        answers.q2 = $quizModal.find('.text input[name=q2-Answer]:checked').val();
        answers.q2 = ((typeof answers.q2 === 'undefined')? "":answers.q2);

        answers.q3 = $quizModal.find('.text input[name=q3-Answer]:checked').val();
        answers.q3 = ((typeof answers.q3 === 'undefined')? "":answers.q3);

        checkQuizAnswers(answers.q1,answers.q2,answers.q3);
    }

    function submitPhotoAnswers() {
        if(!isFormValid($('.photo'))) {
            return;
        }

        $submit.fadeOut(200,function(){
            $(this).addClass("inactive");
            $(this).removeAttr("style");
            startSpinner();
        });

        var answer = $quizModal.find('div.content.photo input[name=q1-Answer]:checked').val();
        checkPhotoTriviaAnswers(answer);
    }


    function showMsg(msg) {
        $('#quiz-footer').find('.submit-btn').fadeOut(250, function() {
            resultMsg.text(msg).fadeIn(250);
        });
    }

    function hideMsg() {
        resultMsg.fadeOut(250, function() {
            resultMsg.text('');
            $('#quiz-footer').find('.submit-btn').fadeIn(250);
        });
    }

    function disableRadios() {
        $quizModal.find("input[type=radio]").attr('disabled', true);
    }

    function enableRadios() {
        $quizModal.find("input[type=radio]").attr('disabled', false);
    }

    function isFormValid(form) {
        var questions = form.find('.item:visible');
        var formInvalid = false;
        $.each(questions, function(index, question) {
            var radioBtns = $(question).find('input[type=radio]');
            var checked = false;
            $.each(radioBtns, function(index, btnEl) {
                if($(btnEl).is(':checked') === true) {
                    checked = true;
                }
            });
            if(checked === false) {
                formInvalid = true;
            }
        });
        if(formInvalid === true) {
            showMsg('Please select an answer for every question');
            enableRadios();
            $('input').on('change', function() {
                hideMsg();
            });
            return false;
        }
        return true;
    }

    /************************************ Event Listeners ************************************/

    $submit.click(function() {
        disableRadios();

        //if photo, use those functions. Else do Quiz submit
        if ($quiz.hasClass("photo")) {
            submitPhotoAnswers();
        } else if ($quiz.hasClass("text")) {
            submitQuizAnswers();
        }
        return false;
    });

    $quizModal.find(".close").click(closeOverlay);

    $(".activity[activity-type=texttrivia]").click(openQuiz);
    $(".activity[activity-type=phototrivia]").click(openPhotoTrivia);
});