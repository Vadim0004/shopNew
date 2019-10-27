<?php

namespace frontend\widgets\shop;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\assets\ShuffleJs;
use http\Exception\InvalidArgumentException;

class ShuffleJsWidget extends Widget
{
    /**
     * @var array the HTML attributes (name-value pairs) for the container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array shuffle.js options. Read [this](https://vestride.github.io/Shuffle/) for list of options.
     */
    public $clientOptions = [];

    /**
     * @var string HTML content, preferably a list or table.
     * If the widget is used in content capturing mode this will be ignored.
     */
    public $content = '';

    /**
     * @var string name of the view file to render the content.
     * If the widget is used in content capturing mode or a string is assigned to [[content]] property this will be ignored.
     */
    public $view;

    /**
     * @var string name of the view file to render the content.
     * If the widget is used in content capturing mode or a string is assigned to [[content]] property this will be ignored.
     */
    public $layout = "{search}\n{sort}\n{content}";

    /**
     * @var array parameters to be passed to [[view]] when it is being rendered.
     * This property is used only when [[view]] is rendered to generate the content of the widget.
     */
    public $viewParams = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (!isset($this->clientOptions['id'])) {
            $this->clientOptions['id'] = $this->options['id'];
        }

        if (empty($this->clientOptions['itemSelector'])) {
            throw new InvalidArgumentException('The "itemSelector" property of "clientOptions" should be set.');
        }

        if (empty($this->clientOptions['element'])) {
            throw new InvalidArgumentException('The "element" property of "clientOptions" should be set.');
        }

        ob_start();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $content = ob_get_clean();
        $search = '';
        $sort = [];

        $view = $this->getView();

        ShuffleJs::register($view);
        $shuffle = "var Shuffle = window.Shuffle;";
        $elementJs = "document.getElementById('{$this->clientOptions['element']}')";
        $js = "$shuffle const {$this->clientOptions['id']} = new Shuffle(" . $elementJs . ", " . json_encode($this->clientOptions) . ");";
        $view->registerJs($js, $view::POS_END);

        if (empty($content)) {
            if (empty($this->content)) {
                $content = $this->content;
            } elseif ($this->view != null && is_string($this->view)) {
                $content = $view->render($this->view, $this->viewParams);
            }
        }

        $html = str_replace(['{search}', '{sort}', '{content}'], [$search, implode(' ', $sort), $content], $this->layout);

        echo Html::tag('div', $html, $this->options);
    }
}