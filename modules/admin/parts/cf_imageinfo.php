<?php
defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact rdx.dnipro@gmail.com</div>');

$curar=array();
$dict=new wra_dictionary();
//$params=array_filter(explode(';',$this->columns[$columni]->description));
//$this->columns[$columni]->description="";
$infoid= $this->columns[$columni]->defaultvalue;
//die($this->columns[$columni]->description.'2');
$waslist=array();
if($infoid!=-1){
  $c0->defaultvalue='';
        $waslist=wra_image::getlistfull($infoid,100);
  

}

WRA::debug($waslist);
WRA::debug($this->lang);

?>
<a href="#" id="linkadd<?php WRA::e($curid);?>">Добавить фотографию</a><br/><br/>

<script type="text/javascript">
var infoimages=new Array();
</script>
<table id="table<?php WRA::e($curid);?>" style="width:100%">
  <thead>  <tr>
        <td style="width:120px">Фотография</td><td style="width:120px">Ссылка</td><td>Описание</td><td>Порядок</td><td>Рамочка</td><td></td>
        </tr>

        </thead><tbody>
        <?php 
        wra_langed::loadlangeddict();
        $languages = wra_lang::getlist();?>
        <?foreach($waslist as $w0){
            ?>
        <tr  id="infopic-old-<?WRA::e($w0->id);?>" class="old">
            <td><img src="<?= WRA::base_url() ?><?WRA::e($w0->tmbpic);?>" width="120px"/></td>
            <td><input type="text" style="width:120px" class="picheader<?php WRA::e($curid);?>" value="<?php WRA::e($w0->header);?>"/></td>
            <?php foreach ($languages as $value) {?>
            <td  class="old trjust trimage tr<?php WRA::e($value->alias);?>" <?php if($value->alias != 'ru') {WRA::e('style="display:none"');}?> >
              <textarea alias="description_<?php WRA::e($value->alias);?>" id= "description_<?php WRA::e($value->alias.'_'.$w0->id);?>" name="fielddescription_<?php WRA::e($value->alias);?>" class="pidescription<?php WRA::e($curid);?>"><?php $dict->e($w0->description,$value->alias);?></textarea>
    
            </td><?php }?>
                <td><input type="text" style="width:50px" class="pisortorder<?php WRA::e($curid);?>" value="<?php WRA::e($w0->sortorder);?>"/></td>
   
              <td><input type="checkbox"  class="pimorevisual<?php WRA::e($curid);?>" value="1" <?php if($w0->morevisual==1){?>checked="checked"<? }?>/></td>
   
        </tr>
        <tr id="infopic-secold-<?WRA::e($w0->id);?>" class="old">
            <td colspan="4"  class="old trjust trimage"  >
             <textarea placeholder="HTML" style="width:490px" alias="htmlcontent_<?php WRA::e($value->alias);?>" id= "description_<?php WRA::e($value->alias.'_'.$w0->id);?>" name="fieldhtmlcontent_<?php WRA::e($value->alias);?>" class="pihtmlcontent<?php WRA::e($curid);?>"><?php WRA::e($w0->htmlcontent);?></textarea>
            </td>

            
            <td><a href="#" class="deleteinfoimage">удалить</a></td> 
        </tr>
        <script type="text/javascript">
                     var apple = {
    id: <?WRA::e($w0->id);?>,
    picid:<?WRA::e($w0->id);?>,
    pic: '<?WRA::e($w0->pic);?>',
    tmbpic: '<?WRA::e($w0->tmbpic);?>',
    header:'<?WRA::e($w0->header);?>',
    htmlcontent:'<?WRA::e($w0->htmlcontent);?>',
    morevisual:'<?WRA::e($w0->morevisual);?>',
      sortorder:'<?WRA::e($w0->sortorder);?>',
    <?php foreach($languages as $value){?>
      description_<?php WRA::e($value->alias);?>:'<? $dict->e($w0->description,$value->alias);?>',
    <?php }?>};
           
                   infoimages.push(apple);
                   </script>
        <?}?>
  
  </tbody>
</table>



