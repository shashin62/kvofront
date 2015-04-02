$(document).ready(function () {
    $('#btnVote').click(function() {
         $('#frmPoll').submit();
    });
    
    $('#frmPoll').validate({
        errorElement: "span",
        rules: {
            'poll_answer': {
                required: true
            }
        },
        messages: {
            'poll_answer': {
                required: 'Please select an option'
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter("#frmPoll ul");
        },
        submitHandler: function(form) {
            var queryString = $('#frmPoll').serialize();

            $.post(baseUrl + '/poll/saveVote', queryString, function(data) {
                if (0 == data.error) {
                    var displayMsg = data.message;
                    var errHtml = '<span for="poll_answer" generated="true" class="error displayMsg">'+displayMsg+'</span>';
                    errHtml.insertAfter("#frmPoll ul");
                    setTimeout(function() {
                        $('.displayMsg').hide('slow');
                    }, 2500);
                } else {
                    var displayMsg = data.message;
                    showJsSuccessMessage(displayMsg);
                    setTimeout(function() {
                        $('.jssuccessMessage').hide('slow');
                    }, 2500);
                    id = $('#id').val();
                    showResult(id);
                }

            }, "json");

            return false;
        }
    });
});

function showResult(id) {
    $.ajax({
        url: baseUrl + '/poll/showResult',
        //dataType: 'json',
        data: {id: id},
        type: "POST",
        success: function (response) {
            $('.pollbody').html(response);
            $('.pollfoot').html('Thank you for voting!');
        }
    });
}