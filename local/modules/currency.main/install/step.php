<?php
if (!check_bitrix_sessid()) {
    return;
}

global $APPLICATION;

CAdminMessage::ShowNote('Установка модуля прошла успешно');
?>
<form action="<?=$APPLICATION->GetCurPage()?>">
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="submit" name="" value="В список установленных решений">
</form>