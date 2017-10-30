$('document').ready(function() {
    hWindow = $(window).height();
    hHeader = $('header').height();
    hFooter = $('footer').height() + 90;
    height = hWindow - hHeader - hFooter;
    $("#midle").css("min-height",height);
    $(window).resize(function() {
        hWindow = $(window).height();
        hHeader = $('header').height();
        hFooter = $('footer').height();
        height = hWindow - hHeader - hFooter;
        $("#midle").css("min-height",height);
    });
});
$("#close-uploads").click(function(){
    $('.modal-backdrop').remove();
    $('#upload-modal').hide('slow');
});
$('#submitUpload').click(function(){
    $check = $("#CheckboxPodmienki").is(':checked');
    $email = $("#email").val();
    $csfd = $("#csfd").val();
    if($email == undefined){
        $email = true;
    }
    if($check  && $email ){
        $('#loader').show();
    }

});
function getPayments($price)
{
    $.ajax({
        url: "/platba/"+$price,
        type: 'POST',
        cache: false,
        data: {"_token": $('#csrf-token').attr('content')},
        datatype: 'html',
        success: function(response)
        {
            $(".price").html($price);
            $("#platba").html(response.data);
        }

    });
}