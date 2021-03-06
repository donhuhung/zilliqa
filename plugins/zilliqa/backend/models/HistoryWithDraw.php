<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use JWTAuth;

/**
 * Model
 */
class HistoryWithDraw extends Model {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_with_draw';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'coint', 'amount', 'status', 'type', 'eth_convert', 'wallet_address'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = ['user' => ['RainLab\User\Models\User', 'key' => 'user_id']];
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

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter() {

        //$perPage = $request->get('limit', 100);
        $perPage = 100;

        $user = JWTAuth::parseToken()->authenticate();
        $userID = $user->id;

        $withdrawModel = $this->where('id', '>', 0);
        $withdrawModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });

        $withdrawModel->orderBy('id', 'desc');

        $result = $withdrawModel->paginate($perPage)->toArray();

        return $result;
    }

}
