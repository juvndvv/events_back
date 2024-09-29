<?php

namespace App\Admin\User\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentUserModel extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'password',
        'active',
    ];
}
