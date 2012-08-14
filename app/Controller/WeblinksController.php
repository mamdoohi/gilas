<?php

App::uses('AppController', 'Controller');

/**
 * Weblinks Controller
 *
 * @property Weblink $Weblink
 */
class WeblinksController extends AppController {

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت وب لینک ها');
        $this->paginate = array('limit' => '20');
        $weblinks = $this->paginate('Weblink');
        if (empty($weblinks)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
        $this->set('weblinks', $weblinks);
    }

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن وب لینک');
        $this->set('weblinkCategories', $this->Weblink->WeblinkCategory->find('list'));
        if ($this->request->is('post')) {
            $this->request->data['Weblink']['created'] = Jalali::dateTime();
            $this->request->data['Weblink']['address'] = $this->_haveHttpPrefix($this->request->data['Weblink']['address']);
            if ($this->Weblink->save($this->request->data)) {
                $this->Session->setFlash('وب لینک با موفقیت اضافه شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش وب لینک');
        $this->Weblink->id = $id;
        if (!$this->Weblink->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Weblink->save($this->request->data)) {
                $this->Session->setFlash('وب لینک با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        } else {
            $this->set('weblinkCategories', $this->Weblink->WeblinkCategory->find('list'));
            $this->request->data = $this->Weblink->read();
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!');
        }
        $this->Weblink->id = $id;
        if (!$this->Weblink->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->Weblink->delete()) {
            $this->Session->setFlash('وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
    }

    private function _haveHttpPrefix($url = Null) {
        if (substr($url, 0, 7) != 'http://')
            $url = 'http://' . $url;
        return $url;
    }

    public function admin_publishWebLink($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!');
        }
        $this->Weblink->id = $id;
        if (!$this->Weblink->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->Weblink->saveField('published', 1)) {
            $this->Session->setFlash('وب لینک با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }
    
    public function admin_unPublishWebLink($id=NULL){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!');
        }
        $this->Weblink->id = $id;
        if (!$this->Weblink->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->Weblink->saveField('published', 0)) {
            $this->Session->setFlash('وب لینک با موفقیت از حالت انتشار خارج شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

}
