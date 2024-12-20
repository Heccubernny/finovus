<?php
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class BusinessLevelCast implements CastsAttributes
{
    protected $businessLevelMap = [
        'startup' => 1,
        'small' => 2,
        'medium' => 3,
        'large' => 4,
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        return array_search($value, $this->businessLevelMap);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $this->businessLevelMap[$value] ?? $value;
    }
}