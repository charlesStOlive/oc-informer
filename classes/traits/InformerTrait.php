<?php namespace Waka\Informer\Classes\Traits;

use \Waka\Informer\Models\Inform;

trait InformerTrait
{
    public function record_inform($type, $data, $unique = false)
    {
        if ($unique) {
            if ($this->has_informs()) {
                return;
            }
        }
        $inform = new Inform();
        $inform->type = $type;
        $inform->data = $data;
        $this->informs()->save($inform);
    }
    public function delete_informs()
    {
        if (count($this->informs)) {
            $this->informs()->delete();
        };
    }
    public function has_informs($type = null)
    {
        if ($type) {
            if (count($this->informs->where('type', '=', $type))>0) {
                return true;
            }
        } else {
            if (count($this->informs)>0) {
                return true;
            }
        }
        return false;
    }
}
