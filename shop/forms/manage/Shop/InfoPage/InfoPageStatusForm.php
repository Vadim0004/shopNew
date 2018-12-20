<?php

namespace shop\forms\manage\Shop\InfoPage;

use shop\entities\Shop\InfoPage\InfoPage;
use yii\base\Model;

class InfoPageStatusForm extends Model
{
    public $sysId;

    private $_infoPage;

    public function __construct(InfoPage $infoPage = null, array $config = [])
    {
        if ($infoPage) {
            $this->sysId = $infoPage->sys_id;
            $this->_infoPage = $infoPage;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['sysId'], 'required'],
        ];
    }
}