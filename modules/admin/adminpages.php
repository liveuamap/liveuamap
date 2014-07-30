<?php

defined('WERUA') or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

//классы для системы управления сайтом

class wra_adminmenu {//меню админки - вводится статически

    var $id = -1;
    var $parent_id = -1;
    var $name = '';
    var $link = '';
    var $showmain = true;
    var $subparent = -1;
    var $words=array();
    var $includingone='';
    var $indphp=true;
    static function getclass($req) {//получить пару список-класс

        $req = str_replace('admin?mod=', '', $req);
        $req = str_replace('edit', '', $req);
        $result = '';
        $tempa = array($req=> 'wra_' . $req);
         
        if ($req != '')
            foreach ($tempa as $key => $value) {
                if ($key == $req) {
                    $result = $value;
                    break;
                }
                if ($value == $req) {
                    $result = 'admin?mod=' . $key;
                    break;
                }
            }

        return $result;
    }
    static function getmod($req){
        
        
    }
    static function isexist($req) {//получить пару список-редактирование(архаизм из самой первой версии админки)

       if(class_exists('wra_'.$req)){
           
           return true;
       }else{
           
           
          return false;
       }
    }
    static function getassoc($req) {//получить пару список-редактирование(архаизм из самой первой версии админки)
      $req=str_replace('edit','',$req);
        $useindexphp = false;
        $basereq = $req;
        if ($basereq != $req)
            $useindexphp = true;
        $result = '';
        $tempa = array($req => $req . 'edit');

        foreach ($tempa as $key => $value) {

            if ($key == $req) {
                $result = $value;
                break;
            }
            if ($value == $req) {
                $result = $key;
                break;
            }
        }
        if ($useindexphp) {
            return 'admin?mod=' . $result;
        } else {
            return $result;
        }
    }

    static function getbaseclass() {
        $type = WRA::r('type');
        $curpage = WRA::getcurpage();

        if (!wra_adminpage::isedit()) {
            return wra_adminmenu::getclass($curpage);
        } else {

            return wra_adminmenu::getclass(wra_adminmenu::getassoc($curpage));
        }
    }

    static function getlist0() {
        $result = array();
        $menu_item = new wra_adminmenu();
        $menu_item->id = 1;
        $menu_item->link = '?mod=users';
        $menu_item->name = 'Общие настройки';
        $result[count($result)] = $menu_item;

        $menu_item = new wra_adminmenu();
        $menu_item->id = 2;
        $menu_item->link = '?mod=project';
        $menu_item->name = 'Содержание';
        $result[count($result)] = $menu_item;

        $menu_item = new wra_adminmenu();
        $menu_item->id = 5;
        $menu_item->link = '?mod=structure';
        $menu_item->name = 'Структура';
        $menu_item->showmain = true;


        return $result;
    }

    static function getlistsub($menu_id, $submenu_id) {
        $result = array();
        $temp = wra_adminmenu::getlist1($menu_id);
        foreach ($temp as $t0) {
            if ($t0->subparent == $submenu_id) {
                $result[count($result)] = $t0;
            }
        }

        return $result;
    }

