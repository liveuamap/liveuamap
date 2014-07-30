var map ;var globaltime=new Date().getTime()/1000;
var m=0;var amount=0;
var d=0;   var highestZIndex = 0;var first=true;
var stateObj = { url: "liveuamap.com" }; var wwwpath = '';
var g=0;var lat=0;var lng=0; var zoom=6;
var setcoords;
var curlat=48.76;var curlng=34.51;var fields=new Array();
var lastid=0;var notnew=false
var updater;var props=new Array();
function updatefeed(){
    if(!notnew){
    globaltime=new Date().getTime()/1000;
         amount= addvenues(true);}
}
$(document).ready(function(){
  size();
 
     $('.tim').on('click',function(){
     $('.boxselect').show();
 });
 $('.sc').on('click',function(){
     $('.scobox').hide();
 });
 $(document).on('click','.event',function(){
    var ar=$(this).attr('id').split('-'); 
    
    curid=ar[1];
        setCurrent();
        if($(window).width()<=640){   $("div.mnu a").removeClass('inside');
        $("#maplegend").hide();
        $("#map").removeClass('inside');
       $("#map").addClass('inside');
        }
   
 });
 
  $(document).on('click','#showmap',function(e){
      $("#maplegend").addClass('showed');
       $("#map_canvas").addClass('showed');
      e.preventDefault();
  });
 $(document).on('click','#topl',function(){
   $('#maplegend').stop().animate({
            scrollTop:0
        });
 
 });
  $(document).on('click','#info',function(e){
      $("#feedler").hide();
         $("#infobox").show();
   $("#filterbox").hide();     $("#maplegend").show();
     $("div.mnu a").removeClass('inside');
   $(this).addClass('inside');
 e.preventDefault();     $("div.tweet div.header").html('ABOUT');
 
 });
   $(document).on('click','#filter',function(e){
         $("#feedler").hide();
            $("#infobox").hide();
   $("#filterbox").show();     $("#maplegend").show();
     $("div.mnu a").removeClass('inside');
   $(this).addClass('inside');
 e.preventDefault();     $("div.tweet div.header").html('FILTER');
 
 });
  $(document).on('click','#list',function(e){
   $("div.mnu a").removeClass('inside');
   $(this).addClass('inside');
   $("#infobox").hide();
   $("#filterbox").hide();
    $("#feedler").show();
        $("#maplegend").show();
        $("div.tweet div.header").html('EVENTS');
 e.preventDefault();
 });
 $(document).on('click','#goliqpay',function(e){
     e.preventDefault(); 
     document.location.href=wwwpath+'card?sum='+$("#txtamount").val();
 });
  $(document).on('click','#map',function(e){
   $("div.mnu a").removeClass('inside');
   $(this).addClass('inside');
     $("#maplegend").hide();
 e.preventDefault();     $("div.tweet div.header").html('MAP');
 });
 $("#txtsource").on('change',function(){
     if($(this).val().indexOf('twitter.com')>0){
         var ar=$(this).val().split('/');
         $.ajax({
  url: wwwpath+'ajax/do?act=twi&status='+ar[5],
  context: document.body
}).done(function(meow) {
    
 
  var o=$.parseJSON(meow);
  $("#txttime").val(o.time);
  $("#txtpicture").val(o.media);
   $("#twitpic").val(o.mediaurl);
   $("#twitauthor").val(o.author);
  $("#txtname").val(o.text);
});
       
     }
 });
  $(document).on('click','.twi',function(e){
        var item=$(this).parent().parent().parent();
      var title=item.find('.title').html();
      var image=item.find('.img').find('img').attr('src');
      if(image==undefined){
          image=$('link[rel=image_src]').attr('href');
      }
      var link = wwwpath+'e/'+item.attr('data-link');
      var metadescr=$('meta[name=description]').attr('content');
     
   streamPublishTwi(title,title+' #liveuamap',image,link);
     e.preventDefault(); 
  });
  $(document).on('click','.fb',function(e){
      var item=$(this).parent().parent().parent();
      var title=item.find('.title').html();
      var image=item.find('.img').find('img').attr('src');
      if(image==undefined){
          image=$('link[rel=image_src]').attr('href');
      }
      var link = wwwpath+'e/'+item.attr('data-link');
      var metadescr=$('meta[name=description]').attr('content');
     
   streamPublishFb(title,metadescr,image,link);
     e.preventDefault(); 
  });
  $('.ok').on('click',function(e){
   var indata =$('select[name=datac] option:selected').val();
     var inmonth =$('select[name=datam] option:selected').val();
     var inyear =$('select[name=datag] option:selected').val();inyear=2014;
   

   var t=new Date(inyear,Math.round(inmonth)-1,Math.round(indata),0,0,0);

     globaltime=t.getTime()/1000;
     lastid=0;

clearInterval(updater);notnew=true;
   map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
     
   $(".event").remove();
     amount= addvenues(false);
    // if(amount==0){
    //     alert('No events on this day');
     //}else{
         $('.boxselect').hide();
    // }
     mapaction();
        
  e.preventDefault();
  
  
  

 });
 $('.send').on('click',function(){
     $('.scro').show();
     $('.adminmain').hide();
 });
 var center=new google.maps.LatLng(curlat, curlng);
 if(lng!=0){curlat=lat;curlng=lng;
     center=new google.maps.LatLng(lat, lng);
 }
    var mapOptions = {
  center: center,
  zoom: zoom,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,panControl:true,  zoomControl:true,overviewMapControl:true
};
   init();
 map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
   google.maps.event.addListener(map, 'center_changed', function() {
       curlat=map.getCenter().k;
      curlng=map.getCenter().B;
          clearTimeout(setcoords);
         setcoords=setTimeout(coord,1000); 
       // change_my_url('',wwwfullpath);
  });
  google.maps.event.addListener(map, 'zoom_changed', function() {

      curlat=map.getCenter().k;
      curlng=map.getCenter().B;
        clearTimeout(setcoords);
         setcoords=setTimeout(coord,1000); 
     // change_my_url('',wwwfullpath);
  });
 var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
addvenues(false);
setTimeout( mapaction,2500);
  if(lng!=0){
        var marker09= new google.maps.Marker({position:  new google.maps.LatLng(lat, lng)});
             marker09.setMap(map);
  }

});

