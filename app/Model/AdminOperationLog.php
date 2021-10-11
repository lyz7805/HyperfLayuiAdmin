<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property string $ip IP
 * @property string $path 路径
 * @property string $method 方法
 * @property string $params 参数
 * @property string $result 结果
 * @property string $runtime 执行时间（秒）
 * @property string $created_at 
 */
class AdminOperationLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_operation_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ip', 'path', 'method', 'params', 'result', 'runtime', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer'];
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;
}