<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $salt 盐值
 * @property string $name 昵称
 * @property string $avatar 头像
 * @property int $state 状态
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Hyperf\Database\Model\Collection|AdminRole[] $roles 
 */
class AdminUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'salt', 'name', 'avatar', 'state'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'state' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public function roles()
    {
        // 超级管理员不可设置角色
        if ($this->id == 1) {
            return null;
        }
        return $this->belongsToMany(AdminRole::class, 'admin_user_role', 'user_id', 'role_id');
    }
}