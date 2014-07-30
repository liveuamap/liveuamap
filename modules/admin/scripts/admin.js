$.fn.outerHTML = function(){
 
    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
    return (!this.length) ? this : (this[0].outerHTML || (
      function(el){
          var div = document.createElement('div');
          div.appendChild(el.cloneNode(true));
          var contents = div.innerHTML;
          div = null;
          return contents;
    })(this[0]));
 
}
var langs=['ru','en'];
$(document).ready(function() {
    $(".linkadd").click(function(){
        
    });
    $(".deleteinfoimage").live("click",function(e){
        var id = $(this).parent().parent().prev().attr("id");
        console.log(id);
        var target = $(this);
        $.ajax({
            url: 'admin/del',
            data: 'id='+id,
            dataType: "json",
            type: "GET",
            success: function (data, textStatus) {
                target.parent().parent().prev().remove();
                target.parent().parent().remove();
                console.log(data);
            },
            error: function (error) {
                console.log(error); 
            } 
        });
        e.preventDefault();            
   });
       if($(".linkadd").length>0){
    for(var i=0;i<1;i++){
        var target=$(".linkadd")[i];
     var uploader = new qq.FineUploader({
        element: target,
        validation: {sizeLimit: 25000000,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif']},
        debug: true,        text: {
            uploadButton: "Добавить фотографию"
        },
        request: {
            endpoint: 'admin/upload'
        },
        callbacks: {
        onSubmit: function(id, fileName){
               
        },
        onProgress: function(id, fileName, loaded, total){

                 $(target).find('div.qq-upload-button div').html('Добавить фотографию '+Math.round(loaded/total,2)+'%');
             
        }, 
        onError: function(response){
               console.log('error');   

        }, 
        onComplete: function(id, fileName, response){
             $(target).find('div.qq-upload-button div').html('Добавить фотографию');
var gotoid="";
          //  alert($(".empty-img-pattern").outerHTML());
          for(var i=0;i<langs.length;i++){
            var art=$(target).attr('target').split('_');
            var lng=langs[i];
            var row1=$(".empty-img-pattern").outerHTML().replace('display:none;','').replace('new empty-img-pattern','old').replace('infopic-new-00','infopic-old-'+response.imgid+'-'+lng).replace('infopic-path-00','infopic-old-'+response.imgid+'-'+lng);
            var row2=$(".empty-img-pattern:eq(1)").outerHTML().replace('display:none;','').replace('empty-img-pattern','old').replace('infopicsec-new-00','infopic-secold-'+response.imgid+'-'+lng);
           var addhtml=row1+row2;

           $("#table_fieldiiimages_"+lng).append(addhtml);
        
        if(gotoid==''){
            gotoid='infopic-old-'+response.imgid+'-'+lng;
        }
           $("#"+'infopic-old-'+response.imgid+'-'+lng).find('img').attr('src',response.tmb);
           $("#infopic-old-"+response.imgid+'-'+lng).find('.path00').val(response.tmb);

            $("#"+'infopic-old-'+response.imgid+'-'+lng).find('.path00').attr('name',art[1]+'_picfilename_'+response.imgid+'_'+lng);
            $("#"+'infopic-old-'+response.imgid+'-'+lng).find('.path00').attr('id',art[1]+'_picfilename_'+response.imgid+'_'+lng);
   $("#"+'infopic-old-'+response.imgid+'-'+lng).find('.picheaderfieldiiimages').attr('name',art[1]+'_pichead_'+response.imgid+'_'+lng);
       }
   goToByScroll(gotoid);
}
        }
    });}
    }
        $("#filternow").focus(function () {
        if ($(this).val() == "Поиск") $(this).val('');

    });
    $("#filternow").keyup(function () {
        var word = $("#filternow").val().toLowerCase();
        $(".sub_text").each(function () {
            var tarword = $(this).html();
            if (tarword.toLowerCase().indexOf(word) != -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    $("#filternow").blur(function () {

        if ($(this).val() == "") $(this).val('Поиск');
    });
    $(".liitem").mouseover(function() {
    $(".liitem .deletelink").hide();
    $(".liitem .addsctucture").hide();
        $($("#" + this.id).children("DIV").children(".deletelink")).show();
        $($("#" + this.id).children("DIV").children(".addsctucture")).show();
    });
    $(".addsctucture").click(function() {
        var name = prompt("Введите название нового пункта");
        var ar = this.id.split('-');
        $("#new-structure").val(name);
        $("#parent-structure").val(ar[1]);
        $("#adminform").submit();
        return false;

    });
    $(".edittd").click(function() {
 
        var ar = this.id.split('-');
        $("#admin-edit").val($("default-admin-edit").val());
           
        var gotolocation = $("#edit-link").val() + "edit&id=" + ar[1];
        
         
        if (ar[2] != null)
            gotolocation += "&type=" + ar[2];

        document.location = gotolocation;

        return false;

    });
    $(".deletetd").click(function() {

        var ar = this.id.split('-');
        var asktext = "";
        var deletetype = "";
        if (ar[2] == null)
            asktext = "Вы уверены что хотите удалить " + $("#delete-text").val() + "?!";
        else {
            deletetype = ar[2];
            asktext = "Вы уверены что хотите удалить этот пункт?!";
        }
        if (confirm(asktext)) {
            $("#deleteId").val(deletetype + "-" + ar[1]);
            $("#adminform").submit();
        }
        return false;
    });
    $(".link_save").click(function() {
        var ar = this.id.split('-');
        if (ar[2] == null) {
            $("#admin-edit").val($("#default-admin-edit").val());
            $("#adminform").submit();
        } else {
            $("#admin-edit").val(ar[2]);
            $("#adminform").submit();
        }
        return false;
    });

    $(".sub_text").mouseover(function() {
        var ar = this.id.split("-");
        $(".edit_link").hide();
        $(".delete_link").hide();
        $($($(this).children(".red_del")).children(".delete_link")).show();
        $($($(this).children(".red_del")).children(".edit_link")).show();
        return false;
    });
    $(".uploadpic").click(function() {
        var ar = this.id.split('-');
        if (ar[2] != "")
            $("#admwe1current-pic-field").val(ar[1] + "-" + ar[2]);
        else
            $("#admwe1current-pic-field").val(ar[1]);
        needafile();
        return false;
    });
    $(".delpic").click(function() {

        var ar = this.id.split('-');

        $("#img-" + ar[1]).attr('src', '');
        $("#delpicvalue-" + ar[1]).val("delete");
        return false;
    });
   
    $(".lila").click(function() {
        var ar = this.id.split("-");
        // $(".trjust").hide();
        // $(".tr" + ar[2]).show();
        $(".content_edit").hide();
        $(".content_edit_" + ar[2]).show();


        $(".spla").hide();
        $(".sp" + ar[2]).show();

        $(".lila").show();
        $(".li" + ar[2]).hide();
        return false;
    });
  
    $("#uplfile").click(function() {

        document.location = 'index.php?mod=fileupedit&id=-1';
    });
    $("#searchme").click(function() {

        if ($("#searchdiv").css("display") == "none") {
            $("#searchdiv").css("display", "block");
        } else {
            $("#searchdiv").css("display", "none");

        }

    });
    $("#searchdiv").dblclick(function() {

        $("#searchdiv").css("display", "none");


    });

    $(".admintbl").tablesorter();
    $("#searchText").keydown(function(event) {
        if (event.keyCode == '13') {

            if ($("#searchText").val().length > 0) {

                document.location = 'index.php?mod=search&what=' + $("#searchText").val();
            }
            return false;
        }

    });
    $("#searchLink").click(function() {

        if ($("#searchText").val().length > 0) {

            document.location = 'index.php?mod=search&what=' + $("#searchText").val();
        }

    });


});

function toggleEditor(id) {

if (!tinyMCE.get(id)){
tinyMCE.execCommand('mceAddControl', false, id);}
else
tinyMCE.execCommand('mceRemoveControl', false, id);
}

function doalert(text) {

    $("#shoot-walle-text").html(text);
    $("#shoot-walle").dialog('open');

}

function beginwait() {

    $("#finding-nemo").dialog('open');
}
function needafile() {

    $("#bigbang-theory").dialog('open');
}
function dontneedafile() {

    $("#bigbang-theory").dialog('close');
}
function endwait() {

    $("#finding-nemo").dialog('close');
}
function goToByScroll(elementId) {



    $('html,body').stop().animate({

        scrollTop: $('#' + elementId).offset().top
    }, 300, 'easeInOutQuint');


}