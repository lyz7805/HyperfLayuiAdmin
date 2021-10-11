<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $name 角色名称
 * @property int $state 状态
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Hyperf\Database\Model\Collection|AdminMenu[] $menus 
 * @property-read \Hyperf\Database\Model\Collection|AdminUser[] $users 
 */
class AdminRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'state', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'state' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public function menus()
    {
        return $this->belongsToMany(AdminMenu::class, 'admin_role_menu', 'role_id', 'menu_id');
    }
    public function users()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_user_role', 'role_id', 'user_id');
    }
}