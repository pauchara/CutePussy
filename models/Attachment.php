<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property string $link_on_file
 * @property int $size
 * @property string $mime_type
 */
class Attachment extends \yii\db\ActiveRecord
{
    public $attachmentFile = null;
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
            [['size'], 'safe'],
            [['link_on_file'], 'string', 'max' => 60],
            [['mime_type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_on_file' => 'Link On File',
            'size' => 'Size',
            'mime_type' => 'Mime Type',
        ];
    }
}
