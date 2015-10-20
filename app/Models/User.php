<?php namespace App\Models;

use  Illuminate\Database\Eloquent\Model  as Eloquent; 
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use EntrustUserTrait; // add this trait to your user model
    use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    protected $fillable = ['nickname', 'group_id', 'email', 'realname',  'pid', 'pid_card_thumb1', 'pid_card_thumb2', 'avatar', 'phone', 'address', 'amount', 'point'];

    protected $hidden = ['password', 'confirmation_code', 'remember_token'];

    #********
    #* 此表为复合型的用户数据表，根据type不同确定不同用户
    #* type : Manager 管理型用户
    #* type : Customer 投资型客户
    #********
    //限定管理型用户
    public function scopeManager($query)
    {
        return $query->where('user_type', '=', 'Manager');
    }

    //限定投资型客户
    public function scopeCustomer($query)
    {
        return $query->where('user_type', '=', 'Customer');
    }

    public function userGroup()
    {
        return $this->belongsTo('App\Models\UserGroup', 'group_id');
    }
}
