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
$("html, body").animate({scrollTop:$(document).height()},1000);
});
}

function filtr(vd)
{
var now = $(vd).attr('class');
if(now=='up'){$(vd).removeClass('up').addClass('down').children('span').attr('class','caret-down');window.location.hash = '#down';}
if(now=='down'){$(vd).removeClass('down').addClass('up').children('span').attr('class','caret-up');window.location.hash = '#up';}
$.post("../../exec/Jquery.php",{filtr:now}).done(function(data){$('.table').html(data);
});
return false;
}
