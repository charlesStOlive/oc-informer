<?php namespace Waka\Informer\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * InformField Form Widget
 */
class InformField extends FormWidgetBase
{
    use \Waka\Informer\Classes\Traits\InformerHighestTrait;
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'waka_informer_inform_field';

    public $valueFrom;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'valueFrom',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('informfield');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        // Fonction est dans le informerHighestTrait
        $informHightValue = $this->getInformHighttValue();
        //
        $this->vars['name'] = $this->model[$this->valueFrom];
        $this->vars['modelClass'] = str_replace('\\', '\\\\', get_class($this->model));
        $this->vars['modelId'] = $this->model->id;
        $this->vars['icon'] = $this->getIconValue($informHightValue);
        $this->vars['color'] = $this->getColorValue($informHightValue);
        $this->vars['buttonTitle'] = $this->getButtonTitle($informHightValue);
    }

    public function getCountTypeInform($type)
    {
        if ($type == '*') {
            return $this->model->informs()->get()->count();
        } else {
            return $this->model->informs()->where('type', '=', $type)->get()->count();
        }
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/informfield.css', 'Waka.Informer');
        $this->addJs('js/informfield.js', 'Waka.Informer');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
