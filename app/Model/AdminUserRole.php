<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $user_id 用户ID
 * @property int $role_id 角色ID
 */
class AdminUserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['user_id' => 'integer', 'role_id' => 'integer'];
}