    static function getlist1nosub($menu_id) {
        $result = array();
        $temp = wra_adminmenu::getlist1($menu_id);
        foreach ($temp as $t0) {
            if ($t0->subparent == -1) {
                $result[count($result)] = $t0;
            }
            if($t0->indphp) $t0->link=$t0->link;
        }

        return $result;
    }
static function getlist1($menu_id) {
     $result = array();
    $tempresult = wra_adminmenu::baselist();
    
    for($i=0;$i<count($tempresult);$i++){
       if($tempresult[$i]->parent_id==$menu_id){
            if($tempresult[$i]->indphp) $tempresult[$i]->link='admin?mod='.$tempresult[$i]->link;
            $result[count($result)] = $tempresult[$i];
       } 
       
    }
    return $result;
}
    static function baselist() {
        $result = array();

                $tmpmenu_id=5;
                $menu_item = new wra_adminmenu();
                $menu_item->id = 501;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'structure';
                $menu_item->name = 'Структура';
                $result[count($result)] = $menu_item;

            $tmpmenu_id=1;
                $menu_item = new wra_adminmenu();
                $menu_item->id = 101;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'users';
                $menu_item->name = 'Пользователи';
                $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                $result[count($result)] = $menu_item;
            

                // $menu_item = new wra_adminmenu();
                // $menu_item->id = 104;
                // $menu_item->parent_id = $tmpmenu_id;
                // $menu_item->link = 'menu';
                // $menu_item->name = 'Меню';
                // $menu_item->words=array('пункт меню','пункты меню','пункта меню','пунктов меню','пункту меню','пунктам меню','пункт меню','пункты меню','пунктом меню','пунктами меню','пункте меню','пунктах меню');
                // $result[count($result)] = $menu_item;


                $menu_item = new wra_adminmenu();
                $menu_item->id = 107;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'siteop';
                $menu_item->name = 'Настройка сайта';
                $result[count($result)] = $menu_item;


            $tmpmenu_id=2;        
                // $menu_item = new wra_adminmenu();
                // $menu_item->id = 11101;
                // $menu_item->parent_id = $tmpmenu_id;
                // $menu_item->link = 'contacts';
                // $menu_item->name = 'Контакты';
                // // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                // $result[count($result)] = $menu_item;

                // $menu_item = new wra_adminmenu();
                // $menu_item->id = 11105;
                // $menu_item->parent_id = $tmpmenu_id;
                // $menu_item->link = 'greetings';
                // $menu_item->name = 'Приветствие';
                // // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                // $result[count($result)] = $menu_item;
                

                // $menu_item = new wra_adminmenu();
                // $menu_item->id = 11102;
                // $menu_item->parent_id = $tmpmenu_id;
                // $menu_item->link = 'service';
                // $menu_item->name = 'Услуги';
                // // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                // $result[count($result)] = $menu_item;


                $menu_item = new wra_adminmenu();
                $menu_item->id = 11103;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'project';
                $menu_item->name = 'Проекты в портфолио';
                // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                $result[count($result)] = $menu_item;

                $menu_item = new wra_adminmenu();
                $menu_item->id = 11104;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'projectcat';
                $menu_item->name = 'Категории проектов';
                // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                $result[count($result)] = $menu_item;

                $menu_item = new wra_adminmenu();
                $menu_item->id = 11106;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'text';
                $menu_item->name = 'Переводы';
                // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                $result[count($result)] = $menu_item;

                $menu_item = new wra_adminmenu();
                $menu_item->id = 11105;
                $menu_item->parent_id = $tmpmenu_id;
                $menu_item->link = 'callback';
                $menu_item->name = 'Отзывы';
                // $menu_item->words=array('пользователь','пользователи','пользователя','пользователей','пользователю','пользователям','пользователя','пользователей','пользователем','пользователями','пользователе','пользователях');
                $result[count($result)] = $menu_item;
        return $result;
    }

}

class wra_adminpage {//страница админки 
    var $isedit=false;
    var $message = '';
    var $mod = '';
    var $linklist = '';
    var $linkedit = '';
    var $p_addnewitemlink = ''; //дополнительная ссылка для добавления родительского объекта
    var $p_addnewitem = ''; //добавить новый объект - родительского объект
    var $addnewitemlink = ''; //дополнительная ссылка для добавления базового объекта
    var $addnewitem = ''; //добавить новый объект - базовый объект
    var $addonemoreitem = '';
    var $backtoitemlist = '';
    var $header = '';
    var $editheader = '';
    var $addheader = '';
    var $table = '';
    var $deletetext = '';
    var $class_innner = '';
    var $langs = false;
    var $usenames = true;
    var $adminedit = ''; //значение поля #admin-edit;
    var $curmenu=null;
    function getcurmenu(){
        
    
        $tempresult = wra_adminmenu::baselist();
    
        for($i=0;$i<count($tempresult);$i++){
           if($tempresult[$i]->link==$this->mod){

               $result = $tempresult[$i];
               break;
           } 

        }
        $this->curmenu=$result;
    }
    static function isedit() {
        return strpos(WRA::getcurpage(), 'edit');
    }

    function doedit($wf) {
        $thisclass_string = wra_adminmenu::getbaseclass();
  
        if ($thisclass_string != '') {
            eval('$thisclass=new ' . $thisclass_string . '($wf);');
            if(!true){
             
               WRA::gotopage('admin');

               return;
            }
         
            if (wra_adminpage::isedit()) {

                $backurl = wra_adminmenu::getassoc(WRA::getcurpage());
                if (!WRA::ir('id')) {
                    WRA::gotopage($backurl);
                    WRA::nicedie();
                }

                if (!WRA::ir('type'))
                    $code = '$isexist=' . $thisclass_string . '::isexist($wf,' . WRA::r('id') . ');';
                else {
                    $pid_class = wra_adminmenu::getclass(wra_adminmenu::getassoc(WRA::r('mod')) . '_' . WRA::r('type'));
                    //   echo $pid_class;
                    $code = '$isexist=' . $pid_class . '::isexist($wf,' . WRA::r('id') . ');';
                }
                eval($code);
                if (!$isexist && (WRA::r('id') != -1)) {
                    WRA::gotopage($backurl);
                    WRA::nicedie();
                }
            } else {
                $backurl = WRA::getcurpage();

                if (WRA::ir('pid')) {
                    if (!WRA::ir('type'))
                        $code = '$isexist=' . $thisclass_string . '::isexist($wf,' . WRA::r('pid') . ');';
                    else {
                        $pid_class = wra_adminmenu::getclass(WRA::r('mod') . '_' . WRA::r('type'));
                        // echo $pid_class;
                        $code = '$isexist=' . $pid_class . '::isexist($wf,' . WRA::r('pid') . ');';
                    }
                    eval($code);
                    if (!$isexist) {
                        WRA::gotopage($backurl);
                        WRA::nicedie();
                    }
                }
            }
            $this->deletebyId($wf,$thisclass, $thisclass_string);
        }
    }

