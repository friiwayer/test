$(function(){

$('form.form-inline').submit(function(f){
$.ajax({
url: "../../exec/Jquery.php",
type: "post",
data: new FormData(this),
contentType: false,
cache: false,
beforeSend:function(){
$('#jax').css('display','block');
},
processData:false,
success: function(data)
{
$('#jax').css('display','none');
load_images();
}
})
});
});

function load_images()
{
$.post("../../exec/Jquery.php",{getIm:1})
.done(function(data){
$('.table').html(data);$('.dn').removeClass('dn');
$("html, body").animate({ scrollTop: $(document).height() }, 1000);
});
}
