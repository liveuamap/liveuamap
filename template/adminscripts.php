<?php defined('WERUA') or include('../bad.php');  
?>
    <script type="text/javascript">
  var coords=new Array(); var bermudaTriangle ;
    <?php if(wra_userscontext::hasright('adminpage')){?>
var count0=0;
        function addclicker(e){
        
              if($("#txttype").val()>1){
               var a={id:count0,lat:e.latLng.k,lng:e.latLng.B};
               count0++;
               coords.push(a);
           }
           $("#txtpoints").val($.toJSON(coords));
           var triangles=new Array();
           for(var i=0;i<coords.length;i++){
               triangles.push(new google.maps.LatLng(coords[i].lat,coords[i].lng));
           }
           switch(Math.round($("#txttype").val())){
               case 2:
                   break;
                    case 5:
                
  var line = new google.maps.Polyline({
    path: triangles, strokeWeight: 2,strokeOpacity: 0.8,  strokeColor: $("#txtcolor_border").val(),
   
    map: map
  });
  var length=Math.floor(google.maps.geometry.spherical.computeDistanceBetween (triangles[triangles.length-2], triangles[triangles.length-1])/1000,1);
    var mapLabel = new MapLabel({
           text: length +' km',
           position: polygonCenter(line),
           map: map,
           fontSize: 25,fontColor:$("#txtcolor_border").val(),
           align: 'center'
         });
                        break;
                    case 3:
                         var lineSymbol = {
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
  };
  var line = new google.maps.Polyline({
    path: triangles, strokeWeight: 5,strokeOpacity: 0.8,  strokeColor: $("#txtcolor_border").val(),
    icons: [{ 
      icon: lineSymbol,
      offset: '100%'
    }],
    map: map
  });
                        break;
                        case 4:
                              if(bermudaTriangle!=undefined)
           bermudaTriangle.setPath([]);
           bermudaTriangle = new google.maps.Polygon({
            paths: triangles,
            strokeColor: $("#txtcolor_border").val(),
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: $("#txtcolor_bg").val(),
            fillOpacity: 0.25
          });
         // addclicker(bermudaTriangle);
           bermudaTriangle.setMap(map);
           addclicker(bermudaTriangle);
                            break;
    }
               
         
    $("#txtlat").val(e.latLng.k);
    $("#txtlng").val(e.latLng.B);
        }
          function mapaction(){
              alert('You are in Mapaction');
               for (var i = 0; i < fields.length; i++) {
            var areaPerimeterPathArray = fields[i].getPath();

            for(var j=0;j<areaPerimeterPathArray.length;j++){
             
                var mapLabel = new MapLabel({
           text: j,
           position: areaPerimeterPathArray.getAt(j),
           map: map,
           fontSize: 15,
           align: 'center'
         });
            }
           google.maps.event.addListener(fields[i], 'click', function (event) {
        //alert the index of the polygon
   //     var lat = event.latLng.lat();
   // var lng = event.latLng.lng();
  //  $("#txtlat").val(lat);
   // $("#txtlng").val(lng);
       console.log('eee');
    addclicker(event);
        
    });
        }
       google.maps.event.addListener(map, "click", function(e) {
               console.log('eee2');
                    addclicker(e);
    
        $("#mapadd").show();
});}
$(document).ready(function(){
   // setTimeout(mapaction,2000);
    $("#txttype").on('change',function(e){
         coords=new Array();
       
            
    });
    $("#searchlink").on('click',function(e){
         e.preventDefault();
         if($("#txtsearch").val().length<5)return;
                 $.ajax({
  url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+$("#txtsearch").val()+'&key=AIzaSyBT2mc5vMLpOWWHgHgD6kdmzCLaIFjIWWs',

}).done(function(meow) {
   
    for(var i=0;i<meow.results.length;i++){
        var abb=meow.results[i].geometry.location;
        
          var center=new google.maps.LatLng(abb.lat, abb.lng);
          $("#txtlat").val(abb.lat);
    $("#txtlng").val(abb.lng);
                map.panTo(center);
                   
                 map.setZoom(10);
    }
});
       
    });
    $("#pressFrm").validate();
    $('#txttime').datetimepicker().datetimepicker({mask:'39.19.9999 29:59',	format:'d.m.Y',
	formatDate:'d.m.Y',step:30});
    $("#txtpoints").on('blur',function(e){
        coords=new Array();
 
        var b=$.parseJSON($("#txtpoints").val());
      
        for(var i=0;i<b.length;i++){
            b[i].id=i;
            coords.push(b[i]);
        }
        alert('coords changed');
    });
    $("#txtname").on('blur',function(e){
        var val=$("#txtname").val();
        var date=$("#txtlink1").attr('data-date');
        var amount=0;var link=date+'-';
        for(var i=0;i<val.length;i++){
            if(link.length>60&&val.charAt(i)==' ')break;
            switch(val.charAt(i)){
                case ' ':link+='-'; break;
                case '#':link+=''; break;
                case "'":link+=''; break;    case "&":link+=''; break;
                 case '"':link+=''; break; case '@':link+=''; break;
                case ",":link+=''; break;    case "!":link+=''; break;
                    case "/":link+=''; break;case "(":link+=''; break;
                    case ")":link+=''; break;     case "-":link+=''; break;
                case ":":link+=''; break; case ";":link+=''; break;
                case ".":link+=''; break;
                 default:link+=val.charAt(i); break;
            }
          
        }
        $("#txtlink1").val(link.toLowerCase());
    });
    $(".txtlink").on('click',function(e){
        if(!$("#pressFrm").valid()){
        e.preventDefault();}
    });
});
    <?php }else{?>  function mapaction(){} <?php }?>
        
        
    </script>