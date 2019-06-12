<?php


namespace App\Http\Transforms;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use ReflectionObject;

class Transform
{
    final protected function __construct($input, $extend = false)
    {
        $this->fromArray($input);
        $this->applyFields($input);

        if ($extend) {
            $this->applyExtends($input);
        }
    }

    /**
     * 转化数据
     * @param Model $input
     */
    private function fromArray($input)
    {
        $ref = new ReflectionObject($this);
        $props = $ref->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $string =  strtolower(implode('_', preg_split("/(?=[A-Z])/", $prop->name)));

            if (isset($input[$string])) {
                $this->{$prop->name} = is_null($input[$string]) ? '' : $input[$string];
            }

            if (is_null($this->{$prop->name})) {
                $this->{$prop->name} = '';
            }
        }
    }

    /**
     * 处理字段
     * @param Model $input
     */
    protected function applyFields($input)
    {

    }
    /**
     * 处理字段
     * @param Model $input
     */
    protected function applyExtends($input)
    {
    }

    /**
     * @param $data_array
     *
     * @return Transform|Transform[]
     */
    public static function makeList($data_array)
    {
        if ($data_array instanceof Collection) {
            $data_array = $data_array->all();
        } elseif (is_string($data_array)) {
            return self::make($data_array);
        }

        return array_map([ 'self', 'make' ], $data_array);
    }

    /**
     * @param $data_array
     *
     * @return Transform|Transform[]
     */
    public static function makeBasicList($data_array)
    {
        if ($data_array instanceof Collection) {
            $data_array = $data_array->all();
        } elseif (is_string($data_array)) {
            return self::makeBasic($data_array);
        }

        return array_map([ 'self', 'makeBasic' ], $data_array);
    }


    /**
     * @param LengthAwarePaginator $paginator
     *
     *
     * @return Transform|Transform[]
     */
    public static function makePage(LengthAwarePaginator $paginator)
    {
        $list = array_map([ 'self', 'make' ], $paginator->items());

        $res = [
            'page' => $paginator->currentPage(),
            'pageSize'=> $paginator->lastPage(),
            'length' => $paginator->perPage(),
            'total' => $paginator->total(),
            'list' => $list
        ];

        return $res;
    }

    /**
     * @param LengthAwarePaginator $paginator
     *
     * @return Transform|Transform[]
     */
    public static function makeBasicPage(LengthAwarePaginator $paginator)
    {
        $list = array_map([ 'self', 'makeBasic' ], $paginator->items());

        $res = $paginator->toArray();
        $res['list'] = $list;
        unset($res['data']);

        return $res;
    }

    /**
     * @param $input
     *
     * @return Transform | null
     */
    public static function makeBasic($input)
    {
        if ( ! $input) {
            return null;
        }

        return new static($input, false);
    }

    public static function make($input)
    {
        if ( ! $input) {
            return null;
        }

        return new static($input, true);
    }
}
