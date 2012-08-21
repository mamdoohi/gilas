<?php
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {

    public $paginateConditions = array(
        'title' => array(
            'type' => 'LIKE',
            'field' => 'Menu.title',
        ),
        'published' => array('field' => 'Menu.published'),
        'menu_type_id' => array('field' => 'Menu.menu_type_id'),
    );

    public $linkTypes = array(
            'Contents' => 'مطلب',
            'ContentCategories' => 'مجموعه مطالب',
            'ContactDetails' => 'تماس',
            'GalleryItems' => 'گالری',
            'GalleryCategories' => 'مجموعه گالری',
            'WeblinkCategories' => 'مجموعه لینک',
            'Weblinks' => 'لینک',
            'SliderItems' => 'اسلایدر',
            'External' => 'لینک خارجی',
            
        );
    
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Menu->recursive = -1;
        $this->paginate['order'] = 'Menu.lft ASC';
        $this->paginate['contain'] = 'MenuType';
        $menus = $this->paginate();
        if($menus){
            // Check the item can move to up or down
            //      rght = lft - 1    lft  rght     lft = rght + 1
            //     ----------        ----------      -----------
            //     left child         current        right child   
            //
            foreach($menus as &$menu){
                $left = $menu['Menu']['lft']; 
                $right = $menu['Menu']['rght'];  
                foreach($menus as $m){
                    // escape own
                    if($m['Menu']['id'] == $menu['Menu']['id']){
                        continue;
                    }
                    // right item so item can move to down 
                    if($m['Menu']['lft'] == ($right + 1)){
                        $menu['Menu']['hasRight'] = true;
                    }
                    
                    // left item so item can move to up
                    if($m['Menu']['rght'] == ($left - 1)){
                        $menu['Menu']['hasLeft'] = true;
                    }
                }
                $menu['Menu']['namedLinkType'] = $this->linkTypes[$menu['Menu']['link_type']];
            }
        }
		// use this for filter form 
        $menuTypes = $this->Menu->MenuType->find('list');
        $this->set(compact('menus','menuTypes'));
        
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
              if(strpos($this->request->data['Menu']['link'],'http://') === false){
                $this->request->data['Menu']['link'] = 'http://'.$this->request->data['Menu']['link'];
              }
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {
			     // Save Level for this item
			     $path = $this->Menu->getPath();
                 // levels starts with 0
                 $this->Menu->saveField('level',count($path) - 1 );
                 
				$this->Session->setFlash('گزینه منو با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
			} else {
			 $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
			}
		}
        
        $this->set('linkTypes',$this->linkTypes);
		$parents = $this->Menu->find('all',array('order' => 'lft ASC','contain' => false));
        $menuTypes = $this->Menu->MenuType->find('list');
		$this->set(compact('parents','controller','menuTypes'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(SettingsController::read('Error.Code-14'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
              if(strpos($this->request->data['Menu']['link'],'http://') === false){
                $this->request->data['Menu']['link'] = 'http://'.$this->request->data['Menu']['link'];
              }
			if ($this->Menu->save($this->request->data)) {
			     // Save Level for this item
			     $path = $this->Menu->getPath();
                 // levels starts with 0
                 $this->Menu->saveField('level',count($path) - 1 );
                 
				$this->Session->setFlash('گزینه منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
			} else {
			 $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
			}
		}else{
		  $this->request->data = $this->Menu->read(null, $id);
		}
        
        $this->set('linkTypes',$this->linkTypes);
		$parents = $this->Menu->find('all',array('order' => 'lft ASC','contain' => false));
        $menuTypes = $this->Menu->MenuType->find('list');
		$this->set(compact('parents','controller','menuTypes'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
		}
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(SettingsController::read('Error.Code-14'));
		}
        if ($this->Menu->childCount($id)) {
            $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
		if ($this->Menu->delete()) {
			$this->flash('منو با موفقیت حذف شد.', array('action' => 'index'));
		}
		$this->flash(SettingsController::read('Error.Code-16'), array('action' => 'index'));
		$this->redirect($this->referer());
	}
    
    /**
     * Move item to up or down
     * 
     * @param mixed $id : item id
     * @param string $type : up or down 
     * @return void
     */
    public function admin_move($id, $type = 'Up'){
        $type = ($type == 'Up')?'Up':'Down';
        // moveUp or moveDown
        $type  = 'move'.$type;
        
        if($this->request->is('post')){
            // moveUp or moveDown
            if($this->Menu->{$type}($id)){
                $this->Session->setFlash('گزینه منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        }
        $this->redirect($this->referer());
    }
    
    public function admin_publishMenu($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->Menu->saveField('published', 1)) {
            $this->Session->setFlash('منو با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }
    
    public function admin_unPublishMenu($id=NULL){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->Menu->saveField('published', 0)) {
            $this->Session->setFlash('منو با موفقیت از حالت انتشار خارج شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }
    public function getMenu($menuTypeID){
        return $this->Menu->find('threaded',array(
            'conditions' => array(
                'menu_type_id' => $menuTypeID,
                'published' => true,
            ),
            'order' => 'lft ASC',
            'contain' => false,
        ));
    }
}
