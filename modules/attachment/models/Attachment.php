<?php

namespace app\modules\attachment\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property string $link_on_file
 * @property integer $size
 * @property string $mime_type
 */
class Attachment extends ActiveRecord
{
    public static $handler;

    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_on_file', 'size', 'mime_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'link_on_file' => \Yii::t('app', 'Link On File'),
            'size' => \Yii::t('app', 'Size'),
            'mime_type' => \Yii::t('app', 'Mime Type'),
        ];
    }

    public function uploadFile($file)
    {
        $fileFormat = explode('.', $file['name']);
        $fileFormat = $fileFormat[count($fileFormat) - 1];
        $fileName =  \Yii::$app->security->generateRandomString() . '.' . $fileFormat;
        $uploadFile = \Yii::getAlias('@basePath') . DIRECTORY_SEPARATOR . 'fs' . DIRECTORY_SEPARATOR . $fileName;

        if(move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $this->setPropertiesArray(DIRECTORY_SEPARATOR . 'fs' . DIRECTORY_SEPARATOR . $fileName , $file['size'], $file['type']);
        }
    }

    public function setPropertiesArray($link, $size, $type)
    {
        $this->link_on_file = $link;
        $this->size = $size;
        $this->mime_type = $type;
    }

    public function getPropertiesArray()
    {
        return [
            'id' => $this->id,
            'link' => $this->link_on_file,
            'size' => $this->size,
            'type' => $this->mime_type,
        ];
    }
}
