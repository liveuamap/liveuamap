jQuery.fn.extend({
imagerandom:function(parameters)
{	var count=$(this).children().length;
        var width=615;
        var blockwidth=170;
        var blockheight=210;
        
        var inline=((width-width%blockwidth)/blockwidth);
        var height=((count-count%inline)/inline+2)*blockheight-100;
        
        

        $(this).css('width',width+'px');
        $(this).css('position','absolute'); 
    //    $(this).css('background-color','#efef00'); 
        $(this).css('height',height+'px');
        $(this).parent().css('height',height+'px');

        var counter=0;
         
         $(this).children().mouseover(function(){
        
            $(this).addClass('legendover',1400);

        }).mouseout(function(){


            $(this).removeClass('legendover',400);
        })
	$(this).children().each(function(){
           $(this).css('position','absolute');
  
      $(this).children().children().attr("width",$(this).children().children().width()+Math.random()*40);
           $(this).css('left',blockwidth*(counter%inline)+  blockwidth/4-(blockwidth/3)*Math.random());
           $(this).css('top',((counter-(counter%inline))/inline)*blockheight+  blockheight/2-  (blockheight/2)*Math.random());
           $(this).css('z-index',count-counter);
           counter++;
        });
}
});
