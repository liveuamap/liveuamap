<?php defined('WERUA') or include('../bad.php');
?>
<input type="hidden" id="curnode" name="curnode" value="<?php WRA::e($this->curnode->link); ?>" />
<div class="plan_top">
    <div class="plan_top_header"><span><?php WRA::e($this->curnode->name); ?></span>
        <div class="controls">
                <!-- <input id="btnAdd" type="button" name="btnadd"  value="Добавить" /> -->
                <a href="<?php WRA::e(WRA::base_url()); ?>admin/image/import" id="btnImport">Импортировать</a>
        </div>
    </div>
    <div>
        <table class="plan_top_header_table">
            <tr>
                <td class="td_info td_info_1">Адрес импорта</td>
                <td class="td_patient">
                    <input  id="import_source" name="import_source" type="text" value="<?php WRA::e($this->importUrl); ?>" placeholder="ex. upload/albums">
                </td>
                <td style="width:60px;"></td>
            </tr>
            <tr>
                <td class="td_info td_info_1"></td>
                <td class="td_patient">
                    <input  id="import_source_search_btn" name="import_source_search_btn" type="submit" value="Search">
                    <input  id="import_source_execute_btn" name="import_source_execute_btn" type="submit" value="Execute">
                </td>
                <td style="width:60px;"></td>
            </tr>
            <?php if (isset($this->importUrl)&&!empty($this->importUrl)) { ?>
            <tr>
                <td class="td_info td_info_1">Адрес</td>
                <td class="td_patient">
                   <?php WRA::e($this->importUrl); ?>
                </td>
                <td style="width:60px;"></td>
            </tr>
            <?php } ?>
            <?php if ($this->showAlbums&&isset($this->list)&&!empty($this->list)) { ?>
            <?php foreach ($this->list as $k => $v) {
                ?>
                <tr>
                    <td class="td_info td_info_1"><?php WRA::e($v['header']); ?></td>
                    <td class="td_patient">
                        <?php foreach ($v['images'] as $ki => $vi) {
                            ?>
                           <div><?WRA::e($v['curPath'].'/'.$vi);?></div>
                            <?php
                        } ?>
                    </td>
                    <td style="width:60px;"></td>
                </tr>
                <?php
                // break;
            } ?>
            <?php } ?>
            <?php if ($this->importAlbums&&isset($this->list)&&!empty($this->list)) { ?>
                <input type="hidden" name="importIndex" value="<?php WRA::e($this->importIndex); ?>">
                <input type="hidden" name="import_source_execute_btn" value="<?php WRA::e($this->importIndex); ?>">
                <tr>
                    <td class="td_info td_info_1">Имя галереи</td>
                    <td class="td_patient">
                        <input type="text" name="parttype" placeholder="portfolio">
                    </td>
                    <td style="width:60px;"></td>
                </tr>
                <tr>
                    <td class="td_info td_info_1"></td>
                    <td class="td_patient">
                        <input type="submit" name="import_album" value="import">
                        <input type="submit" name="skip_album" value="skip">
                    </td>
                    <td style="width:60px;"></td>
                </tr>
                <tr>
                    <td class="td_info td_info_1">Название</td>
                    <td class="td_patient">
                        <?php WRA::e($this->list[$this->importIndex]['header']); ?>
                    </td>
                    <td style="width:60px;"></td>
                </tr>
                <tr>
                    <td class="td_info td_info_1"></td>
                    <td class="td_patient">
                        <?php foreach ($this->list[$this->importIndex]['images'] as $ki => $vi) {
                            ?>
                           <div><?WRA::e($vi);?></div>
                            <?php
                        } ?>
                    </td>
                    <td style="width:60px;"></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>