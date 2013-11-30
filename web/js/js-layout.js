$(document).ready(function() {           
           str = 'controller=config&action=get';
           $("#title-banner").css("display","none");
           $("#title-banner").show("slide",750);    
           maxwindow();
           getNotify();
           setBoxAlert();
           $(window).resize(function(){maxwindow();});
           $.get('index.php','controller=index&action=Menu',function(menu){
                $("#menu").empty();                    
                var opciones_menu = menu;
                w = $(document).width();                
                $(".head_nav").generaMenu(opciones_menu);
                //$("#m0").find('a').addClass("home");
            },'json');    
            
                 var $floatingbox = $('#site_head');
 
                 if($('#body').length > 0){

                  var bodyY = parseInt($('#body').offset().top);
                  var originalX = $floatingbox.css('margin-left');

                  $(window).scroll(function () { 
                       
                   var scrollY = $(window).scrollTop();
                   var isfixed = $floatingbox.css('position') == 'fixed';

                   if($floatingbox.length > 0){
                      if ( scrollY > bodyY && !isfixed ) {                                
                                $floatingbox.stop().css({
                     position: 'fixed',                                  
                                  marginLeft: 0,
                                  top:0
                                });
                        } else if ( scrollY < bodyY && isfixed ) {
                                  $floatingbox.css({
                                  position: 'absolute',
                                  top:0,
                                  marginLeft: originalX
                        });
                     }		
                   }
               });
             }             
             
        });
  //document.oncontextmenu = function(){ return false; }
  
function maxwindow()
{
  var h = $(window).height();
  $("#content").css('minHeight',(h-135));  
}
function setBoxAlert()
{
  var h = $(window).height(),
      w = $(window).width();
  $("#box-alerts").css('top',(h-110));    
  $("#box-alerts").css('left',(w-250));
}
function getNotify()
{
    $.get('index.php','controller=notify&action=getAlerts',function(r)
    {
        $.each(r,function(i,j){
            if(j[0]>0)
                {
                    $('#notify-'+i).removeClass('notification-'+i+'-empty').addClass('notification-'+i);
                    $('#notify-'+i).empty().append('<span class="indicator-notification">'+j[0]+'</span');
                    $("#notify-"+i).attr("href",'index.php?'+j[1]);
                }
                else
                {
                    $("#notify-"+i).removeClass("notification-"+i).addClass("notification-"+i+"-empty");
                    $("#notify-"+i).empty();
                }
        });        
    },'json');
}
setInterval(getNotify,15000);