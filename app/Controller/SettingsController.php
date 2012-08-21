<?php

/*
 * Created By : Mohammad Razzaghi
 * Email : 1razzaghi@gmail.com
 * Blog : http://bigitblog.ir
 * Social Networks : 
 *          http://facebook.com/1razzaghi
 *          http://twitter.com/1razzaghi
 */

/**
 * Settings Controller
 *
 * @property Setting $Setting
 */
class SettingsController extends AppController {

    public function admin_index() {
        $this->set('title_for_layout', 'ویرایش تنظیمات سیستم');
        $this->Setting->id = 1;
        if (!$this->Setting->exists()) {
            throw new NotFoundException('خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Setting']['modified'] = Jalali::dateTime();
            if ($this->Setting->save($this->request->data)) {
                $this->Session->setFlash('تنظیمات با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash('خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید.', 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Setting->read();
        }
    }

    public static function getSettings($name) {
        $_this = new SettingsController();
        $_this->constructClasses();
        $option = $_this->Setting->find('first', array('fields' => $name));
        return $option['Setting'][$name];
    }

}

?>
