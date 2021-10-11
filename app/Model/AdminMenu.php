<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $parent_id 父ID
 * @property string $title 菜单标题
 * @property string $icon 菜单图标
 * @property string $href 菜单链接
 * @property string $target 打开方式
 * @property int $is_menu 是否菜单
 * @property int $sort 排序
 * @property string $permission 权限
 * @property int $state 状态
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Hyperf\Database\Model\Collection|AdminRole[] $roles 
 */
class AdminMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'title', 'icon', 'href', 'target', 'is_menu', 'sort', 'permission', 'state'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'parent_id' => 'integer', 'is_menu' => 'integer', 'sort' => 'integer', 'state' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_role_menu', 'menu_id', 'role_id');
    }
}