    function save() {
        $thisclass_string = wra_adminmenu::getbaseclass();
        if ($thisclass_string != '') {
            if (WRA::isp('admin-edit')) {
                $saveid = -1;
                if (WRA::ir('curID'))
                    $saveid = WRA::r('curID');
                $pid = -1;
                if (WRA::ir('pid'))
                    $pid = WRA::r('pid');

                $languages=wra_lang::getlist();

                $code = '$result=' . $thisclass_string . '::save(' . $saveid . ',' . $pid . ',' . WRA::p('admin-edit') . ','.wra_lang::getdefault().');';
                eval($code);
                
                WRA::setp('id', $result);
                WRA::setr('id', $result);
               
               foreach($languages as $l0){
                    if ($l0->alias != wra_lang::getdefault()){
                        $code = '$result=' . $thisclass_string . '::save(' . $result . ',' . $pid . ',' . WRA::p('admin-edit') . ','.$l0->alias.');';
                        eval($code);
                    }
               }
            }
        }
    }

    function flush() {
        $thisclass_string = wra_adminmenu::getbaseclass();
        $saveid = -1;
        if (WRA::ir('id'))
            $saveid = WRA::r('id');

        $pid = -1;
        if (WRA::ir('pid'))
            $pid = WRA::r('pid');

        if ($thisclass_string != '')
            if (wra_adminpage::isedit()) {
                $languages=wra_lang::getlist();
                // WRA::debug($languages);
                // die();
                wra_admintable::flusheditHead($this);
                foreach($languages as $l0){
                    $code = '$wt=' . $thisclass_string . '::edittable(' . $saveid . ',' . $pid . ','.$l0->alias.');';
                    eval($code);
                    $wt->flushedit($this);
                    if (count($wt->subtables) > 0) {
                        foreach ($wt->subtables as $st) {
                            if ($st->subtypeedit) {
                                $st->subtable = true;
                                $st->flushedit($this);
                            } else {

                                $st->subtable = true;
                                $st->flush();
                            }
                        }
                    }
                }
            } else {
                $code = '$wt=' . $thisclass_string . '::admintable(' . $saveid . ',' . $pid . ');';
                eval($code);
                if ($wt->headertext != '') {
                    WRA::e('<h2>' . $wt->headertext);
                    if ($pid != -1 && $pid != 0) {    
                    }
                    WRA::e('</h2>');
                }
                $wt->flush();
                if (count($wt->subtables) > 0) {
                    foreach ($wt->subtables as $st) {
                        $st->useheader = false;
                        $st->subtable = true;
                        $st->flush();
                    }
                }
            }
    }

    function deletebyId($wf,$obj, $obj_class) {

        if (WRA::isp('deleteId')) {

            if (WRA::p('deleteId') == '')
                return;

            $ar0 = explode('-', WRA::p('deleteId'));
            if ($ar0[0] == '') {
                $code = '$isexist=' . $obj_class . '::isexist($wf,' . $ar0[1] . ');';
                eval($code);
                if ($isexist) {
                    $obj->id = $ar0[1];
                    if ($obj->delete()) {
                        $this->message = $this->de . ' успешно удален!';
                    } else {

                        $this->message = 'Не удалось удалить этого ' . $this->de;
                    }
                }
            } else {
                $code = '$isdelete=' . $obj_class . '::deletecase(' . $ar0[0] . ',' . $ar0[1] . ');';
                eval($code);
                if ($isdelete) {
                    $this->message = 'Объект успешно удален!';
                } else {
                    $this->message = 'Не удалось удалить объект!';
                }
            }
        }
    }

    function getnames() {
        $this->addheader = 'Добавление ' . $this->curmenu->words[2];
        $this->editheader = 'Редактирование ' . $this->curmenu->words[2];
        $this->backtoitemlist = 'Вернутся к списку ' . $this->curmenu->words[8];
        $this->header = 'Администрирование ' . $this->curmenu->words[8];
        $this->addnewitem = 'Добавить ' . $this->curmenu->words[6];
        $this->deletetext.=' ' . $this->curmenu->words[2];
    }

}

?>