var markers=new Array();


function addvenues(lie){
 var amount=0;
 $.ajax({
  url: wwwpath+'ajax/do?act=pts&curid='+curid+'&time='+globaltime+'&last='+lastid+'&props='+$.toJSON(props),
  context: document.body
}).done(function(meow) {

  var o=$.parseJSON(meow);
  amount=o.amount;
  $("#toptime .datac").html(o.datac);
   $("#toptime .datam").html(o.datam);
    $("#toptime .datag").html(o.datay);
    for(var i=0;i<o.fields.length;i++){
        var v=o.fields[i];
           var triangles=new Array();
           for(var j=0;j<v.points.length;j++){
               triangles.push(new google.maps.LatLng(v.points[j].lat,v.points[j].lng));
           }
        switch(v.type_id){
            case 3:
                  var lineSymbol = {
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
  };
  var line = new google.maps.Polyline({
    path: triangles, strokeWeight: 5,strokeOpacity: 0.8,  strokeColor: v.strokecolor,
    icons: [{ 
      icon: lineSymbol,
      offset: '100%'
    }],
    map: map
  });
                break;
            case 4:
               
                var bermudaTriangle = new google.maps.Polygon({
            paths: triangles,
            strokeColor: v.strokecolor,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: v.fillcolor,
            fillOpacity: 0.18
          });
           bermudaTriangle.setMap(map);
           fields.push(bermudaTriangle);
            var center=     polygonCenter(bermudaTriangle);
           var mapLabel = new MapLabel({
           text: v.name,
           position: center,
           map: map,
           fontSize: 25,
           align: 'center'
         });
                break;
               case 5:
                
  var line = new google.maps.Polyline({
    path: triangles, strokeWeight: 2,strokeOpacity: 0.8,  strokeColor: v.strokecolor,
   
    map: map
  });
  var length=Math.floor(google.maps.geometry.spherical.computeDistanceBetween (triangles[triangles.length-2], triangles[triangles.length-1])/1000,1);
    var mapLabel = new MapLabel({
           text: length +' km',
           position: polygonCenter(line),
           map: map,
           fontSize: 25,fontColor:v.strokecolor,
           align: 'center'
         });
                        break;       
        }
    } 

  for(var i=0;i<o.venues.length;i++){
      var v=o.venues[i];

         
             var marker=addmarker(v);
 markers.push({m:marker,v:v});

           
}
if(first){
setCurrent();
 imagesLoaded( document.querySelector('#maplegend'), function( instance ) {
     if(curid!=0){
        
 showpopup(curid);}
});}
clearInterval(updater);
 updater=setInterval(updatefeed,60000);
 var newDate = new Date(); 
var datetime =  newDate.today() + " " + newDate.timeNow();
$(".updated").remove();
 $("#feedler").prepend('<div class="updated">Updated on '+datetime+'</div>');
 first=false;
});

 return amount;
}
$(window).resize(function(){
size();
});
function clearmarkers(){
    for(var i=0;i<markers.length;i++){
        var mv=markers[i];
        if(mv!=null&&mv.m!=null)
        mv.m.setIcon(mv.v.link);
    }
    
}
        function setCurrent(){
            if(curid!=0){
                clearmarkers();
                var was=false
                for(var i=0;i<markers.length;i++){
                       var mv=markers[i];
                       if(mv.v.id==curid){
                                      map.panTo(mv.m.getPosition());
                     if(map.getZoom()<8)
                        map.setZoom(8);
                     
            mv.m.setIcon(mv.v.sel_link);
   showpopup(mv.v.id,mv.v.time,mv.v.name,mv.v.description,mv.v.source,mv.v.link,mv.v.city,mv.v.picture,mv.v.link);
                        was=true; 
                        break;
                       }
                }
                
            }
            
        }
