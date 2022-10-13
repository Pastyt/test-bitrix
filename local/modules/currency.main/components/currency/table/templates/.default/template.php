<?php
/**
 * @var $arResult array
 */
?>

<table>
    <tr>
        <td><a href="<?=$arResult['sort']['code']?>">code</a></td>
        <td><a href="<?=$arResult['sort']['date']?>">date</a></td>
        <td><a href="<?=$arResult['sort']['course']?>">course</a></td>
    </tr>
    <?php
    foreach ($arResult['currencies'] as $currency): ?>
        <tr>
            <td><?=$currency['code']?></td>
            <td><?=$currency['date']?></td>
            <td><?=$currency['course']?></td>
        </tr>
    <?php
    endforeach?>
</table>

<table>
    <tr>
        <?php
        foreach ($arResult['pagination'] as $page):?>
            <?php
            if ($page['link']): ?>
                <td><a href="<?= $page['link'] ?>"><?= $page['page'] ?></a></td>
            <?php
            else: ?>
                <td><?= $page['page'] ?></td>
            <?php
            endif ?>
        <?php
        endforeach ?>
    </tr>
</table>

