<?php

namespace app\modules\attachment\controllers;

use app\modules\attachment\models\Attachment;
use app\modules\attachment\models\AttachmentSearchModel;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\LinkPager;

/**
 * Default controller for the `attachment` module
 */
class DefaultController extends Controller
{

    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    public function actionCreateAndReturn()
    {
        $model = new Attachment();

        $model->uploadFile($_FILES['attachmentFile']);

        if ($model->save()) {
            return [
                'currentModel' => $model->getPropertiesArray()
            ];
        }
    }

    public function actionGetFileData()
    {

        $model = Attachment::find()->where(['id' => \Yii::$app->request->post('id')])->one();
        return [
            'currentModel' => $model->getPropertiesArray()
        ];
    }

    protected function getFullModels($models)
    {
        $fullModels = [];
        foreach ($models as $i => $model) {
            $fullModels[] = (object)$model->getPropertiesArray();
        }

        return $fullModels;
    }

    public function actionIndex()
    {
        $searchModel = new AttachmentSearchModel();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return [
            'models' => $this->getFullModels($dataProvider->getModels()),
            'paginationHtml' => LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
                'linkOptions' => ["v-on:click.prevent" => "loadAjax"],
            ])
        ];
    }

    public function actionCountPage()
    {
        return Attachment::find()->count();
    }

    public function actionGetFile()
    {
        (\Yii::$app->request->post());
        $att = new Attachment();
        return $att::find()
            ->limit(\Yii::$app->request->post('fileOnPage'))
            ->offset(\Yii::$app->request->post('fileOnPage')* (\Yii::$app->request->post('currentPage') - 1))
            ->all();
    }
}
