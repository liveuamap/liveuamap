var langs=['ru','en'];
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




function save_state() {
    var state_grid = $("#adtable").jqGrid('getGridParam');
    $.cookie("gridState", state_grid, { expires: 1 });
}
function saveGridToCookie(name, grid) {
   
    var gridInfo = new Object();
    name = (name + window.location.pathname).replace("/", "");
    while(name.indexOf('/')>0){
        name = name.replace("/", "");
    }
    var gridData = grid.jqGrid('getGridParam');
    gridInfo.ColumnOrder = grid.jqGrid('getColumnOrder');
    gridInfo.ColModel = grid.jqGrid('getGridParam', 'colModel');

   // alert(grid.jqGrid('getColumnOrder'));
    $.jStorage.set(name, $.toJSON(gridInfo));
  //  $.cookie(name, $.toJSON(gridData));
    //  console.log('save' + $.toJSON(gridData).length);
  
}
function loadGridFromCookie(name) {
    name = (name + window.location.pathname).replace("/", "");
    while(name.indexOf('/')>0){
        name = name.replace("/", "");
    }
    var c = $.jStorage.get(name);
   
    if (c == null)
        return;
   
    var gridInfo = $.parseJSON(c);
    var grid = $("#" + name);
    //alert(c);
   // grid.jqGrid('setGridParam', 'colModel', gridInfo.ColModel);
     grid.jqGrid('setColumnOrder', gridInfo.ColumnOrder);
     console.log(c);

  //  console.log('load' + c);
    grid.trigger("reloadGrid");
    //$("#adtable").jqGrid(gridInfo);
}
function goToByScroll(elementId) {



    $('html,body').stop().animate({

        scrollTop: $('#' + elementId).offset().top
    }, 300, 'easeInOutQuint');


}
var eventList_init = false;
$(document).ready(function () {
    
    (function ($) {

    $.jgrid.extend({

        getColumnOrder: function () {
            var $grid = $(this);

            var colModel = $grid[0].p.colModel;

            var names = [];
            $.each(colModel, function (i, n) {
                var name = this.name;
                if (name != "" && name != 'subgrid')
                    names[names.length] = name;
            });

            return names;
            //return JSON.stringify(names);
            //$('#dbgout').val(j);

        },


        setColumnOrder: function (new_order) {
            var $grid = $(this);

            //var new_order = JSON.parse($('#dbgout').val());
            //new_order = ['a', 'c', 'd', 'b', 'e'];
            //              0    1    2    3    4

            var new_order_index = {};

            $.each(new_order, function (i, n) {
                new_order_index[n] = i;
            });

            //new_order = ['a', 'c', 'd', 'b', 'e'];
            //              0    1    2    3    4
            // new_order_index a=>0 c=>1 d=>2 b=>3 e=>4
            if(!$grid[0])return;
            var colModel = $grid[0].p.colModel;

            cur = [];
            $.each(colModel, function (i, n) {
                var name = this.name;
                if (name != "" && name != 'subgrid')
                    cur[cur.length] = name;
            });
            //cur = ['a', 'b', 'c', 'd', 'e'];
            //        0    1    2    3    4

            cur_index = {};
            $.each(cur, function (i, n) {
                cur_index[n] = i;
            });


            // remapColumns: The indexes of the permutation array are the current order, the values are the new order.

            // new_order       0=>a 1=>c 2=>d 3=>b 4=>e
            // new_order_index a=>0 c=>1 d=>2 b=>3 e=>4

            // cur             0=>a 1=>b 2=>c 3=>d 4=>e
            // cur_index       a=>0 b=>1 c=>2 d=>3 e=>4

            // permutati       0    2    3    1    4
            //                 a    c    d    b    e
            var perm = [];
            $.each(cur, function (i, name) {   // 2=>b

                new_item = new_order[i];     // c goes here
                new_item_index = cur_index[new_item];

                perm[i] = new_item_index;
            });

            if (colModel[0].name == 'subgrid' || colModel[0].name == '') {
                perm.splice(0, 0, 0);
                $.each(perm, function (i, n) {
                    ++perm[i]
                });
                perm[0] = 0;
            }

            $grid.jqGrid("remapColumns", perm, true, false);

        },



    });
})(jQuery);

$(document).on("click", "#frmadmin input[type=button]",function(){
        $("#btnclicked").val($(this).attr('id'));
        $("#frmadmin").submit();
    });
  if ($("#adtable").length > 0) {
        // $("#adtable").jqGrid('navGrid', '#dtbl', { add: false, edit: false, del: false });
        tableToGrid("#adtable", {resizeStop: function(width, index) { 
            saveGridToCookie("adtable", $("#adtable"));
        },
            loadComplete: function () { if (eventList_init) saveGridToCookie("adtable", $("#adtable")); },
            height: $(window).height() - 220, sortable: {
                update: function (relativeColumnOrder) {
                    var grid = jQuery('#gridId');
                    var columnOrder = grid.jqGrid("getGridParam", "remapColumns");
                    // columnOrder now contains exactly what's necessary to pass to to remapColumns
                    // now save columnOrder somewhere
                    globalvar_sortingorder = columnOrder;
                    saveGridToCookie("adtable", $("#adtable"));
                 
                   // save_state();
                }
            }
        });
        var cookiename = ("adtable" + window.location.pathname).replace("/", "");
        
        while(cookiename.indexOf('/')>0){
            cookiename = cookiename.replace("/", "");
        }
       // console.log($.jStorage.get(cookiename));
        if ($.jStorage.get(cookiename)) {
            loadGridFromCookie("adtable");
     
        } else {

        $("#adtable").jqGrid({
 
                viewrecords: true,
                sortorder: "desc",
                height: $(window).height(),
                width: $(window).width() - 320
            });
            jQuery("#adtable").jqGrid('sortableRows');
            eventList_init = true;
       }

     }
     if ($(".adtablelittle").length > 0) {
                 tableToGrid(".adtablelittle", {
            
            height: 100
        });
        $(".adtablelittle").jqGrid({
            sortable: true,
            height: 100,
            width: 700
        });

     }
     
     $("#chball").click(function (e) {
         $(".chbmany").prop('checked', $(this).prop('checked'));

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

     $("#btnexportcsv").click(function (e) {
        
             var a = Array();
            
            $(".chbmany").each(function () {
                if ($(this).prop('checked'))
                    a.push($(this).attr('id').split('-')[1]);

            });
           
            window.open("../admin/export?export=csv&node=" + $("#curnode").val() + "&ids=" + $.toJSON(a));
           
             return false;
         
     });
     $("#btndeletemany").click(function (e) {
         if (confirm("Вы уверены, что хотите удалить эти строки?")) {
             var a = Array();
            
            $(".chbmany").each(function () {
                if ($(this).prop('checked'))
                    a.push($(this).attr('id').split('-')[1]);

            });
           
            window.open("../admin/export?delete=all&field=" + $(this).val() + "&node=" + $("#curnode").val() + "&ids=" + $.toJSON(a));
           
             
         }
     });
     $("#exportfield").change(function (e) {
         if ($(this).val()!='-1') {
             var a = Array();

             $(".chbmany").each(function () {
                 if ($(this).prop('checked'))
                     a.push($(this).attr('id').split('-')[1]);

             });
             window.open("../admin/export?field="+$(this).val()+"&node="+$("#curnode").val()+"&ids=" + $.toJSON(a));
            
         }
     });
     $(".deleteconfirm").click(function (e) {
         if (!confirm("Вы уверены, что хотите удалить эту строку?")) {
             e.preventDefault();
         }
     });
     $(".datepicker").datepicker({
         closeText: 'Закрыть',
         prevText: '&#x3c;Пред',
         nextText: 'След&#x3e;',
         currentText: 'Сегодня',
         monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
         'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
         monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
         'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
         dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
         dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
         dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
         weekHeader: 'Нед',
         dateFormat: 'dd.mm.yy',
         firstDay: 1,
         isRTL: false,
         showMonthAfterYear: false,
         yearSuffix: '',
         dateFormat: 'dd.mm.yy', showOn: "both", changeMonth: true,
         changeYear: true,
             yearRange: "-50:+0"
     });
    if ($(".phoning").length > 0) {

        $(".phoning").mask("+38(999)999-99-99");
    }
    $("#addorder").click(function (e) {
        $("#modal_w").show();
        $("#modal_bg").show();
        e.preventDefault();
    });
    $("#modal_bg,#close_modal").click(function () {

        $(".modal_w").hide();
        $("#modal_bg").hide();
    });

    $("#btnok").click(function () {

        $("#showerror").hide(100);

    });

    $(".delpic").click(function() {

        var ar = this.id.split('-');

        $("#img-" + ar[1]).attr('src', '');
        $("#delpicvalue-" + ar[1]).val("delete");
        return false;
    });

    if($(".treet").length>0)
    $(".treet").treeTable({ treeColumn: 2, initialState: "expanded" });




    if($('.tinyit').length>0)
    $('.tinyit').tinymce({

        script_url: '../../scripts/tiny_mce/tiny_mce.js',

        // General options
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        language: "ru",
        // Theme options
        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,


        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js"
    });
$(document).on("click", ".deleteinfoimage",function(){
 
        var id = $(this).parent().parent().attr("id").split('-');
        console.log(id);
        var target = $(this);
        $.ajax({
            url: '../../admin/del',
            data: 'id='+id[2]+'&lng='+id[3],
            dataType: "json",
            type: "GET",
            success: function (data, textStatus) {
                target.parent().parent().remove();
               
                console.log(data);
            },
            error: function (error) {
                console.log(error); 
            } 
        });
        e.preventDefault();            
   });
   $(document).on("click", ".linktable",function(){

       $(this).html('Таблицей');
       $(".imginfo").toggle();
       $("div.row").addClass('displayinlined');
   });
   $(document).on("click", ".linkaddempty",(function(){

        var target=$(this);
            $.ajax({
            url: '../../admin/ajax',
            data: 'act=addemptyimg',
            dataType: "json",
            type: "GET",
            success: function (response) {
               console.log(response);
               addimagerow(target,response);
                console.log(response);
            },
            error: function (error) {
                console.log(error); 
            } 
        });
   }));
if($(".linkadd").length>0){
    // alert('asd');
    for(var i=0;i<langs.length;i++){
        var target=$(".linkadd")[i];
     var uploader = new qq.FineUploader({
        element: target,
        validation: {sizeLimit: 25000000,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif']},
        debug: true,        text: {
            uploadButton: "Добавить фотографию"
        },
        request: {
            endpoint: '../../admin/ajax?act=ui'
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
            for(var i=0;i<langs.length;i++){
                var lng=langs[i];
                // var targeta = $(".linkadd_"+lng)[i];
                var targeta = $('div').find(".linkadd_"+lng);
                // console.log(targeta);
                // console.log(".linkadd_"+lng);
                addimagerow($(targeta),response,lng);
            }
        }
        }
    });
    console.log(uploader);}
    }
});
function addimagerow(target,response,lng){
            var gotoid="";

            // var art=target.attr('target').split('_');
            // var lng=langs[i];
            // console.log(lng);
            // var row1=$(".empty-img-pattern").outerHTML().replace('display:none;','').replace('new empty-img-pattern','old').replace('infopic-new-00','infopic-old-'+response.imgid+'-'+lng).replace('infopic-path-00','infopic-old-'+response.imgid+'-'+lng);
            // console.log($('.linkadd_'+lng).parent().find(".empty-img-pattern"));
            var row1=$(target).parent().find(".empty-img-pattern").outerHTML().replace('display:none;','').replace('new empty-img-pattern','old').replace('infopic-new-00','infopic-old-'+response.imgid+'-'+lng).replace('infopic-path-00','infopic-old-'+response.imgid+'-'+lng);
            //var row2=$(".empty-img-pattern:eq(1)").outerHTML().replace('display:none;','').replace('empty-img-pattern','old').replace('infopicsec-new-00','infopic-secold-'+response.imgid+'-'+lng);
          while(row1.indexOf('_old')>0){
              row1=row1.replace('_old','_'+response.imgid);
          }
           var addhtml=row1;
           // console.log('#'+target.attr('target'));
           $('#'+target.attr('target')).append(addhtml);
        
        if(gotoid==''){
            gotoid='infopic-old-'+response.imgid+'-'+lng;
        }
           $("#"+'infopic-old-'+response.imgid+'-'+lng).find('img').attr('src',response.tmb);
           $("#infopic-old-"+response.imgid+'-'+lng).find('.path00').val(response.tmb);
           $("#infopic-old-"+response.imgid+'-'+lng).find('.id00').html(response.imgid);
      
   goToByScroll(gotoid);
}
function showerror(header, text) {
    $("#errortext").html(text);
    $("#errorheader").html(header);
    $("#showerror").show(100);

}
function wait() {

}
function unwait() {


}