<?php defined('WERUA') or include('../bad.php');

?><?
?>
<div class="plan_top">
		<div class="plan_top_header"><span>"Настройки сайта"</span><div class="controls"><input type="button" id="btnsave" name="btnsave" value="Сохранить"   /></div></div>

<table class="plan_top_header_table">
			<tbody>
<tr ><td></td><td class="td_info td_info_1">Телефон</td><td><input type="text" value="<?WRA::e($this->wf->options['phone']);?>"  id="txtusd" name="phone" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">email</td><td><input type="text" value="<?WRA::e($this->wf->options['email']);?>"  id="txtusd" name="email" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">fb</td><td><input type="text" value="<?WRA::e($this->wf->options['fb']);?>"  id="txtusd" name="fb" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">vk</td><td><input type="text" value="<?WRA::e($this->wf->options['vk']);?>"  id="txtusd" name="vk" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">insta</td><td><input type="text" value="<?WRA::e($this->wf->options['insta']);?>"  id="txtusd" name="insta" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">lj</td><td><input type="text" value="<?WRA::e($this->wf->options['lj']);?>"  id="txtusd" name="lj" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">blogger</td><td><input type="text" value="<?WRA::e($this->wf->options['blogger']);?>"  id="txtusd" name="blogger" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">flickr</td><td><input type="text" value="<?WRA::e($this->wf->options['flickr']);?>"  id="txtusd" name="flickr" /></td></tr>
<?if(false){?>
<tr><td></td><td class="td_info td_info_1">Включен</td><td>
    <input type="checkbox" id="chbon" name="chbon"  <?if(intval($this->wf->options['chbon'])==1){?>checked="checked"<?}?> />
    </td></tr>
<tr ><td></td><td class="td_info td_info_header" colspan="2">Платежная информация</td></tr>
<tr ><td></td><td class="td_info td_info_1">Коммерческий курс доллара(USD)</td><td><input type="text" value="<?WRA::e($this->wf->options['usd']);?>"  id="txtusd" name="txtusd" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">Коммерческий курс евро(EUR)</td><td><input type="text" value="<?WRA::e($this->wf->options['eur']);?>" id="txteur" name="txteur" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">Коммерческий курс рубля(RUR)</td><td><input type="text" value="<?WRA::e($this->wf->options['rur']);?>" id="txtrur" name="txtrur" /></td></tr>


<tr ><td></td><td class="td_info td_info_header" colspan="2">Контактная информация</td></tr>
<tr ><td></td><td class="td_info td_info_1">Контактный email</td><td><input type="text" id="txtcontactemail" value="<?WRA::e($this->wf->options['contactemail']);?>" name="txtcontactemail" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">Контактный телефон</td><td><input type="text" id="txtconphone" value="<?WRA::e($this->wf->options['conphone']);?>" name="txtconphone" /></td></tr>
<tr ><td></td><td class="td_info td_info_1">Skype</td><td><input type="text" id="txtconskype" name="txtconskype" value="<?WRA::e($this->wf->options['conskype']);?>"/></td></tr>
<tr ><td></td><td class="td_info td_info_1">Контактный телефон3</td><td><input type="text" id="txtconphone2" name="txtconphone2" value="<?WRA::e($this->wf->options['conphone2']);?>" /></td></tr>

<tr><td></td><td class="td_info td_info_1">Страница FB</td><td><input type="text" id="txtcontactfb" name="txtcontactfb" value="<?WRA::e($this->wf->options['contactfb']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">Страница VK</td><td><input type="text" id="txtcontactvk" name="txtcontactvk" value="<?WRA::e($this->wf->options['contactvk']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">Instagram</td><td><input type="text" id="txtconinsta" name="txtconinsta" value="<?WRA::e($this->wf->options['coninsta']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">Foursquare</td><td><input type="text" id="txtcontactfsq" name="txtcontactfsq"  value="<?WRA::e($this->wf->options['contactfsq']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">Linked In</td><td><input type="text" id="txtcontactlin" name="txtcontactlin"  value="<?WRA::e($this->wf->options['contactlin']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">Twitter</td><td><input type="text" id="txtcontacttwi" name="txtcontacttwi"  value="<?WRA::e($this->wf->options['contacttwi']);?>" /></td></tr>
<tr><td></td><td class="td_info td_info_1">Google Plus</td><td><input type="text" id="txtcontactgp" name="txtcontactgp"  value="<?WRA::e($this->wf->options['contactgp']);?>"/></td></tr>
<tr><td></td><td class="td_info td_info_1">YouTube</td><td><input type="text" id="txtcontactytb" name="txtcontactytb"  value="<?WRA::e($this->wf->options['contactytb']);?>"/></td></tr>

<tr ><td></td><td class="td_info td_info_1">Код Яндекс-метрики</td><td><textarea  id="txtyametrica" name="txtyametrica"  ><?WRA::e($this->wf->options['yametrica']);?></textarea></td></tr>
<tr ><td></td><td class="td_info td_info_1">Код Google Analytics</td><td><textarea  id="txtgametrica" name="txtgametrica" ><?WRA::e($this->wf->options['gametrica']);?></textarea></td></tr>
<?}?>
</tbody>
</table></div>