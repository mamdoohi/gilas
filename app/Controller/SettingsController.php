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
    
    // use for caching fetched settings
    private static $__cachedSetting = array();
    
    public function admin_index() {
        $this->set('title_for_layout', 'ویرایش تنظیمات سیستم');
        $this->Setting->id = 1;
        if (!$this->Setting->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Setting']['modified'] = Jalali::dateTime();
            if ($this->Setting->save($this->request->data)) {
                $this->Session->setFlash('تنظیمات با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Setting->read();
        }
    }
    
    public static function read($name) {
        // process parameter
        $sectionWithKey = String::tokenize($name,'.');
        $section = array_shift($sectionWithKey);
        $key = implode('.',$sectionWithKey);
        
        if(!empty(self::$__cachedSetting[$section])){
            return self::$__cachedSetting[$section][$key];
        }
        
        $_this = new SettingsController();
        $_this->constructClasses();
        
        $settings = $_this->Setting->find('all', array(
            'conditions' => array(
                'section' => $section,
            ),
        ));
        if($settings){
            foreach($settings as $setting){
                self::$__cachedSetting[$section][$setting['Setting']['key']] = $setting['Setting']['value'];
            }
        }
        return self::$__cachedSetting[$section][$key];
    }

}

?>
