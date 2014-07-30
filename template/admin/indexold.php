<? defined('WERUA') or include('../bad.php');

 ?>
<div id="finding-nemo" title="Сервер занят" style="display: none">
    <div id="finding-nemo-text">Подождите, ваш запрос обрабатывается!</div>
    <br />
    <br />
    <img src="<?WRA::e(WRA::base_url());?>images/loadingAnimation.gif" alt="В процессе" /></div>
<div id="bigbang-theory" title="Система управления содержимым"
     style="display: none">
    <div>Загрузка файл<br />
        <span id="bigbang-theory-placeholder"> </span><a href="#" id="bigbang-theory-file">выбрать файл для загрузки</a></div>
    <br />
    <br />

</div>
<div id="shoot-walle" title="Система управления содержимым"
     style="display: none">
    <div id="shoot-walle-text">сообщение</div>
    <br />
    <br />

</div>


<div class="top_line_index_all"><img src="<?WRA::e(WRA::base_url());?>modules/admin/images/bg_top_all.jpg" width="100%" height="5"></div>

<!--content-->
<div class="content_all">
    <?
    include WRA_Path."/modules/admin/parts/header.php";
    ?>
    <!--content_center-->
    <?	 ?>
    <form id="adminform" name="adminform" enctype="multipart/form-data" method="POST" action="<? WRA::e($this->currentlink);?>"><input type="hidden" value="<? WRA::e($this->cap->deletetext);?>" id="delete-text" name="delete-text" />
        <input type="hidden" value="<? WRA::e($this->editlink_withoutid);?>" id="edit-link" name="edit-link" /> 
        <input type="hidden" id="default-admin-edit" name="default-admin-edit" value="<? WRA::e($this->cap->adminedit); ?>" /><? //значение admin-edit по умолчанию		?>
        <input type="hidden" id="admin-edit" name="admin-edit" value="<?WRA::e($this->cap->adminedit);?>" /> 
        <input type="hidden" id="parent-path" name="parent-path" value="<?WRA::e(stripslashes(WRA::r("pid")));?>" /> <input type="hidden" value="" id="deleteId" name="deleteId" />
        <input type="hidden" value="" id="admwe1current-pic-field" name="admwe1current-pic-field" />
        <div class="content_main_center">
            <table width="100%" height="68%">
                <tr>
                    <? 
                 
                    if ($this->useleftmenu != - 1) {
                    
                        include WRA_Path. '/modules/admin/parts/leftmenu.php';
                    }
                    ?>
                    <td valign="top" <?
                    if ($this->useleftmenu != - 1) {
                        ?> width="65%"<?
                    }
                    ?>>
                            <?
                            if ($this->useleftmenu != - 1) {
                                if ($this->inner_content_text) {
                                    ?>
                                    <?
                                    if ($this->cap->addnewitem != "") {
                                        if (!strpos(WRA::getcurpage(), "edit"))
                                            $addlink = wra_adminmenu::getassoc(WRA::getcurpage()) . '&id=-1';
                                        else
                                            $addlink = WRA::getcurpage() . '&id=-1';

                                        if (WRA::ir("pid"))
                                            $addlink .= "&pid=" . WRA::r("pid");

                                        $backlink = wra_adminmenu::getassoc(WRA::getcurpage()) . '&id=-1';

                                        if ($this->cap->addnewitemlink != "") {
                                            $backlink .= $this->cap->addnewitemlink;
                                        }
                                        if (WRA::ir('pid')) {
                                            $backlink .= "&pid=" . WRA::r('pid');
                                        }
                                        if ($this->useadd_button) {
                                            ?>
                                        <div class="add_block_inner"><a
                                                href="<?
                            WRA::e($addlink . $this->cap->addnewitemlink);
                                            ?>"><?
                                WRA::e($this->cap->addnewitem);
                                            ?></a></div>


                                        <?
                                        if ($this->cap->p_addnewitem != "") {
                                            ?>
                                            <div class="add_block_inner"><a
                                                    href="<?
                        WRA::e($addlink . $this->cap->p_addnewitemlink);
                                            ?>"><?
                                WRA::e($this->cap->p_addnewitem);
                                            ?></a></div>
                                            <?
                                        }
                                    }
                                    ?>
                                    <?
                                }
                                ?>
                                <div class="inner_content_text"><?
                    }
                }
                        ?>
                            <?
                            flushpage($this->cp, $this->cap);
                            ?>
                            <?
                            if ($this->useleftmenu != - 1) {
                                if ($this->inner_content_text) {
                                    ?> </div><?
                        }
                    }
                            ?>
                    </td>
                    <td width="190px" valign="top" style="text-align:center;font-size: 12px;">
                        <!-- <a href="admin/export" target="_blank">Экспортировать друзей</a><br/><br/>
                        <a href="admin/export?type=orders" target="_blank">Экспортировать заказы</a> -->
                    </td>
                </tr>
            </table>
        </div>
    </form>
    
    <?
    if ($this->cap->message != '') {
        ?>
        <script>
            $(document).ready(function(){

                doalert('<? WRA::e($this->cap->message); ?>');
            });
        </script>
        <?
    }
    ?>



    <?
    include WRA_Path. '/modules/admin/parts/footer.php';
    ?>

</div>

