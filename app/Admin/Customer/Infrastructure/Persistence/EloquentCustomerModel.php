<?php

namespace App\Admin\Customer\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentCustomerModel extends Model
{
    use HasUuids;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'active'
    ];

    public function name(): string
    {
        return $this->name;
    }

    public function active(): bool
    {
        return (bool) $this->active;
    }
}
