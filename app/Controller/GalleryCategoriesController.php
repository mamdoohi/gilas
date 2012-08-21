<?php

App::uses('AppController', 'Controller');

/**
 * GalleryCategories Controller
 *
 * @property GalleryCategory $GalleryCategory
 */
class GalleryCategoriesController extends AppController {

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت مجموعه گالری');
        $galleryCategories = $this->paginate('GalleryCategory');
        for ($i = 0; $i < count($galleryCategories); $i++) {
            $galleryCategories[$i]['GalleryCategory']['imageCount'] = $this->_haveImage($galleryCategories[$i]['GalleryCategory']['id']);
        }
        if (empty($galleryCategories)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
        $this->set(compact('galleryCategories'));
    }

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن مجموعه گالری');
        $this->set('parents', $this->GalleryCategory->generateTreeList());
        if ($this->request->is('post')) {
            if ($this->GalleryCategory->save($this->request->data)) {
                mkdir(WWW_ROOT . 'gallery' . DS . $this->request->data['GalleryCategory']['folder_name'], 0777);
                $this->Session->setFlash('مجموعه با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->Session->setFlash('پوشه تصاویر مجموعه با موفقیت ساخته شد.', 'message_1', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش مجموعه گالری');
        $this->GalleryCategory->id = $id;

        if (!$this->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }

        $requestData = $this->GalleryCategory->read();

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->GalleryCategory->save($this->request->data)) {
                if (!is_dir(WWW_ROOT . 'gallery' . DS . $this->request->data['GalleryCategory']['folder_name'])) {
                    rename(WWW_ROOT . 'gallery' . DS . $requestData['GalleryCategory']['folder_name'], WWW_ROOT . 'gallery' . DS . $this->request->data['GalleryCategory']['folder_name']);
                }
                $this->Session->setFlash('مجموعه با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->set('parents', $this->GalleryCategory->generateTreeList());
            $this->request->data = $requestData;
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->GalleryCategory->id = $id;
        if (!$this->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->_haveImage($id)) {
            $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
        //$galleryCategory = $this->GalleryCategory->read();
        if ($this->GalleryCategory->delete()) {
            //rmdir(WWW_ROOT . 'gallery' . DS . $galleryCategory['GalleryCategory']['folder_name']);
            $this->Session->setFlash('مجموعه با موفقیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'index', 'admin' => TRUE));
        }
    }

    public function admin_publishGalleryCategory($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->GalleryCategory->id = $id;
        if (!$this->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->GalleryCategory->saveField('published', 1)) {
            $this->Session->setFlash('مجموعه گالری با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_unPublishGalleryCategory($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->GalleryCategory->id = $id;
        if (!$this->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->GalleryCategory->saveField('published', 0)) {
            $this->Session->setFlash('مجموعه گالری با موفقیت از حالت انتشار خارج شد', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    private function _haveImage($id) {
        return $this->GalleryCategory->GalleryItem->find('count', array('conditions' => array('gallery_category_id' => $id)));
    }

}
