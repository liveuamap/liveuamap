<?php
defined('WERUA') or include('../bad.php');

class wfitem extends wfitembase {

    var $curnode;
    var $onpage = 30;
    var $curadmin;
    var $currows = array();
    var $rowscount = 0;
    var $pagescount = 0;
    var $page = 0;
    var $art = array();
    var $adminnodes = array();
    var $noticecount = 0;

    function wfitem($wf) {

        if (wra_userscontext::isloged($wf)&&wra_userscontext::hasright('adminpage')) {
            $wf->cp->baseico = true;
            $wf->cp->norobots();
            $wf->cp->bodyclass = "admin_login";
        } else {
            WRA::gotopage(WRA::base_url() . 'admin/login');
            $wf->nicedie();
        }

        $this->adminnodes = WRA_ENV::adminnodes();
        for ($i = 0; $i < count($this->adminnodes); $i++) {
            if ($_REQUEST['node'] == $this->adminnodes[$i]->link) {
                $this->curnode = $this->adminnodes[$i];
                $this->curadmin = new wfadmin($this->curnode->link);
                break;
            }
        }
        $this->art = json_decode(stripslashes($_REQUEST['ids']));
        if (!is_array($this->art)) {
            $this->art = array();
            $this->art[] = $_REQUEST['ids'];
        }
        $this->header = $this->curnode->name;
        if (!$this->curadmin->multilanguages)
            $this->currows = $this->curadmin->getrows('', $this->page * $this->onpage, $this->onpage);
        else
            $this->currows = $this->curadmin->getrows('_' . WRA_CONF::$language, $this->page * $this->onpage, $this->onpage);
    }

    function run() {
        //$this->nofooter=true;
        // $this->noheader=true;
        if ($_REQUEST['export'] == 'csv') {
                        $this->nofooter = true;
            $this->noheader = true;
        }
        if ($_REQUEST['delete'] == 'all') {

            foreach ($this->art as $a0) {
                $this->curadmin->curid = $a0;
                if ($this->curadmin->multilanguages) {

                    foreach ($this->wf->languages as $v) {
                        $this->curadmin->deletefirst('_' . $v->alias);
                    }
                } else {

                    $this->curadmin->deletefirst('');
                }
            }
        }
    }

    function show() {
        if ($_REQUEST['delete'] == 'all') {
            WRA::e('Строки успешно удалены!');
        } else if ($_REQUEST['export'] == 'csv') {

            header("Content-Type: text/csv; charset=UTF-8");
            header('Content-Disposition: attachment;filename=' . $this->curadmin->table . '.csv');
            $fp = fopen('php://output', 'w');
            $headers = array();
            $headers[]='id';
            foreach ($this->curadmin->columns as $ac) {
                 $str = iconv('utf-8', 'windows-1251',  $ac->header);
                $headers[] = $str;
            }
            fputcsv($fp, $headers, ';');
            foreach ($this->currows as $ad0) {
                if (!in_array($ad0->id, $this->art))
                    continue;
                $headers = array();
                 $headers[]=$ad0->id;
                foreach ($this->curadmin->columns as $ac) {
                    $str = iconv('utf-8', 'windows-1251',  $ad0->values[$ac->field]);
                    $headers[] =$str;
                }
                fputcsv($fp, $headers, ';');
            }

            fclose($fp);
            $this->wf->nicedie();
        } else {
            ?><table><?
            foreach ($this->currows as $ad0) {
                if (!in_array($ad0->id, $this->art))
                    continue;
                foreach ($this->curadmin->columns as $ac) {
                    if ($ac->field != $_REQUEST['field'])
                        continue;
                    ?>
                        <tr><td><? WRA::e($ad0->values[$ac->field]); ?></td></tr>

                    <?php }
                }
            }
            ?></table><?
    }

}
    ?>
