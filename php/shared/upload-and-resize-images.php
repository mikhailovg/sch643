<?

/**
 * Загружает паачку картинок на сервер, попутно ресайзя их, если надо.
 * @param $files объект $_FILES
 * @param $dimensions массив строк в которых указаны необходимые размеры изображений на выходе. Значения могут принимать значения "original" или формата "128x256"
 * @return массив, содержащий хеши, в качестве ключей содержащий значения из $dimensions, а значения - пути к файлам
 */
function upload_and_resize_images($files, $dimensions) {
    $paths = array();
    if (!is_array($files["name"])) {
        $paths[] = upload_and_resize_image($files, $dimensions);
    } else {
        foreach(adjust_files_array($files) as $file) {
            $paths[] = upload_and_resize_image($file, $dimensions);
        }
    }
    return $paths;
}

/**
 * Загружает одну картинку на сервер, попутно ресайзя её, если надо.
 * @param $file один файл из модифицированного $_FILES
 * @param $dimensions массив строк в которых указаны необходимые размеры изображений на выходе. Значения могут принимать значения "original" или формата "128x256"
 * @return хеш, в качестве ключей содержащий значения из $dimensions, а значения - пути к файлам
 */
function upload_and_resize_image($file, $dimensions) {
    if (!validate_image($file)) return null;
    $paths = array();
    $upload_directory = create_image_upload_directory();
    $base_name = unique_base_name();
    $extension = strtolower(end(explode(".", $file["name"])));

    $original_image_path = $upload_directory."/".$base_name."_original.".$extension;
    save_original_image($file, $original_image_path);

    if (in_array("original", $dimensions)) {
        // Кладем относительный от корня путь.
        $paths["original"] = substr($original_image_path, strlen($_SERVER['DOCUMENT_ROOT']));
    }

    list($original_width, $original_height) = getimagesize($original_image_path);
    foreach ($dimensions as $dimensions) {
        if ($dimensions === "original") continue;
        list($desired_width, $desired_height) = explode("x", $dimensions);
        $desired_width = intval($desired_width);
        $desired_height = intval($desired_height);
        // Если меньше указанных размеров то не делать ничего.
        if (($desired_width == 0 || $original_width <= $desired_width) && ($desired_height === 0 || $original_height <= $desired_height)) {
            $paths[$dimensions] = substr($original_image_path, strlen($_SERVER['DOCUMENT_ROOT']));
        } else {
            $resized_image_path = $upload_directory."/".$base_name."_".$dimensions.".".$extension;
            save_resized_image($original_image_path, $resized_image_path, $desired_width, $desired_height);
            $paths[$dimensions] =  substr($resized_image_path, strlen($_SERVER['DOCUMENT_ROOT']));
        }
    }

    return $paths;
}

/**
 * Удостоверяется, что файл - это картинка.
 * @param $file один файл из модифицированного $_FILES
 * @return true если это картина, false - если нет
 */
function validate_image($file) {
    $extension = strtolower(end(explode(".", $file["name"])));
    $allowed_extensions = array("gif", "jpeg", "jpg", "png");
    $allowed_types = array( "image/jpeg", "image/jpg", "image/png");
    return in_array($extension, $allowed_extensions)
    && in_array($file["type"], $allowed_types);
}

/**
 * Создает директорию, вкоторую будут сохранены загружаемы сейчас картинки.
 */
function create_image_upload_directory() {
    $upload_directory = $_SERVER['DOCUMENT_ROOT']."/uploads/images/".date(Y)."/".date(m)."/".date(d);
    if (!file_exists($upload_directory)) {
        mkdir($upload_directory, 0777, true);
    }
    return $upload_directory;
}

/**
 * Формирует уникальное имя для всех картинок из серии.
 * @return уникальное базовое имя
 */
function unique_base_name() {
    return preg_replace("/[\. ]/i", "_", microtime());
}

/**
 * Сохраняет оригинальную картинку по укзанному пути.
 * @param  $file один файл из модифицированного $_FILES
 * @param $path путь, вместе с именем файла и расширением, куда надо сохранить
 */
