<?php

defined('C5_EXECUTE') or die('Access denied.');

/**
 * @var Concrete\Core\Form\Service\Form $form
 *
 * @var string $rxValidID
 * @var int $idMaxLength
 * @var string $validAnchorMessage
 * 
 * @var string $anchorName
 * @var int $offsetY
 *
 */
?>
<div class="form-group">
    <?= $form->label('anchorName', t('Anchor Name')) ?>
    <?= $form->text('anchorName', $anchorName, ['required' => 'required', 'maxlength' => $idMaxLength, 'pattern' => $rxValidID]) ?>
    <div class="small text-muted">
        <?= nl2br(h($validAnchorMessage)) ?>
    </div>
</div>
<div class="form-group">
    <?= $form->label('offsetY', t('Vertical offset')) ?>
    <?= $form->number('offsetY', (string) $offsetY, ['step' => '1']) ?>
    <div class="small text-muted">
        <?= t('For example, you may want to use negative numbers if you have a fixed top menu.') ?>
    </div>
</div>
