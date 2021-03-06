<?php namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use JWTAuth;

/**
 * Model
 */
class HistoryCommission extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_commission';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'commission'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

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

    public function afterSave(){
        $user = User::find($this->user_id);
        $user->commission = $user->commission + $this->commission;
        $user->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter($request) {
        $perPage = $request->get('limit', 1000);

        $user = JWTAuth::parseToken()->authenticate();
        $userID = $user->id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $commissionModel = $this->where('id', '>', 0);
        $commissionModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });

        $commissionModel->when($fromDate, function($query, $fromDate) {
            return $query->whereDate('created_at', '>=', $fromDate);
        });

        $commissionModel->when($toDate, function($query, $toDate) {
            return $query->whereDate('created_at', '<=', $toDate);
        });

        $commissionModel->orderBy('created_at', 'desc');

        $result = $commissionModel->paginate($perPage)->toArray();

        return $result;
    }
}
