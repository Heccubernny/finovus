<?php
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class StatusCast implements CastsAttributes
{
    protected $statusMap = [
        'active' => 1,
        'inactive' => 0,
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        return array_search($value, $this->statusMap);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $this->statusMap[$value] ?? $value;
    }
}

class KycStatusCast implements CastsAttributes
{
    protected $kycStatusMap = [
        'initialize' => 0,
        'pending' => 1,
        'declined' => 2,
        'failed' => 3,
        'approved' => 4,
        'successful' => 5,

    ];

    public function get($model, string $key, $value, array $attributes)
    {
        return array_search($value, $this->kycStatusMap);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $this->kycStatusMap[$value] ?? $value;
    }
}