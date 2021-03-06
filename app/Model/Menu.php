<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Menu $ParentMenu
 * @property Menu $ChildMenu
 */
class Menu extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
    
    public $actsAs = array('Tree');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alias' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'MenuType' => array(
			'className' => 'MenuType',
			'foreignKey' => 'menu_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    
/**
 * Update children level for current row 
 * 
 * @return void
 */
    public function updateChildrenLevel(){
        $this->recursive = -1;
        $row = $this->read();
        $children = $this->children(null,true);
        if($children){
            foreach($children as $child){
                $this->id = $child['Menu']['id'];
                $this->saveField('level',$row['Menu']['level'] + 1);
                $this->updateChildrenLevel();
            }
        }
    }

}
