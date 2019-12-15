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
        'popup_label_warning' => null,
        'popup_label_success' => null,
        'popup_label_problem' => null,
        'popup_data'    => null,
        'launch_request' => false,
        'request' => 'onCallInfoPopupBehavior',
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

        if($config['launch_request']) {
            return '
<a href="javascript:;"
    data-request="' . $config['request'] . '"
    data-request-data="' . $field->getRequestData() . '"
    data-stripe-load-indicator
    style="color:'.$field->getColorValue().'"
    title="' . $field->getButtonTitle() . '">
    <i class="' . $field->getIconValue() . ' icon-lg"></i>
</a>
';

        } else {
            return '
<a href="javascript:;"
    data-stripe-load-indicator
    style="color:'.$field->getColorValue().'"
    title="' . $field->getButtonTitle() . '">
    <i class="' . $field->getIconValue() .' icon-lg"></i>
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
     * Return button text or icon
     *
     * @return string
     */
    public function getIconValue()
    {
        $icon;
        switch ($this->value) {
            case 'warning':
                $icon = $this->getConfig('icon_warning');
                break;
            case 'problem':
                $icon = $this->getConfig('icon_problem');
                break;
            case 'success':
                $icon = $this->getConfig('icon_success');
                break;
        }
        return $icon;
    }

    /**
     * Return the wright tooltip
     *
     * @return string
     */
    public function getToolTipValue()
    {
        $toolTip;
        switch ($this->value) {
            case 'warning':
                $toolTip = $this->getConfig('popup_label_warning');
                break;
            case 'problem':
                $toolTip = $this->getConfig('popup_label_problem');
                break;
            case 'success':
                $toolTip = $this->getConfig('popup_label_success');
                break;
        }
        return $toolTip;
    }

    /**
     * Return the wright color
     *
     * @return string
     */
    public function getColorValue()
    {
        $color = 'grey';
        switch ($this->value) {
            case 'warning':
                $color = 'orange';
                break;
            case 'problem':
                $color = 'red';
                break;
            case 'success':
                $color = 'green';
                break;
        }
        return $color;
    }

    /**
     * Return button hover title
     *
     * @return string
     */
    public function getButtonTitle()
    {
        return 'Info';
    }
}