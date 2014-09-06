
<?php
function uploadImage($filesUploadsArray){

    $newFilesUploadsArray = reArrayFiles($filesUploadsArray);

    $countUploadsImage = 0;

    foreach($newFilesUploadsArray as $fileUploadsArray){

    $countUploadsImage++;
    $allowedExtension = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $fileUploadsArray["name"]);
    $extension = end($temp);
        if (($fileUploadsArray["type"] == "image/gif")
            || ($fileUploadsArray["type"] == "image/jpeg")
            || ($fileUploadsArray["type"] == "image/jpg")
            || ($fileUploadsArray["type"] == "image/png")
            && ($fileUploadsArray["size"] < 20000)
            && in_array($extension, $allowedExtension)){

            if ($fileUploadsArray["error"] > 0){

                echo "Код ошибки: " . $fileUploadsArray["error"] . "<br>";
            }
            else{

                $directoryForUploadNormal = __DIR__."/../../uploads/images/normal/".date(Y)."-".date(m)."-".date(d);
                $nameImageForUploadWithoutExtension = "/image".time()."-".$countUploadsImage."-";
                $fullPathFileForUploadNormal = $directoryForUploadNormal.$nameImageForUploadWithoutExtension.".".$extension;

                if (!file_exists($directoryForUploadNormal)) {
                    mkdir($directoryForUploadNormal, 0777, true);
                }
                move_uploaded_file($fileUploadsArray["tmp_name"],
                    $fullPathFileForUploadNormal);

                uploadResizeImage($fullPathFileForUploadNormal, $nameImageForUploadWithoutExtension, $extension);
            }
}
        else{

            echo "Разрешается загружать только изображения!";
        }
    }
}

function uploadResizeImage($fullPathToImage, $nameImageForUploadWithoutExtension, $extension ){


    $image_info = getimagesize($fullPathToImage);
    $image_type = $image_info[2];

    if( $image_type == IMAGETYPE_JPEG ) {
        $currentImageForResize = imagecreatefromjpeg($fullPathToImage);
    } elseif( $image_type == IMAGETYPE_GIF ) {
        $currentImageForResize = imagecreatefromgif($fullPathToImage);
    } elseif( $image_type == IMAGETYPE_PNG ) {
        $currentImageForResize = imagecreatefrompng($fullPathToImage);
    }

    $widthCurrentImageForResize = imagesx($currentImageForResize);
    $heightCurrentImageForResize = imagesy($currentImageForResize);

//скорее всего надо будет задавать некие зависимости высоты и ширины. Ё!
    $widthNewImage = 400;
    $heightNewImage = 200;

    $newResizeImage = imagecreatetruecolor($widthNewImage, $heightNewImage);
    imagecopyresampled($newResizeImage, $currentImageForResize, 0, 0, 0, 0, $widthNewImage, $heightNewImage, $widthCurrentImageForResize, $heightCurrentImageForResize);

    $directoryForUploadResize = __DIR__."/../../uploads/images/resize/".date(Y)."-".date(m)."-".date(d);
    $nameForResizeImage = $directoryForUploadResize.$nameImageForUploadWithoutExtension.$widthNewImage."x".$heightNewImage.".".$extension;

    if (!file_exists($directoryForUploadResize)) {
        mkdir($directoryForUploadResize, 0777, true);
    }

    if( $image_type == IMAGETYPE_JPEG ) {
        imagejpeg($newResizeImage, $nameForResizeImage); //третий параметр может быть $compression
    } elseif( $image_type == IMAGETYPE_GIF ) {
        imagegif($newResizeImage, $nameForResizeImage);
    } elseif( $image_type == IMAGETYPE_PNG ) {
        imagepng($newResizeImage, $nameForResizeImage);
    }
}


//Тупой php при отправке нескольких изображений формирует массив
//не так как ожидается! Поэтому удобнее использовать функцию:

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
?>

<?

$currentUrl = $_SERVER["REQUEST_URI"];

if(!empty($_FILES["uploaded_image"])){
    uploadImage($_FILES["uploaded_image"]);
}
?>
<div>
    <form action="<? echo $currentUrl?>" enctype="multipart/form-data" method="POST">

            <label for="uploaded_image1">Выберите изображение:</label>
            <input type="file" name="uploaded_image[]" class="uploaded_image" id="uploaded_image1">
        <br>
        <br>
            <label for="uploaded_image2">Выберите изображение:</label>
            <input type="file" name="uploaded_image[]" class="uploaded_image" id="uploaded_image2">
        <br>
        <br>
        <input type="submit" name="submit" value="Отправить">
    </form>
</div>
<!--Если мы перезагружаем страницу ПОСТ отправляется вновь. Переходим по ссылке и все чисто!-->
<a href='<?echo $currentUrl?>'>Го я создал</a>


