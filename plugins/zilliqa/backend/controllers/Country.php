<?php namespace Zilliqa\Backend\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Country Back-end Controller
 */
class Country extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Zilliqa.Backend', 'backend', 'country');
    }
}
