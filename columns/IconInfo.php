<?php namespace Waka\Informer\Columns;

use Backend\Classes\ListColumn;
use Lang;
use Model;

class IconInfo
{
    /**
     * Default field configuration
     * all these params can be overrided by column config
     * @var array
     */
    private static $defaultFieldConfig = [
        'icon_warning'  => 'icon-exclamation-circle',
        'icon_success' => 'icon-check-circle',
        'icon_problem'   => 'icon-minus-circle',
        'icon_info'   => 'icon-info',
        'icon-comments' => 'icon-comments',
        'request' => 'onCallInfoPopupBehavior',
        'show_null' => false,
        'icon_null' => 'icon-check'
    ];

    private static $listConfig = [];
    public static $config;

    /**
     * @param       $field
     * @param array $config
     *
     * @internal param $name
     */
    public static function storeFieldConfig($field, array $config)
    {
        self::$listConfig[$field] = array_merge(self::$defaultFieldConfig, $config, ['name' => $field]);
    }

    /**
     * @param            $value
     * @param ListColumn $column
     * @param Model      $record
     *
     * @return string HTML
     */
    public static function render($value, ListColumn $column, Model $record)
    {
        $field = new self($value, $column, $record);
        $config = $field->getConfig();
        $informHightValue = $field->getInformHighttValue();
        trace_log("informHightValue : ".$informHightValue);

        if(!$informHightValue && !$config['show_null']) {
            return null;
        }
        //
        if(!$informHightValue && $config['show_null']) {
            return '
<span style="color:green">
    <i class="' . $config['icon_null'] .' icon-lg"></i>
</span>
';
        }
        //

        if($config['launch_request']) {
            return '
<a href="javascript:;"
    data-control="popup"
    data-handler="' . $config['request'] . '"
    data-request-data="' . $field->getRequestData() . '"
    style="color:'.$field->getColorValue($informHightValue).'"
    title="' . $field->getButtonTitle($informHightValue) . '">
    <i class="' . $field->getIconValue($informHightValue) . ' icon-lg"></i>
</a>
';

        } else {
            return '
<a href="javascript:;"
    style="color:'.$field->getColorValue($informHightValue).'"
    title="' . $field->getButtonTitle($informHightValue) . '">
    <i class="' . $field->getIconValue($informHightValue) .' icon-lg"></i>
</a>
';
            
        }

        
    }

    /**
     * ListSwitchField constructor.
     *
     * @param            $value
     * @param ListColumn $column
     * @param Model      $record
     */
    public function __construct($value, ListColumn $column, Model $record)
    {
        $this->name = $column->columnName;
        $this->value = $value;
        $this->column = $column;
        $this->record = $record;
    }

    /**
     * @param $config
     *
     * @return mixed
     */

    private function getConfig($config = null)
    {
        if (is_null($config)) {
            return self::$listConfig[$this->name];
        }

        return self::$listConfig[$this->name][$config];
    }

    /**
     * Return data-request-data params for the switch button
     *
     * @return string
     */
    public function getRequestData()
    {
        $modelClass = str_replace('\\', '\\\\', get_class($this->record));

        $data = [
            "id: {$this->record->{$this->record->getKeyName()}}",
            "field: '$this->name'",
            "model: '$modelClass'"
        ];

        if (post('page')) {
            $data[] = "page: " . post('page');
        }

        return implode(', ', $data);
    }

    /**
     * Return inform value
     *
     * @return model
     */
    public function getInformHighttValue()
    {

        if($this->getCountTypeInform('*') == 0) {
            return $this->informHightValue = null;
        }
        if($this->getCountTypeInform('problem')) {
            return $this->informHightValue = 'problem';
        }
        if($this->getCountTypeInform('warning')) {
            return $this->informHightValue = 'warning';
        }
        if($this->getCountTypeInform('info')) {
            return $this->informHightValue = 'info';
        }
        if($this->getCountTypeInform('success')) {
            return $this->informHightValue = 'success';
        }
    }
    public function getCountTypeInform($type) {
        if($type == '*') {
            return $this->record->informs()->get()->count();
        } else {
            return $this->record->informs()->where('type', '=', $type)->get()->count();
        }
    }



    /**
     * Return button text or icon
     *
     * @return string
     */
    public function getIconValue($informHightValue)
    {
        $icon;
        switch ($informHightValue) {
            case 'warning':
                $icon = $this->getConfig('icon_warning');
                break;
            case 'problem':
                $icon = $this->getConfig('icon_problem');
                break;
            case 'success':
                $icon = $this->getConfig('icon_success');
                break;
            case 'info':
                $icon = $this->getConfig('icon_info');
                break;
        }
        return $icon;
    }

    /**
     * Return the wright tooltip
     *
     * @return string
     */

    /**
     * Return the wright color
     *
     * @return string
     */
    public function getColorValue($informHightValue)
    {
        $color = 'grey';
        switch ($informHightValue) {
            case 'warning':
                $color = 'orange';
                break;
            case 'problem':
                $color = 'red';
                break;
            case 'success':
                $color = 'green';
                break;
            case 'info':
                $color = 'info';
                break;
        }
        return $color;
    }

    /**
     * Return button hover title
     *
     * @return string
     */
    public function getButtonTitle($informHightValue)
    {
        $color = 'Cliquez pour voir les ';
        switch ($informHightValue) {
            case 'warning':
                $color .= 'alertes';
                break;
            case 'problem':
                $color .= 'erreurs';
                break;
            case 'success':
                $color .= 'succès';
                break;
            case 'info':
                $color .= 'infos';
                break;
        }
        return $color;
    }
}