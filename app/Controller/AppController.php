<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('Session', 'Auth');
    
    public $helpers = array(
        'Form',
        'Html',
        'Session',
    );
    
/**
 * default paginate options
 */
    public $paginate = array('limit' => 20,'paramType' => 'named');
    
/**
 * this variable used for filtering in admin List
 * all fields that used in filter form must be come here
 * use 'type' index if you want use LIKE method
 */
    public $paginateConditions = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->authError = 'برای مشاهده این صفحه باید ابتدا وارد شوید';
        $this->Auth->loginRedirect = array('controller' => 'dashboards', 'action' => 'index', 'admin' => TRUE);
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => TRUE);
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => TRUE);
        $this->Auth->allow('register', 'login', 'index', 'view');

        $this->set('isLogedIn', $this->_isLogedIn());
    }

    function _isLogedIn() {
        $logedIn = FALSE;
        if ($this->Auth->user()) {
            $logedIn = TRUE;
        }
        return $logedIn;
    }

    public function beforeRender() {
        parent::beforeRender();
        if ($this->request['prefix']) {
            $this->layout = 'admin';
        }
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        }
    }
    

    /**
     * Override paginate method for adding conditions fields 
     * 
     * @param mixed $object
     * @param mixed $scope
     * @param mixed $whitelist
     * @return
     */
    public function paginate($object = null, $scope = array(), $whitelist = array()) {
        if(@$this->paginate['paramType'] == 'querystring'){
            $query = $this->request->query;
        }else{
            $query = $this->request->named;
        }
        // we won't use this fields
        unset($query['page'],$query['limit']);
        if($query){
      		$keys = array();
            // get paginateConditions and format it
    		foreach ($this->paginateConditions as $i => $keyName) {
    			$options = array();
    			if (!is_int($i)) {
    				$options = (array)$keyName;
    				$keyName = $i;
    			}
    			$keys[$keyName] = $options;
    		}
            
            foreach($query as $key => $value){
                $field = $key;
                if(!empty($keys[$key]['field'])){
                    $field = $keys[$key]['field'];
                }
                // used only query keys that becomes in paginateConditions
                if(! in_array($key,array_keys($keys))){ continue;}
                
                // we may have more than one named param with one key, so we recieve first param
                if(is_array($value)){
                    $value = array_shift($value);
                }
                
                // escape empty values
                if(strlen($value) == 0){continue;}

                // no option for this key
                if(empty($keys[$key]['type'])){
                    $this->paginate['conditions'][$field] = $value;
                    continue;
                }elseif(strtoupper(@$keys[$key]['type']) == 'LIKE' ){
                    $this->paginate['conditions'][$field.' LIKE'] = '%'.$value.'%';
                    continue;
                }
            }
        }

        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'Filter';
        // call parent method and return it
		return parent::paginate($object, $scope, $whitelist);
	}

}