function save_original_image($file, $path) {
    move_uploaded_file($file["tmp_name"], $path);
}

/**
 * Уменьшает, обрезает и сохраняет картинку по пути.
 * @param $original_image путь к оригинальной картинке
 * @param $path путь, вместе с именем файла и расширением, куда надо сохранить
 * @param $width ширина картинки в пикселях
 * @param $height высота картинки в пикселях
 */
function save_resized_image($original_image_path, $path, $desired_width, $desired_height) {

    // Должен быть задан хоть один праметр, иначе
    // непонятно до каких размеров уменьшать.
    assert($desired_height != null || $desired_width != null);

    list($original_image_width, $original_image_height, $image_type) = getimagesize($original_image_path);

    // Соотношение сторон в оригинальной картинке.
    $original_aspect_ratio = $original_image_width/$original_image_height;

    // Если один из параметров не задан, нужно просто
    // уменьшить, сохранив исходное соотношение сторон.
    if ($desired_width == null) {
        $desired_width = (int)($desired_height * $original_aspect_ratio);
    } elseif ($desired_height == null) {
        $desired_height = (int)($desired_width / $original_aspect_ratio);
    }

    // Соотношение сторон в картинке,
    // которую хотим получим на выходе.
    $desired_aspect_ratio = $desired_width/$desired_height;

    // Ориинал более вытянут по ширине, чем результирующее изображение,
    // значит надо чтобы по высоте оно поместилось полностью, а куски
    // слева и справа пусть обрезаются. Такие формулы для x,w,y,h можно
    // получить просто нарисовав картинку для обоих случаев.
    if ($original_aspect_ratio >= $desired_aspect_ratio) {
        $src_x = (int)(($original_aspect_ratio - $desired_aspect_ratio) * $original_image_height / 2);
        $src_w = (int)($desired_aspect_ratio * ($original_image_width / $original_aspect_ratio));
        $src_y = 0;
        $src_h = $original_image_height;
    }
    // Если оригинал более вытянут по высоте, надо подгонять ширину,
    // а куски сверху и снизу пусть обрезаются.
    else {
        $src_x = 0;
        $src_w = $original_image_width;
        // Формулы немного модицицированы, чтобы увелисить точность.
        $src_y = (int)($original_image_width * ($desired_aspect_ratio - $original_aspect_ratio) / ($original_aspect_ratio * $desired_aspect_ratio *  2));
        $src_h = (int)($original_image_height * $original_aspect_ratio / $desired_aspect_ratio);
    }

    if($image_type == IMAGETYPE_JPEG || $image_type == IMAGETYPE_JPEG2000) {
        $src_image = imagecreatefromjpeg($original_image_path);
    } elseif($image_type == IMAGETYPE_GIF) {
        $src_image = imagecreatefromgif($original_image_path);
    } elseif($image_type == IMAGETYPE_PNG) {
        $src_image = imagecreatefrompng($original_image_path);
    }

    /*var_dump($src_x);
    var_dump($src_w);
    var_dump($src_y);
    var_dump($src_h);*/

    $dist_image = imagecreatetruecolor($desired_width, $desired_height);
    imagecopyresampled($dist_image, $src_image, 0, 0, $src_x, $src_y, $desired_width, $desired_height, $src_w, $src_h);

    if($image_type == IMAGETYPE_JPEG) {
        imagejpeg($dist_image, $path, 100);
    } elseif($image_type == IMAGETYPE_GIF) {
        imagegif($dist_image, $path);
    } elseif($image_type == IMAGETYPE_PNG) {
        imagepng($dist_image, $path);
    }
}

/**
 * PHP при загрузке нескольких файлов формирует массив
 * в транспонированном виде, из-за чего по нему нельзя
 * пройтись foreach. Данная функция формирует массив с
 * теми же данными в нормальном виде.
 */
function adjust_files_array(&$file_post) {
    $file_array = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_array[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_array;
}
