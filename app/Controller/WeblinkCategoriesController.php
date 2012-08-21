<?php

App::uses('AppController', 'Controller');

/**
 * WeblinkCategories Controller
 *
 * @property WeblinkCategory $WeblinkCategory
 */
class WeblinkCategoriesController extends AppController {

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت مجموعه های وب لینک');
        $weblinkCategories = $this->paginate('WeblinkCategory');
        for ($i = 0; $i < count($weblinkCategories); $i++) {
            $weblinkCategories[$i]['WeblinkCategory']['linkCount'] = $this->_haveLink($weblinkCategories[$i]['WeblinkCategory']['id']);
        }
        if (empty($weblinkCategories)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
        $this->set(compact('weblinkCategories'));
    }

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن مجموعه وب لینک');
        if ($this->request->is('post')) {
            if ($this->WeblinkCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش مجموعه وب لینک');
        $this->WeblinkCategory->id = $id;
        if (!$this->WeblinkCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->WeblinkCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه وب لینک با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->WeblinkCategory->read();
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->WeblinkCategory->id = $id;
        if (!$this->WeblinkCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->_haveLink($id)) {
            $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
        if ($this->WeblinkCategory->delete()) {
            $this->Session->setFlash('مجموعه وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
    }

    private function _haveLink($id) {
        return $this->WeblinkCategory->Weblink->find('count', array(
                    'conditions' => array(
                        'weblink_category_id' => $id
                    )
                ));
    }

}
