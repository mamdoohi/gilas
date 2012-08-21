<?php

App::uses('AppController', 'Controller');

/**
 * SliderItems Controller
 *
 * @property SliderItem $SliderItem
 */
class SliderItemsController extends AppController {

    public function admin_index() {
        $this->set('title_for_layout', 'مدیریت اسلایدر صفحه نخست');
        $this->paginate = array('limit' => 20);
        $sliderItems = $this->paginate('SliderItem');
        $this->set(compact('sliderItems'));
    }

    public function admin_add() {
        $this->set('title_for_layout', 'افزودن تصویر به اسلایدر');
    }

    public function admin_edit($id = NULL) {
        $this->set('title_for_layout', 'ویرایش تصویر اسلایدر');
    }

    public function admin_delete($id = NULL) {
        
    }

}
