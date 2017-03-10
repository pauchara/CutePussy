<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($attachmentModel, 'attachmentFile')
    ->widget(\app\modules\attachment\widgets\AttachmentWidget::className(), ['allowUploadType'=> ['image']]) ?>

<?= \yii\helpers\Html::submitButton('das') ?>

<?php ActiveForm::end() ?>

<?php
echo '<pre>';
var_dump($attachmentModel->attachmentFile);
var_dump($data);
?>
