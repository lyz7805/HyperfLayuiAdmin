<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $role_id 角色ID
 * @property int $menu_id 菜单ID
 */
class AdminRoleMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_role_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'menu_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['role_id' => 'integer', 'menu_id' => 'integer'];
}