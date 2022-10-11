<?php
if (!check_bitrix_sessid()) {
    return;
}

global $APPLICATION;

CAdminMessage::ShowNote('Успешное удаление');
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="submit" name="" value="Перейти в список установленных решений">
<form>