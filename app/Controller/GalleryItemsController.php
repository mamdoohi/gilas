<?php

App::uses('AppController', 'Controller');

/**
 * GalleryItems Controller
 *
 * @property GalleryItem $GalleryItem
 */
class GalleryItemsController extends AppController {

    public $helpers = array('UploadPack.Upload');

    public function admin_index() {
        $this->set('title_for_layout', 'لیست تصاویر گالری');
        $this->paginate = array('limit' => 20);
        $galleryItems = $this->paginate('GalleryItem');
        $this->set(compact('galleryItems'));
    }

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن تصویر به گالری');
        $this->set('galleryCategories', $this->GalleryItem->GalleryCategory->find('list'));
        if ($this->request->is('post')) {
            //$uploded_file = $this->request->data['GalleryItem']['name']['tmp_name'];
            //$this->request->data['GalleryItem']['name'] = $this->request->data['GalleryItem']['name']['name'];
            $this->request->data['GalleryItem']['user_id'] = $this->Auth->user('id');
            //$folder_path = $this->GalleryItem->GalleryCategory->findById($this->request->data['GalleryItem']['gallery_category_id'], array('folder_name'));
            // $this->request->data['GalleryItem']['folder_name'] = $folder_path['GalleryCategory']['folder_name'];

            if ($this->GalleryItem->save($this->request->data)) {
                //$this->_imageUpload($uploded_file, $folder_path['GalleryCategory']['folder_name'], $this->request->data['GalleryItem']['name']);
                $this->Session->setFlash('تصویر با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        }
    }

    private function _deleteImage($galleryName = NULL, $imageName = NULL) {
        if (!empty($imageName) && !empty($galleryName)) {
            if (unlink(WWW_ROOT . 'gallery' . DS . $galleryName . DS . $imageName)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _imageUpload($imgTmpName = NULL, $galleryName = NULL, $imageName = NULL) {
        if (!empty($imgTmpName) && !empty($imageName) && !empty($galleryName)) {
            if (move_uploaded_file($imgTmpName, WWW_ROOT . 'gallery' . DS . $galleryName . DS . $imageName)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش اطلاعات تصویر');
        $this->GalleryItem->id = $id;
        $this->set('galleryCategories', $this->GalleryItem->GalleryCategory->find('list'));
        $requestData = $this->GalleryItem->read();
        if (!$this->GalleryItem->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (empty($this->request->data['GalleryItem']['name']['name'])) {
                $this->request->data['GalleryItem']['name'] = $requestData['GalleryItem']['name'];
                $mustUpload = FALSE;
            } else {
                $uploded_file = $this->request->data['GalleryItem']['name']['tmp_name'];
                $this->request->data['GalleryItem']['name'] = $this->request->data['GalleryItem']['name']['name'];
                $folder_path = $this->GalleryItem->GalleryCategory->findById($this->request->data['GalleryItem']['gallery_category_id'], array('folder_name'));
                $mustUpload = TRUE;
            }
            if ($this->GalleryItem->save($this->request->data)) {
                if ($mustUpload) {
                    $this->_deleteImage($folder_path['GalleryCategory']['folder_name'], $requestData['GalleryItem']['name']);
                    $this->_imageUpload($uploded_file, $folder_path['GalleryCategory']['folder_name'], $this->request->data['GalleryItem']['name']);
                }
                $this->Session->setFlash('تصویر با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $requestData;
        }
    }

    public function admin_delete($id = NULL) {
        $this->GalleryItem->id = $id;
        //$file_name = $this->GalleryItem->findById($id, array('name', 'gallery_category_id'));
        //$folder_name = $this->GalleryItem->GalleryCategory->findById($file_name['GalleryItem']['gallery_category_id'], array('folder_name'));
        if (!$this->GalleryItem->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->request->is('post')) {
            if ($this->GalleryItem->delete()) {
                //$file = new File(WWW_ROOT . 'gallery' . DS . $folder_name['GalleryCategory']['folder_name'] . DS . $file_name['GalleryItem']['name']);
                //$file->delete();
                $this->Session->setFlash('تصویر با موفقیت حذف شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_unPublishGalleryItem($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!');
        }
        $this->GalleryItem->id = $id;
        if (!$this->GalleryItem->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->GalleryItem->saveField('published', 0)) {
            $this->Session->setFlash('تصویر با موفقیت از حالت انتشار خارج شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_publishGalleryItem($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!');
        }
        $this->GalleryItem->id = $id;
        if (!$this->GalleryItem->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->GalleryItem->saveField('published', 1)) {
            $this->Session->setFlash('تصویر با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

}
