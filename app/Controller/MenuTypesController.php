<?php
class MenuTypesController extends AppController{
    public function admin_index() {
		$this->MenuType->recursive = -1;
        $menuTypes = $this->paginate();
        if($menuTypes){
            foreach($menuTypes as &$menuType){
                $menuType['MenuType']['childCount'] = $this->_childCount($menuType['MenuType']['id']);
            }
        }
        $this->set('menuTypes',$menuTypes);
    }
    public function admin_add(){
        if ($this->request->is('post')) {
			$this->MenuType->create();
			if ($this->MenuType->save($this->request->data)) {
				$this->Session->setFlash('نوع منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
			} else {
			 $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
			}
		}
    }
    
    public function admin_getTypes(){
        return $this->MenuType->find('list');
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
		$this->MenuType->id = $id;
		if (!$this->MenuType->exists()) {
			throw new NotFoundException(SettingsController::read('Error.Code-14'));
		}
        if ($this->_childCount($id)) {
            $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
		if ($this->MenuType->delete()) {
			$this->flash('نوع مورد نظر حذف گردید.', array('action' => 'index'));
		}
		$this->flash(SettingsController::read('Error.Code-16'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
    
    public function _childCount($id){
        return $this->MenuType->Menu->find('count',array(
                    'conditions' => array('menu_type_id' => $id),
                    'contain' => false,
                ));
    }
}