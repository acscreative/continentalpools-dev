<?php
if(class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_VC_Table extends WPBakeryShortCode {
        /**
         * Find html template for shortcode output.
         */
        protected function findShortcodeTemplate() {
            // Check template path in shortcode's mapping settings
            if(!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
                return $this->setTemplate($this->settings['html_template']);
            }
            // Check template in theme directory
            $user_template = vc_manager()->getShortcodesTemplateDir($this->getFilename().'.php');
            if(is_file($user_template)) {
                return $this->setTemplate($user_template);
            }
            // Check default place
            $default_dir = $this->getVcTableDefaultDir();
            if(is_file($default_dir.$this->getFilename().'.php')) {
                return $this->setTemplate($default_dir.$this->getFilename().'.php');
            }
        }
        protected function getVcTableDefaultDir() {
            return dirname(__FILE__).'/templates/';
        }
        protected function getFileName() {
            return $this->shortcode.'.html';
        }
    }
}
