<?php

defined('WERUA') or include('../bad.php');

class wfitem extends wfitembase {

    function wfitem($wf) {
        //  require_once WRA_Path. '/modules/admin/admintable.php';
        // require_once WRA_Path.'/modules/admin/adminpages.php'; 
        $this->header = 'Администрирование';
        $wf->cp->baseico = true;
        $wf->cp->norobots();
        $wf->cp->bodyclass = "admin_login";
        if (wra_userscontext::isloged($wf)&&wra_userscontext::hasright('adminpage')) {
            if (isset($_REQUEST['act'])) {
                @wra_userscontext::logout();
                if (@$_REQUEST['backurl'] == 'index.php') {
                    WRA::gotopage('');
                    $this->wf->nicedie();
                }
            }
            WRA::gotopage('../admin');
            $wf->nicedie();
        }
    }

    function run() {
        $this->nofooter=true;
        $this->noheader=false;
        if (isset($_POST['admin_login'])) {
            $this->enter_try = -1;
            $isremember = false;

            if (isset($_POST['rememberme'])) {
                $isremember = true;
            }
            $login = addslashes($_POST['admin_login']);
            $pass = $_POST['admin_pass'];
        
            $this->enter_try = wra_userscontext::login($this->wf,$login, $pass, $isremember);
        } 
   
        if (isset($_REQUEST['act'])) {
            // die($_REQUEST['act']);
            wra_userscontext::logout();
            if (@$_REQUEST['backurl'] == 'index.php') {

                WRA::gotopage('');
                $this->wf->nicedie();
            }
        }

        if (wra_userscontext::isloged($this->wf)) {
            switch (@$_POST['returnurl']) {
                case 'admin':
                default:
                    if (wra_userscontext::hasright('adminpage')) {
                        WRA::gotopage(WRA::base_url().'admin');
                        $this->wf->nicedie();
                    } else {
                        $this->enter_try = 3;
                    }
                    break;
            }
        } else {
            switch (@$_REQUEST['returnurl']) {
                case 'user':
                    WRA::gotopage(WRA::base_url());
                    $this->wf->nicedie();

                    break;
            }
        }
    }

    function addscripts() {
        $this->wf->cp->add_jquery();
        // $this->wf->cp->add_script( 'scripts/nk.js' );
        $this->wf->cp->add_script('modules/admin/scripts/login.js');
    }

    function addstyles() {
        //$//this->wf->cp->add_style( 'styles/nk.css' );
        $this->wf->cp->add_style('modules/admin/styles/main.css');
    }

}

?>
