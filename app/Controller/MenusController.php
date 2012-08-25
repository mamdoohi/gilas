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
    
    public $helpers = array('AdminForm');
    
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
                 // Update level of childrens
                 $this->Menu->updateChildrenLevel();
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
	public function admin_delete() {
	   
	    $id = $this->request->data['id'];// we recieve id via posted data
        
		if ($this->request->is('post')) {
		    $count = count($id);
            if($count == 1){
                $id = current($id);
                $this->Menu->id = $id;
                
                if ($this->Menu->childCount($id)) {
                    $this->Session->setFlash(SettingsController::read('Error.Code-12'), 'message', array('type' => 'error'));
                }elseif ($this->Menu->delete()) {
        			$this->Session->setFlash('گزینه منو با موفقیت حذف شد', 'message', array('type' => 'success'));
        		}else{
                    $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
                }
            }elseif($count > 1){
                $countAffected = 0;
                foreach($id as $i){
                    $this->Menu->id = $i;
                    if ($this->Menu->childCount($i)) {
                        continue;
                    }
            		if ($this->Menu->delete()) {
            			$countAffected ++ ;
            		}
                }
                $this->Session->setFlash($countAffected .' مورد حذف گردید', 'message', array('type' => 'success'));
            }
		}
		$this->redirect($this->referer());
	}
    
/**
 * Move item to up or down
 * 
 * @param mixed $id : item id
 * @param string $type : up or down 
 * @return void
 */
    public function admin_move(){
        $id = $this->request->data['id'];
        
        $type = $this->request->data['type'];
        $type = ($type == 'Up')?'Up':'Down';
        // moveUp or moveDown
        $type  = 'move'.$type;
        if($this->request->is('post')){
            $count = count($id);
            if($count == 1){
                $id = current($id);
                // moveUp or moveDown
                if($this->Menu->{$type}($id)){
                    $this->Session->setFlash('گزینه منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                }else{
                    $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
                }
            }elseif($count > 1){
                $countAffected = 0;
                foreach($id as $i){
                    if($this->Menu->{$type}($i)){
                        $countAffected ++;
                    }
                }
                $this->Session->setFlash($countAffected .' گزینه منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
            }
            
        }
        $this->redirect($this->referer());
    }
    
    public function admin_publishMenu() {
        $id = $this->request->data['id'];
        if ($this->request->is('post')) {
             $count = count($id);
            if($count == 1){
                $id = current($id);
                $this->Menu->id = $id;
                
                if($this->Menu->saveField('published', 1)){
                    $this->Session->setFlash('منو با موفقیت منتشر شد', 'message', array('type' => 'success'));
                }else{
                    $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
                }
            }elseif($count > 1){
                $countAffected = 0;
                foreach($id as $i){
                    $this->Menu->id = $i;
                    if($this->Menu->saveField('published', 1)){
                        $countAffected ++;
                    }
                }
                $this->Session->setFlash($countAffected .' منو با موفقیت منتشر شد', 'message', array('type' => 'success'));
            }
        }
        $this->redirect($this->referer());
    }
    
    public function admin_unPublishMenu(){
        $id = $this->request->data['id'];
        if ($this->request->is('post')) {
             $count = count($id);
            if($count == 1){
                $id = current($id);
                $this->Menu->id = $id;
                
                if($this->Menu->saveField('published', 0)){
                    $this->Session->setFlash('منو با موفقیت از حالت انتشار خارج شد', 'message', array('type' => 'success'));
                }else{
                    $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
                }
            }elseif($count > 1){
                $countAffected = 0;
                foreach($id as $i){
                    $this->Menu->id = $i;
                    if($this->Menu->saveField('published', 0)){
                        $countAffected ++;
                    }
                }
                $this->Session->setFlash($countAffected .' منو با موفقیت از حالت انتشار خارج شد', 'message', array('type' => 'success'));
            }
        }
        $this->redirect($this->referer());
    }
    
/**
 * Return item array for current $menuTypeID
 * 
 * @param int $menuTypeID : ID in MenuType Model
 * @return array
 */
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
    
/**
 * choose action for given action via adminForm
 * all sent data for admin form will be recieve by this action and this action choose requested action
 * @return void
 */
    public function admin_dispatch(){
        if(empty($this->request->data['action'])){
            $this->Session->setFlash('اشکال در پردازش اطلاعات','alert',array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $action = $this->request->data['action'];
        unset($this->request->data['action']);
        //with prefix
        $this->setAction('admin_'.$action);
    }
}
