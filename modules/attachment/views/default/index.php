<?php
    use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($attachmentModel, 'attachmentFile')->fileInput()
    ->widget(\app\modules\attachment\widgets\AttachmentWidget::className(), ['allowUploadType'=> ['jpg', 'png']]) ?>

<?= \yii\helpers\Html::submitButton() ?>

<?php ActiveForm::end() ?>