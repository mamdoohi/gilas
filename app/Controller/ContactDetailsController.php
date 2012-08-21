<?php

App::uses('AppController', 'Controller');

/**
 * ContactDetails Controller
 *
 * @property ContactDetail $ContactDetail
 */
class ContactDetailsController extends AppController {

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن اطلاعات تماس');
        if ($this->request->is('post')) {
            if ($this->ContactDetail->save($this->request->data)) {
                $this->Session->setFlash('اطلاعات تماس با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش اطلاعات تماس');
        $this->ContactDetail->id = $id;
        if (!$this->ContactDetail->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContactDetail->save($this->request->data)) {
                $this->Session->setFlash('اطلاعات تماس با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->ContactDetail->read();
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->ContactDetail->id = $id;
        if (!$this->ContactDetail->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->ContactDetail->delete()) {
            $this->Session->setFlash('اطلاعات تماس با موفیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
    }

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت اطلاعات تماس');
        $contactDetails = $this->ContactDetail->find('all');
        $this->set('contactDetails', $contactDetails);
        if (empty($contactDetails)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
    }
    
    public function admin_getLinkItem(){
        $conditions = array();
        if(!empty($this->request->query['q'])){
            $conditions['ContactDetail.title LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['recursive'] = -1;
        $this->set('contactDetails',$this->paginate());
    }
}
