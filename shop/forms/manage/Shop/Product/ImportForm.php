<?php

namespace shop\forms\manage\Shop\Product;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;

class ImportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $filesCsv;

    public function rules()
    {
        return [
            [['filesCsv'], 'file', 'extensions' => ['csv', 'xls'], 'checkExtensionByMimeType' => false],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            foreach (UploadedFile::getInstances($this, 'filesCsv') as $file) {
                $this->filesCsv = $file;
            }
            $path = Yii::$aliases['@fileCsv'];
            $this->filesCsv->saveAs($path . '/' . $this->filesCsv->baseName . '.' . $this->filesCsv->extension);
            return true;
        }
        return false;
    }
}