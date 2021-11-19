<?php
session_start();
$getcharsofcapcha = filter_input(INPUT_POST, 'Letter') ?? '';
$checkResult = '';
if (!$getcharsofcapcha) {

    $im = imagecreatetruecolor(350, 100);

    $black = imagecolorallocate($im, 0, 0, 0); // color text
    $randcolor = imagecolorallocate($im, mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)); //backgroung color
    $randcolor1 = imagecolorallocate($im, mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)); //backgroung color
    $orange = imagecolorallocate($im, 255, 200, 0);
    imagefilledrectangle($im, 0, 0, 1920, 1080, $randcolor);
    imagesetthickness($im, mt_rand(0.5, 2));
    imageellipse($im, mt_rand(85, 348), mt_rand(80, 110), mt_rand(200, 320), mt_rand(50, 160), $randcolor1);
    imageellipse($im, mt_rand(85, 348), mt_rand(80, 110), mt_rand(200, 320), mt_rand(50, 160), $randcolor1);

    imageline($im, mt_rand(-20, 160), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), $black);
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), imagecolorallocate($im, mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)));
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), imagecolorallocate($im, mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)));
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), imagecolorallocate($im, mt_rand(1, 255), mt_rand(1, 255), mt_rand(1, 255)));
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), $black);
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), $black);
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), $black);
    imageline($im, mt_rand(-20, 340), mt_rand(-55, 270), mt_rand(-20, 340), mt_rand(-55, 270), $black);

    $font = 'C:\OpenServer\domains\captcha\fonts\BigShouldersStencilDisplay-Light.ttf';

    static $letters = array(
        '1',
        '2',
        '3',
        '6',
        '7',
        '8',
        '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n' , 'p', 'q', 'r', 's', 't', 'u', 'v',  'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z'
    );

    shuffle($letters);
    $arr_sl_rand_num_symbol = mt_rand(4, 4);
    $arr_slice = array_slice($letters, 0, $arr_sl_rand_num_symbol);
    $arr_implode = implode("", $arr_slice);
    ImageTTFtext($im, 44, mt_rand(-4, 35), mt_rand(35, 245), mt_rand(83, 95), $black, $font, $arr_implode);

    ob_start();
    imagepng($im);
    $ImageData = ob_get_clean();
    imagedestroy($im);
    $_SESSION['validCaptchaText'] = $arr_implode; // join element array in string;
} else {
    if ($getcharsofcapcha === $_SESSION['validCaptchaText']) {

        $checkResult = 'красава, можешь когда захочешь !';
    } else {

        $checkResult = 'попробуй еще раз ';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Captcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
    <style>
        .fig {

            text-align: center;
        }

        input {
            width: 400px;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            border: 0;
            border-bottom: 1px solid #000;
            background-color: rgba(0, 0, 0, 0);
            outline: 0;
        }

        a img {
            border: 3px solid #6B8E23;
        }

        form {
            margin: 0 auto;
            width: 280px;
        }

        p {
            text-align: center;
            font-size: 25pt;
        }

        mark {
            text-align: center;
            font-size: 14pt;
            margin: 10px 429px;
        }

        button {
            /*color: black;*/
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
            background-color: #4682B4;
            color: white;
            padding: 8px 10px;
            margin: 5px 85px;
            border: none;
            cursor: pointer;
            width: 100px;
            opacity: 0.9;
        }
    </style>
</head>
<body bgcolor="white">
<p>Captcha</p>
<figure class="fig">

    <?php if (!empty($ImageData)): ?>
        <img src="data:image/png;base64,<?= base64_encode($ImageData) ?>"/>
    <?php endif; ?>
</figure>
<form method='post' action="#">
    <input type="text" name="Letter" id="Letter" class="form-control" aria-describedby="emailHelp">
    <button type="submit" class="signupbtn">Проверить</button>

</form>
<p><?= $checkResult ?></p>

    <div class="alert alert-warning" role="alert">
        <mark> Если плохо видно то нажмите еще раз "Проверить"</mark>
    </div>


</body>
</html>