<input type="hidden" name="delete-<?php WRA::e($curid);?>" value="" id="delete-<?php WRA::e($curid);?>"/>
<input type="hidden" name="new-<?php WRA::e($curid);?>" value="" id="new-<?php WRA::e($curid);?>"/>
<script type="text/javascript">
    
    var deleteinfoimages=new Array();
    var infoimagescounter=1;
    $(document).ready(function(){
        $(".picheader<?php WRA::e($curid);?>").live('change',function(){
            var ar=$(this).parent().parent().attr('id').split('-');
                 for(i=0;i<infoimages.length;i++){
                     
                   if($(this).parent().parent().hasClass('old')){
                   if(infoimages[i].id==ar[2]){
                       infoimages[i].header=$(this).val();
                   }}else{
                   
                       if(infoimages[i].id=="p"+ar[2]){
                            infoimages[i].header=$(this).val();
                       }
                   
                   }
               } 
                $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
        });
                $(".pisortorder<?php WRA::e($curid);?>").live('change',function(){
            var ar=$(this).parent().parent().attr('id').split('-');
                 for(i=0;i<infoimages.length;i++){
                     
                   if($(this).parent().parent().hasClass('old')){
                   if(infoimages[i].id==ar[2]){
                       infoimages[i].sortorder=$(this).val();
                   }}else{
                   
                       if(infoimages[i].id=="p"+ar[2]){
                            infoimages[i].sortorder=$(this).val();
                       }
                   
                   }
               } 
                $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
        });
                $(".pimorevisual<?php WRA::e($curid);?>").live('change',function(){
            var ar=$(this).parent().parent().attr('id').split('-');
                 for(i=0;i<infoimages.length;i++){
                     
                   if($(this).parent().parent().hasClass('old')){
                   if(infoimages[i].id==ar[2]){
                                     if($(this).attr('checked'))
                            infoimages[i].morevisual=1;
                        else  infoimages[i].morevisual=0;
                   }}else{
                   
                       if(infoimages[i].id=="p"+ar[2]){
                           if($(this).attr('checked'))
                            infoimages[i].morevisual=1;
                        else  infoimages[i].morevisual=0;
                       }
                   
                   }
               } 
                $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
        });
                $(".pihtmlcontent<?php WRA::e($curid);?>").live('change',function(){
            var ar=$(this).parent().parent().attr('id').split('-');
                 for(i=0;i<infoimages.length;i++){
                     
                   if($(this).parent().parent().hasClass('old')){
                   if(infoimages[i].id==ar[2]){
                       infoimages[i].htmlcontent=$(this).val();
                         
                   }}else{
                   
                       if(infoimages[i].id=="p"+ar[2]){
                            infoimages[i].htmlcontent=$(this).val();
                           
                       }
                   
                   }
               } 
            
                $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
        });
        $(".pidescription<?php WRA::e($curid);?>").live('change',function(){
                        var ar=$(this).parent().parent().attr('id').split('-');
                 for(i=0;i<infoimages.length;i++){
                     
                   if($(this).parent().parent().hasClass('old')){
                   if(infoimages[i].id==ar[2]){
                      <?php foreach($languages as $value) {?>
                        infoimages[i][$(this).attr('alias')]=$(this).val();//.description_<?php WRA::e($value->alias);?>=$(this).val();
                      <?php }?>
                   }}else{
                   
                       if(infoimages[i].id=="p"+ar[2]){
                          <?php foreach($languages as $value) {?>
                            infoimages[i][$(this).attr('alias')]=$(this).val();
                          <?php }?>
                       }
                   
                   }
               } 
                 $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
        });
        $("#linkadd<?php WRA::e($curid);?>").click(function(e){
            

           $("#table<?php WRA::e($curid);?>").append('<tr class="new" id="infopic-new-'+infoimagescounter+'">'+
            '<td><div id="file-uploader-'+infoimagescounter+'">Загрузить фото</div></td>'+
            '<td><input type="text" class="picheader<?php WRA::e($curid);?>" value=""/></td>'+
            '<?php foreach ($languages as $value) {?>'+
            '<td class="old trjust trimage tr<?php WRA::e($value->alias);?>"'+ 
            <?php if($value->alias != "ru"){WRA::e('\'style="display:none"\'+');}?> '>'+
              '<textarea alias="description_<?php WRA::e($value->alias);?>" id= "description_<?php WRA::e($value->alias);?>_<?php WRA::e($curid);?>" name="fielddescription_<?php WRA::e($value->alias);?>" class="pidescription<?php WRA::e($curid);?>"></textarea>'+
            '</td><?php }?>'+
            '<td><input type="text" style="width:50px" class="pisortorder<?php WRA::e($curid);?>" value=""/></td>'+
            ' <td><input type="checkbox"  class="pimorevisual<?php WRA::e($curid);?>" value="1"/></td>'+
            '</tr><tr id="infopicsec-new-'+infoimagescounter+'">'+
            '<td colspan="4"  class="old trjust trimage"  >'+
             '<textarea placeholder="HTML" style="width:490px" alias="htmlcontent"  class="pihtmlcontent<?php WRA::e($curid);?>"></textarea>'+
            '</td><td><a href="#" class="deleteinfoimage">удалить</a></td>'+ 
         '</tr>'); 
      
       var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader-'+infoimagescounter),debug:true,
            onComplete: function(id, fileName, responseJSON){
                if(responseJSON.success){
             //   alert(responseJSON.path);
               for(i=0;i<infoimages.length;i++){

                   if(infoimages[i].id=="p"+responseJSON.oldid){
                    
                       infoimages[i].picid=responseJSON.picid;
                   }
               } 
                 $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
                $('#file-uploader-'+responseJSON.oldid).parent().html('<img src="<?= WRA::base_url() ?>'+responseJSON.path+'" width="120px"/>');
                }
            },
            action: '<?= WRA::base_url() ?>ajax/admin/do',
                params: {
        act: 'uploadimage',
        id: infoimagescounter
    }
        });
            var apple = {
    id: "p"+infoimagescounter,picid:-1,
    pic: '',tmbpic: '',header:'',description:''};

    infoimages.push(apple);
      $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
            infoimagescounter++;
            e.preventDefault();
        });
       
       $(".deleteinfoimage").live("click",function(e){
           var ar=$(this).parent().parent().attr('id').split('-');
            $(this).parent().parent().prev().remove();
           $(this).parent().parent().remove();
           if(ar[1]=="new"){
               
               for(i=0;i<infoimages.length;i++){

                   if(infoimages[i].id=="p"+ar[2]){
                      
                       infoimages.splice(i,1);
                   }
               }
               
           }else{
               
            deleteinfoimages.push(ar[2]);
           }
              $("#delete-<?php WRA::e($curid);?>").val($.toJSON(deleteinfoimages));
              $("#new-<?php WRA::e($curid);?>").val($.toJSON(infoimages));
            e.preventDefault();
       }) ;
    });
    </script>
