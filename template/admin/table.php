<?php defined('WERUA') or include('../bad.php');
?>
<input type="hidden" id="curnode" name="curnode" value="<?php WRA::e($this->curnode->link); ?>" />
<div class="plan_top">
    <div class="plan_top_header"><span><?php WRA::e($this->curnode->name); ?></span><div class="controls">
            <input id="btnAdd" type="button" name="btnadd"  value="Добавить" /></div></div>
    <div class="searchfield">
        <input type="text" id="txtfind" name="txtfind" value="<?php WRA::e($this->curadmin->search);?>"  /><input type="button" id="btnfind" name="btnfind" value="Поиск" />
        <?php if ($this->pagescount > 0) { ?>   Страницы: <?php
            for ($i = 0; $i < $this->pagescount; $i++) {

                if ($i == $this->page) {
                    ?><span><?php WRA::e($i + 1); ?></span> <?php
        } else {
                    ?>
                    <a href="<?php WRA::e(WRA::base_url() . $this->curnode->link); ?>?page=<?php WRA::e($i); ?>"><?php WRA::e($i + 1); ?></a>
                <?php
                }
            }
        }
        ?> <strong>Всего записей: <?WRA::e(count($this->currows).' из '.$this->totalcount);?></strong>
    </div>
    <table id="adtable">
        <thead>
            <tr><th width="24"></th>
                <?php
                foreach ($this->curadmin->columns as $ac) {
                    if ($ac->tablestatus == admincolumntype::none)
                        continue;
                    ?>
                    <th <?php if ($ac->width != 0) { ?> width="<?php WRA::e($ac->width); ?>"<?php } ?>><?php WRA::e($ac->header); ?></th>
<?php } ?>
                <th>Редактировать</th>
                <th>Просмотреть</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>

                <?php foreach ($this->currows as $ad0) {
                    ?>
                <tr><td><input type="checkbox" class="chbmany" id="chb-<?php WRA::e($ad0->id); ?>"/></td>
                    <?php
                    foreach ($this->curadmin->columns as $ac) {
                        if ($ac->tablestatus == admincolumntype::none)
                            continue;
                        ?>
                        <td <?php if ($ac->width != 0) { ?> width="<?php WRA::e($ac->width); ?>"<?php } ?>><?php
                    $tdcontent = $ad0->values[$ac->field];
         
                    switch ($ac->tablestatus) {
                        case admincolumntype::fromdrop:
                            WRA::e($ac->dropdown[$tdcontent]);
                            break;
                        case admincolumntype::h2header:
                            if (!$ac->isparent) {
                                WRA::e('<h2>' . $tdcontent . '</h2>');
                            } else {
                                if ($this->info == "")
                                    WRA::e('<h2><a href="' . WRA::getcurpage() . '&pid=' . $ad->id . '">' . $tdcontent . "</a></h2>");
                                else
                                    WRA::e('<h2><a href="' . WRA::getcurpage() . '&pid=' . $ad->id . '&type=' . $this->info . '">' . $tdcontent . "</a></h2>");
                            }
                            break;
                        case admincolumntype::date:

                            WRA::e('<span class="date_content">' . $ac->header . ': ' . $tdcontent . '</span>');
                            break;
                        case admincolumntype::link:
                            WRA::e('<a target="_blank"  href="' . $tdcontent . '">' . $tdcontent . "</a>");

                            break;
                        case admincolumntype::check:
                     
                            if ($tdcontent == 1) {
                                WRA::e('Да');
                            } else {

                                WRA::e('Нет');
                            }
                         
                            break;
                        case admincolumntype::pic:
                            if ($tdcontent != "") {
                                WRA::e('<img style="height:100px" src="' . WRA::base_url() . $tdcontent . '"/>');
                            } else {

                                WRA::e($tdcontent);
                            }break;
                        case admincolumntype::id:

                            break;
                        case admincolumntype::text:
                        default:
                                ?><?
                            if ($ac->isparent) {
                                WRA::e('<h2><a href="' . WRA::getcurpage() . '&pid=' . $ad->id . '">' . $tdcontent . "</a></h2>");
                            } else {

                                WRA::e($tdcontent);
                            }
                    }
                    ?></td>
                <?php } ?>
                <td><a href="<?php WRA::e(WRA::base_url() . $this->curnode->link . "/edit?id=" . $ad0->id); ?>">редактировать</a> </td>
                <td><a href="<?php WRA::e(WRA::base_url() . $this->curnode->link . "/view?id=" . $ad0->id); ?>">просмотреть</a> </td>
                <td><a class="deleteconfirm" href="<?php WRA::e(WRA::base_url() . $this->curnode->link . "/edit?act=delete&id=" . $ad0->id); ?>">удалить</a> </td>
                </tr>
<?php } ?>
        </tbody>
    </table>
    <div id="adactions"><img src="../images/wf/arrow_ltr.png">С выделенными:  <input id="btndeletemany" type="button" value="Удалить"/><input id="btnexportcsv" type="button" value="Экспортировать в CSV"/>
        &nbsp;Экспортировать поле: <select id="exportfield"><option value="-1">Выберите</option><?php
foreach ($this->curadmin->columns as $ac) {
    if ($ac->tablestatus == admincolumntype::none)
        continue;
    ?><option value="<?php WRA::e($ac->field); ?>"><?php WRA::e($ac->header); ?></option><?php } ?></select>
       
    </div>
</div>