<?php

use yii\db\Migration;

class m170303_083717_attachments extends Migration
{
    public function up()
    {
        $this->createTable('attachment', [
            'id' => $this->primaryKey(),
            'link_on_file' => $this->string(60)->notNull(),
            'size' => $this->integer()->notNull(),
            'mime_type' => $this->string(20)->notNull(),
        ]);
    }

    public function down()
    {
        $this->delete('attachment');
    }
}