function addmarker(v){addmarker
          v.sf='.png';
            
       switch(Math.round(v.color_id)){
                    case 1: v.sf='_red.png';break;
                      case 2: v.sf='_blue.png';break;
                          case 3: v.sf='_silver.png';break;
                              default:
                                 
                                  break;
                }
             
             if(v.cat===null)return;
                     v.link=wwwpath+'images/i30/'+v.cat.img+v.sf;
                      v.sel_link=wwwpath+'images/o/over_'+v.cat.img+v.sf;
     var marker= new google.maps.Marker({position:  new google.maps.LatLng(v.lat,v.lng),icon: new google.maps.MarkerImage(v.link,new google.maps.Size(30,30)), title:v.name});
            addpopup(v.id,v.time,v.name,v.description,v.source,v.link,v.city,v.picture,v.link,v.target,v);    
    google.maps.event.addListener( marker, "click", function() {
        clearmarkers();
           map.panTo(marker.getPosition());
                 if(map.getZoom()<8)
            map.setZoom(8);
          
            marker.setIcon(v.sel_link);
   
     if($(window).width()<=640){  
          $("div.mnu a").removeClass('inside');
        $("#maplegend").show();
 
       $("#list").addClass('inside');
     }   
      
showpopup(v.id,v.time,v.name,v.description,v.source,v.link,v.city,v.picture,v.link,v);
});
 google.maps.event.addListener(marker, "mouseover", function() {
           
              this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
          
        });
  marker.setMap(map);
return marker;
}
function searchincat(arr,catid){
    for(var i=0;i<o.arr.length;i++){
        if(o.arr[i].id==catid){
            return o.arr[i];
        }
    }
}
function size(){
    $('.boxselect').css({
       left:$(window).width()/2-300
    });
     if($(window).height()<560){
     $('.adminmain').css({
       overflowY: "scroll"
     });
 }else{
      $('.adminmain').css({
       overflowY: "visible"
     });
 } 
 if($(window).width()>700){
 $("#map_canvas").css('width',$(window).width()-420+'px');
 $("#map_canvas").attr('width',$(window).width()-420+'px');}
}

    function gotop(id) {

  var gotop2=$(id).position().top;
          if($(window).width()<=640){
              gotop2=gotop2-50;
          }
        $('html,body').stop().animate({
    
            scrollTop:gotop2
        }, 400, 'easeInOutQuint');

   
    }
    
    function getHighestZIndex() {

        // if we haven't previously got the highest zIndex
        // save it as no need to do it multiple times
        if (highestZIndex==0) {
            if (markers.length>0) {
                for (var i=0; i<markers.length; i++) {
                    tempZIndex = markers[i].m.getZIndex();
                    if (tempZIndex>highestZIndex) {
                        highestZIndex = tempZIndex;
                    }
                }
            }
        }
     
        return highestZIndex;

    }
    function change_my_url(header, url) {
   wwwfullpath=url;
  
    history.pushState(stateObj, header, wwwpath + '' + url+'?ll='+curlat+";"+curlng+'&zoom='+map.getZoom());
}
function showpopup(id){
change_my_url('liveuamap','e/'+$("#post-"+id).attr('data-link'));
    $(".selected").removeClass('selected');
    $("#post-"+id).addClass('selected');
var gotop2=50;
    if($(window).width()<=640){
            gotop2=100;
         }
           $("#infobox").hide();
   $("#filterbox").hide();
       $("#feedler").show();
    $('#maplegend').stop().animate({
            scrollTop:$('#maplegend').scrollTop()+  $("#post-"+id).position().top-gotop2
        });
       //  getHighestZIndex();
         for(var i=0;i<markers.length;i++){
         if(markers[i].v.id==id){
             markers[i].m.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
      
                //markers[i].m.setOptions({zIndex:highestZIndex+1});
          break;   
         }
         }
         if($(window).width()<=640){
            
         }
}
    function addpopup(id,time,title,desc,link,source,near,pic,ico,target,v){
        var img='';
    
        if(pic!='')
            img='<a data-lightbox="pic-'+id+'" data-title="'+title+'" href="'+pic+'"><img src="'+pic+'" style="width:315px"/></a>';
       var dataid=id;
       if(target!=''){
           dataid=target;
       }
       var sclass='source';var stitle='';
       if(v.status_id==1){
           sclass+=' rumor';stitle='It can be fake';
       }
       title=linkify(title);
        $("#feedler").prepend('<div data-link="'+dataid+'" data-id="'+id+'" id="post-'+id+'" class="event">\n\
            <div class="time"><img  src="'+ico+'" style="width:32px"/>'+time+'</div>\n\
            <div class="title">'+title+'</div>\n\
            <div class="img">'+img+'</div>\n\
   <div class="'+sclass+'" title="'+stitle+'"><a id="trunc" rel="nofollow" href="'+link+'" target="_blank">source</a>\n\
<div class="tellfriends"><span>tell friends</span><a href="#" class="twi"></a><a href="#" class="fb"></a></div>\n\
\n\
</div> \n\
');
      
        if(lastid<id)
        lastid=id;
   
    }
    function init(){
(function(){/*


 Copyright 2011 Google Inc.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
*/
var c="prototype";function e(a){this.set("fontFamily","sans-serif");this.set("fontSize",12);this.set("fontColor","#000000");this.set("strokeWeight",4);this.set("strokeColor","#ffffff");this.set("align","center");this.set("zIndex",1E3);this.setValues(a)}e.prototype=new google.maps.OverlayView;window.MapLabel=e;e[c].changed=function(a){switch(a){case "fontFamily":case "fontSize":case "fontColor":case "strokeWeight":case "strokeColor":case "align":case "text":return h(this);case "maxZoom":case "minZoom":case "position":return this.draw()}};
function h(a){var b=a.a;if(b){var f=b.style;f.zIndex=a.get("zIndex");var d=b.getContext("2d");d.clearRect(0,0,b.width,b.height);d.strokeStyle=a.get("strokeColor");d.fillStyle=a.get("fontColor");d.font=a.get("fontSize")+"px "+a.get("fontFamily");var b=Number(a.get("strokeWeight")),g=a.get("text");if(g){if(b)d.lineWidth=b,d.strokeText(g,b,b);d.fillText(g,b,b);a:{d=d.measureText(g).width+b;switch(a.get("align")){case "left":a=0;break a;case "right":a=-d;break a}a=d/-2}f.marginLeft=a+"px";f.marginTop=
"-0.4em"}}}e[c].onAdd=function(){var a=this.a=document.createElement("canvas");a.style.position="absolute";var b=a.getContext("2d");b.lineJoin="round";b.textBaseline="top";h(this);(b=this.getPanes())&&b.mapPane.appendChild(a)};e[c].onAdd=e[c].onAdd;e[c].draw=function(){var a=this.getProjection();if(a){var b=this.get("position");if(b)a=a.fromLatLngToDivPixel(b),b=this.a.style,b.top=a.y+"px",b.left=a.x+"px",b.visibility=i(this)}};e[c].draw=e[c].draw;
function i(a){var b=a.get("minZoom"),f=a.get("maxZoom");if(b===void 0&&f===void 0)return"";a=a.getMap();if(!a)return"";a=a.getZoom();if(a<b||a>f)return"hidden";return""}e[c].onRemove=function(){var a=this.a;a&&a.parentNode&&a.parentNode.removeChild(a)};e[c].onRemove=e[c].onRemove;})()
}
/*!
 * imagesLoaded PACKAGED v3.1.7
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("eventEmitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function c(e){this.img=e}function f(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var c=r[o];this.addImage(c)}}},s.prototype.addImage=function(e){var t=new c(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),c.prototype=new t,c.prototype.check=function(){var e=v[this.img.src]||new f(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},c.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return f.prototype=new t,f.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},f.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},f.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},f.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},f.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},f.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

function streamPublishTwi(title,description,image,urlo){
    ga('send', 'event', 'twishare', 'click');
    var url  = 'http://twitter.com/share?';
    url += 'url='          + encodeURIComponent(urlo);
    url += '&title='       + encodeURIComponent(title);
    url += '&text=' + encodeURIComponent(description);
    url += '&image='       + encodeURIComponent(image);
    url += '&noparse=true';
    window.open(url,'','toolbar=0,status=0,width=626,height=436');

}
function streamPublishVk(title,description,image){
    ga('send', 'event', 'vkshare', 'click');
    var url  = 'http://vk.com/share.php?';
    url += 'url='          + encodeURIComponent(document.location.href+'?ver='+Math.round(1,10000));
    url += '&title='       + encodeURIComponent(title);
    url += '&description=' + encodeURIComponent(description);
    url += '&image='       + encodeURIComponent(image);
    url += '&noparse=true';
    window.open(url,'','toolbar=0,status=0,width=626,height=436');

}
function streamPublishOd(title,description,image){
    ga('send', 'event', 'odshare', 'click');
      var url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
        url += '&st.comments=' + encodeURIComponent(description);
        url += '&st._surl='    + encodeURIComponent(document.location.href+'?ver='+Math.round(1,10000));
         window.open(url,'','toolbar=0,status=0,width=626,height=436');
}
function streamPublishGpl(title,description,image){
    ga('send', 'event', 'gplshare', 'click');
      var url  = 'https://plus.google.com/share?ver='+Math.round(1,10000);
        url += '&content=' + encodeURIComponent(description);
        url += '&url='    + encodeURIComponent(document.location.href+'?ver='+Math.round(1,10000));
         window.open(url,'','toolbar=0,status=0,width=626,height=436');
}
function streamPublishFb(title,description,image,url) {
  ga('send', 'event', 'fbshare', 'click');
 FB.ui({
  method: 'feed',
  link: url,
 display:'popup' ,picture:image,caption: title, description:description
}, function(response){
    
           
});

}


function polygonCenter(poly) {
    var lowx,
        highx,
        lowy,
        highy,
        lats = [],
        lngs = [],
        vertices = poly.getPath();

    for(var i=0; i<vertices.length; i++) {
      lngs.push(vertices.getAt(i).lng());
      lats.push(vertices.getAt(i).lat());
    }

    lats.sort();
    lngs.sort();
    lowx = lats[0];
    highx = lats[vertices.length - 1];
    lowy = lngs[0];
    highy = lngs[vertices.length - 1];
    center_x = lowx + ((highx-lowx) / 2);
    center_y = lowy + ((highy - lowy) / 2);
    return (new google.maps.LatLng(center_x, center_y));
  }
  function coord(){
      change_my_url('',wwwfullpath);
  }
  
  function linkify(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3;
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = inputText.match(regExp);

    if (match&&match[7].length==11){
     replacedText = inputText.replace(/(?:https:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g, '<iframe width="320" height="180" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');
       // replacedText=inputText.replace(match,'<iframe width="320" height="180" src="//www.youtube.com/embed/'+match[7]+'" frameborder="0" allowfullscreen></iframe>');
                
                 
    }else{
    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" rel="nofollow" target="_blank">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a rel="nofollow" href="http://$2" target="_blank">$2</a>');

    //Change email addresses to mailto:: links.
    replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
    replacedText = replacedText.replace(replacePattern3, '<a  href="mailto:$1">$1</a>');
    }
    return replacedText;
}
// For todays date;
Date.prototype.today = function () { 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
}

// For the time now
Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}