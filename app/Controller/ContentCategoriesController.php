<?php

App::uses('AppController', 'Controller');

/**
 * ContentCategories Controller
 *
 * @property ContentCategory $ContentCategory
 */
class ContentCategoriesController extends AppController {

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن مجموعه مطالب');
        $this->set('parents', $this->ContentCategory->generateTreeList());
        if ($this->request->is('post')) {
            if ($this->ContentCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت مجموعه مطالب');
        $contentCategories = $this->paginate('ContentCategory');
        for ($i = 0; $i < count($contentCategories); $i++) {
            $contentCategories[$i]['ContentCategory']['contentCount'] = $this->_haveContent($contentCategories[$i]['ContentCategory']['id']);
        }
        if (empty($contentCategories)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
        $this->set(compact('contentCategories'));
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->ContentCategory->id = $id;
        if (!$this->ContentCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->_haveContent($id)) {
            $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
        if ($this->ContentCategory->delete()) {
            $this->Session->setFlash('مجموعه با موفقیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش مجموعه مطلب');
        $this->ContentCategory->id = $id;
        if (!$this->ContentCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContentCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->set('parents', $this->ContentCategory->generateTreeList());
            $this->request->data = $this->ContentCategory->read();
        }
    }

    private function _haveContent($id) {
        return $this->ContentCategory->Content->find('count', array('conditions' => array('content_category_id' => $id)));
    }

    public function admin_publishContentCategory($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->ContentCategory->id = $id;
        if (!$this->ContentCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->ContentCategory->saveField('published', 1)) {
            $this->Session->setFlash('مجموعه مطلب با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_unPublishContentCategory($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->ContentCategory->id = $id;
        if (!$this->ContentCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->ContentCategory->saveField('published', 0)) {
            $this->Session->setFlash('مجموعه مطلب با موفقیت از حالت انتشار خارج شد', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }
    public function admin_getLinkItem(){
        $conditions = array('ContentCategory.published' => true);
        if(!empty($this->request->query['q'])){
            $conditions['ContentCategory.name LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['recursive'] = -1;
        $this->set('categories',$this->paginate());
    }

}
