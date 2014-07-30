<?php

defined('WERUA') or include('../bad.php');

class wfitem extends wfitembase {

    function wfitem() {
        $this->dont=true;
        
    }
    function run(){
        $act = @$_REQUEST['act'];
        switch ($act) {
              case "ui":
            $savepc = new wra_image();
            $savepc->header = '';
            $savepc->description = '';
            $ismessage = false;
            $admimessage = '';
           
           $wimage= wra_admintable::getpic($savepc->pic, $savepc->tmbpic, $ismessage, $admimessage, 'gallery/', 340, 'qqfile', false, true);            
            $savepc->keywords = '';
            $savepc->galinfoid =0;
            $savepc->width=$wimage->imagewidth;
            $savepc->height=$wimage->imageheight;
           
            $languages=wra_lang::getlist();
            $savepc->add("_ru");
            $ruid=$savepc->id;
            foreach($languages as $l0){
                if($l0->alias!='ru')
                    $savepc->add('_'.$l0->alias);
         
                 
            }
           
            echo '{"success":true,"imgid":"'.$ruid.'","tmb":"'.WRA::base_url().$savepc->tmbpic.'"}';       
            break;     
            case 'uploadimage':

                $savepc = new wra_image();
                $savepc->header = '';
                $savepc->description = '';

                $ismessage = false;
                $admimessage = '';
                require_once WRA_Path.'/modules/admin/admintable.php';


                wra_admintable::getpic($savepc->pic, $savepc->tmbpic, $ismessage, $admimessage, 'gallery/', 240, 'qqfile', false, true);
                $savepc->keywords = '';
                $savepc->galinfoid = -1;

                $savepc->add();

                WRA::e(htmlspecialchars(json_encode(array('success' => true, 'picid' => $savepc->id, 'path' => $savepc->tmbpic, 'oldid' => $_REQUEST['id'])), ENT_NOQUOTES));

                break;
            case 'uploadimagepack':
                if (isset($_FILES['Filedata'])) {

                    $savepc = new wra_image();
                    $moreinfo = new wra_iteminfo();
                    $moreinfo->weight = 0;
                    $moreinfo->alt = '';
                    $moreinfo->keywords = '';
                    $moreinfo->autoadres = 0;
                    $moreinfo->adres = '';
                    $moreinfo->commentopt = 2;
                    $moreinfo->mappriority = 0;
                    $moreinfo->authorid = WRA::curuser()->id;

                    $moreinfo->add();
                    $savepc->header = '';
                    $savepc->description = '';
//$savepc->pic=$_POST['fieldpic'];
                    $ismessage = false;
                    $admimessage = '';
                    require_once '../../modules/admin/admintable.php';
                    wra_admintable::getpic($savepc->pic, $savepc->tmbpic, $ismessage, $admimessage, 'gallery/', 240, 'Filedata', false, true);

                    $savepc->galleryid = WRA::getreq('galid');
                    $savepc->keywords = '';
                    $savepc->infoid = $moreinfo->id;


                    $savepc->add();
                }
                WRA::e($savepc->tmbpic . '~@~' . $savepc->id);
                break;
            case 'uploadpic':

                $savepc = new wra_upfile();

                if (isset($_FILES['Filedata'])) {
                    if ($_FILES['Filedata']['size'] != 0) {


                        $savepc->original_filename = $_FILES['Filedata']['name'];

                        $wf = new wra_uploadedfile(WRA_Path);
                        $wf->uploaddir.='files/';

                        $wf->addvalidtype('jpg');
                        $wf->addvalidtype('png');
                        $wf->addvalidtype('gif');
                        $wf->addvalidtype('jpeg');
                        $wf->addvalidtype('jpeg');
                        $wf->addvalidtype('docx');
                        $wf->addvalidtype('pdf');
                        $wf->addvalidtype('doc');
                        $wf->upload('Filedata', true);
                        WRA::e($wf->error);
                        if ($wf->error == '') {
                            $savepc->path_to_file = 'upload/files/' . $wf->filename;
                            $savepc->description = $_FILES['Filedata']['name'] . ' - загружено загрузчиком редактора';

                            $savepc->add();
                        } else {
                            $ismessage = true;

                            switch ($wf->error) {
                                default:
                                    $adminmessage = 'Ошибка загрузки файла';
                                    break;
                            }
                        }
                    }
                }

                WRA::e(WRA::base_url() . $savepc->path_to_file);
                break;
        }
    }

    function show() {
        
    }

}

?>