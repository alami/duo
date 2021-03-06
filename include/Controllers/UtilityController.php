<?php
    class UtilityController extends CustomControllerAction
    {
        public function captchaAction()
        {
            $session = new Zend_Session_Namespace('captcha');

            // check for existing phrase in session
            $phrase = null;
            if (isset($session->phrase) && strlen($session->phrase) > 0)
                $phrase = $session->phrase;

           //Zend_Registry::get('logger')->debug('ch4-captcha:'.$phrase);

            $opts = array('font_size' => 20,
                          'font_path' => Zend_Registry::get('config')->paths->data,
                          'font_file' => 'VeraBd.ttf');
            $captcha = Text_CAPTCHA::factory('Image');
Zend_Registry::get('logger')->debug('Err init CAPTCHA: ');
            $retval=$captcha->init(120, 60, $phrase, $opts);
            //if (PEAR::isError($retval)) {

                //exit;
            //}

            // write the phrase to session
            $session->phrase = $captcha->getPhrase();

            // disable auto-rendering since we're outputting an image
            $this->_helper->viewRenderer->setNoRender();

            header('Content-type: image/png');
            echo $captcha->getCAPTCHAAsPng();
        }
    }
?>