<?php namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class BonusDaily extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_bonus_daily';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getUserIdOptions() {
        $users = User::lists('username', 'id');
        return $users;
    }

}
