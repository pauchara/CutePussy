<?php

namespace app\modules\attachment\widgets;

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\widgets\InputWidget;

class AttachmentWidget extends InputWidget
{
    public $allowUploadType = [];

    public function run()
    {
        echo $this->render();
    }

    private function setWidgetOptions()
    {
        if(!empty($this->allowUploadType)) {
            ob_start(); ?>
            <script>
                var acceptMime = <?= json_encode($this->allowUploadType); ?>
            </script>
            <?php
            return ob_get_clean();
        }
    }

    private function getUploadAttachmentTemplate()
    {
        return Html::fileInput('attachmentFile', null, [
            'multiple' => "false",
            'id' => 'attachment-file-upload',
            'v-on:change' => 'loadAjaxFiles',
        ]);
    }

    private function errorBlock()
    {
        ob_start();
        ?>
            <div class="error-block" if="error != null">
                {{error}}
            </div>
        <?php
        return ob_get_clean();
    }

    public function render()
    {
        ob_start(); ?>
        <div id="attachment">

            <img class="selected-file" v-if="selectedFile !== null" v-bind:src="selectedFile.currentModel.link" alt="">

            <?= $this->errorBlock() ?>

            <div class="attach-file-block">
                <label for="attachment-file-upload" class="btn btn-default"> add new attachment </label>

                <?= $this->getUploadAttachmentTemplate() ?>

                <div class="btn btn-default" v-on:click="changeStatusExistingAttachments"> select attachment</div>
                <div class="exist-attachment-block" v-if="showExistingAttachments">
                    <div class="file-item" v-for="file in files">
                        <img v-bind:src="file.link_on_file">
                        <div class="select-file" v-bind:file-id="file.id" v-on:click="getFileInfo">
                            <div class="icon" v-bind:file-id="file.id">+</div>
                        </div>
                    </div>
                    <br>
                    <div class="pagination-block">
                        <div class="previous pagination-btn btn btn-default" v-if="currentPage === 1" disabled><-</div>
                        <div class="previous pagination-btn btn btn-default" v-on:click="previousPage" v-else><-</div>

                        <div class="next pagination-btn btn btn-default" v-if="currentPage === maxPage" disabled>->
                        </div>
                        <div class="next pagination-btn btn btn-default" v-on:click="nextPage" v-else>-></div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->setWidgetOptions() ?>
        <?php
        $this->registerJS();
        return ob_get_clean();

    }

    private function registerJS()
    {
        AttachmentWidgetAssets::register($this->view);
    }
}