<?php

namespace Zeero\SchemaBuilder\traits;

trait setType
{
    // process
    private function setsTypes(array $info)
    {
        $type = $info['type'];
        $name = $info['name'];
        $values = $info['values'];

        $values = array_map(function ($item) {
            return "\"{$item}\"";
        }, $values);

        $s =  " `{$name}` " . strtoupper($type) . " (" . implode(",", $values) . ")";

        if (isset($info['mod'])) {
            $this->modifiers($s, $info['mod']);
        }
        
        return $s;
    }


    // SET
    public function enum(string $name, array $values)
    {
        $this->dataTypes[]["enum"] = [$name, $values];
        return $this;
    }

    public function set(string $name, array $values)
    {
        $this->dataTypes[]["set"] = [$name, $values];
        return $this;
    }
}
