<?php
    class UtilityController extends CustomControllerAction
    {
        /** @noinspection PhpUndefinedConstantInspection */
        public function captchaAction()
        {
            $session = new Zend_Session_Namespace('captcha');

            // check for existing phrase in session
            $phrase = null;
            if (isset($session->phrase) && strlen($session->phrase) > 0)
                $phrase = $session->phrase;

//            $opts = array('font_size' => 20,
//                          'font_path' => Zend_Registry::get('config')->paths->data,
//                          'font_file' => 'VeraBd.ttf');
//            $captcha = Text_CAPTCHA::factory('Image');
//            $captcha->init(120, 60, $phrase, $opts);

            // write the phrase to session
            $phrase = generate_code();
            $session->phrase = $phrase;//$captcha->getPhrase();

            // disable auto-rendering since we're outputting an image
            $this->_helper->viewRenderer->setNoRender();

            header('Content-type: image/png');
            echo img_code($phrase);//$captcha->getCAPTCHAAsPng();
            //Zend_Registry::get('logger')->debug('ch4-captcha1:'.$tmp);

        }

    }
define ( 'DOCUMENT_ROOT', dirname ( __FILE__ ) );
define("img_dir", DOCUMENT_ROOT."/captcha/img/");
function img_code($code) // $code - код нашей капчи, который мы укажем при вызове функции
{
    // Отправляем браузеру Header'ы
//    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//    header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");
//    header("Cache-Control: no-store, no-cache, must-revalidate");
//    header("Cache-Control: post-check=0, pre-check=0", false);
//    header("Pragma: no-cache");
//    header("Content-Type:image/png");
    // Количество линий. Обратите внимание, что они накладываться будут дважды (за текстом и на текст).
    //Поставим рандомное значение, от 3 до 7.
    $linenum = rand(3, 7);
    // Задаем фоны для капчи. Можете нарисовать свой и загрузить его в папку /img. Рекомендуемый размер - 150х70.
    //Фонов может быть сколько угодно
    $img_arr = array(
        "1.png"
    );
    // Шрифты для капчи. Задавать можно сколько угодно, они будут выбираться случайно
    $font_arr = array();
    $font_arr[0]["fname"] = "DroidSans.ttf";	// Имя шрифта. Я выбрал Droid Sans, он тонкий, плохо выделяется среди линий.
    $font_arr[0]["size"] = rand(20, 30);				// Размер в pt
    // Генерируем "подстилку" для капчи со случайным фоном
    $n = rand(0,sizeof($font_arr)-1);
    $img_fn = $img_arr[rand(0, sizeof($img_arr)-1)]; //echo 'img_fn:'.img_dir . $img_fn.'<br>';
    $im = imagecreatefrompng (img_dir . $img_fn);
    // Рисуем линии на подстилке
    for ($i=0; $i<$linenum; $i++)
    {
        $color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150)); // Случайный цвет c изображения
        imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
    }
    $color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // Опять случайный цвет. Уже для текста.

    // Накладываем текст капчи
    $x = rand(0, 35);
    for($i = 0; $i < strlen($code); $i++) {
        $x+=15;
        $letter=substr($code, $i, 1);
        imagettftext ($im, $font_arr[$n]["size"], rand(2, 4), $x, rand(50, 55), $color, img_dir.$font_arr[$n]["fname"], $letter);
    }

    // Опять линии, уже сверху текста
    for ($i=0; $i<$linenum; $i++)
    {
        $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
        imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
    }
    // Возвращаем получившееся изображение
    ImagePNG ($im);
    ImageDestroy ($im);
}

function generate_code()
{
    $chars = 'abdefhknrstyz23456789'; // Задаем символы, используемые в капче. Разделитель использовать не надо.
    $length = rand(4, 7); // Задаем длину капчи, в нашем случае - от 4 до 7
    $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, rand(1, $numChars) - 1, 1);
    } // Генерируем код

    // Перемешиваем, на всякий случай
    $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
    srand ((float)microtime()*1000000);
    shuffle ($array_mix);
    // Возвращаем полученный код
    return implode("", $array_mix);
}
?>