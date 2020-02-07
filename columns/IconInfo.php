<?php namespace Waka\Informer\Columns;

use Backend\Classes\ListColumn;
use Lang;
use Model;

class IconInfo
{
    use \Waka\Informer\Classes\Traits\InformerHighestTrait;
    /**
     * Default field configuration
     * all these params can be overrided by column config
     * @var array
     */
    private static $defaultFieldConfig = [
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
       //trace_log($column);
        $informHightValue = $field->getInformHighttValue();

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
    
    public function getCountTypeInform($type) {
        if($type == '*') {
            return $this->record->informs()->get()->count();
        } else {
            return $this->record->informs()->where('type', '=', $type)->get()->count();
        }
    }



    
}