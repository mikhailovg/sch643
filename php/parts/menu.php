<link rel="stylesheet" href="/css/parts/menu.css">
<script src="/js/parts/menu.js"></script>
<?
    class Menu_Item {
        public $title;
        public $url;
        public $submenu_items;
        public $pattern;
        function Menu_Item($title, $url, $pattern, $submenu_items = null) {
            $this->title = $title;
            $this->url = $url;
            $this->pattern = $pattern;
            $this->submenu_items = $submenu_items;
        }
    }
    $menu = array(
        new Menu_Item("Главная", "/", null, array(
            new Menu_Item("Новости",   "/",          "/(^\/$)|(^\/news)|(^\/article)/i"),
            new Menu_Item("Сведения об образовательной организации",     "/about",     "/^\/about/i"),
            new Menu_Item("Учительская",   "/teachers",  "/^\/teachers/i"),
            new Menu_Item("Опытно-экспериментальная работа", "/tutors",    "/^\/tutors/i")
        )),
        new Menu_Item("Бизнес Сето", "/business", "/^\/business/i"),
        new Menu_Item("Музей Сето", "/museum", null, array(
            new Menu_Item("Экспонаты музея",           "/museum",     "/^\/museum/i"),
            new Menu_Item("Литературные произведения", "/literature", "/^\/literature/i")
        )),
        new Menu_Item("Альбом", "/albums", null, array(
            new Menu_Item("Фото",  "/albums", "/(^\/albums)|(^\/album)|(^\/photo)/i"),
            new Menu_Item("Видео", "/videos", "/(^\/videos)|(^\/video)/i")
        )),
        new Menu_Item("Услуги", "/service",  "/^\/service/i"),
        new Menu_Item("Товары", "/goods",    "/^\/goods/i")
    );
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_menu_item = null;
    $current_submenu_item = null;
    foreach($menu as $menu_item) {
        if ($menu_item->pattern != null) {
            if (preg_match($menu_item->pattern, $request_uri)) {
                $current_menu_item = $menu_item;
            };
        }
        if ($menu_item->submenu_items != null) {
            foreach ($menu_item->submenu_items as $submenu_item) {
                if (preg_match($submenu_item->pattern, $request_uri)) {
                    $current_menu_item = $menu_item;
                    $current_submenu_item = $submenu_item;
                }
            }
        }
    }
?>
<!--<div class="menu">
    <div class="menu__ribbon-top"></div>
    <?php /*include_once("slider.php"); */?>
    <nav class="menu__menu">
        <ul class="menu__primary-items">
        <?/* foreach($menu as $submenu_item_index => $menu_item) { */?>
            <li class="menu__item<?/* if ($menu_item == $current_menu_item) {*/?> menu__item--current<?/* } */?>">
                <a href="<?/*=$menu_item->url*/?>">
                    <?/*=$menu_item->title*/?>
                </a>
            </li>
            <?/* if ($submenu_item_index != count($menu) - 1) { */?>
                <li class="menu__separator--primary"></li>
            <?/* } else { */?>
                <li class="menu__break"></li>
            <?/* } */?>
        <?/* } */?>
        </ul>
        <?/* foreach($menu as $menu_item_index => $menu_item) {
            if (is_null($menu_item->submenu_items)) {*/?>
                <ul class="menu__no-secondary-items"></ul>
            <?/* } else { */?>
                <ul class="menu__secondary-items" <?/* if (!($menu_item == $current_menu_item || ($current_menu_item == null || $current_submenu_item == null) && $menu_item_index === 0 )) {*/?>style="display: none" <?/*} */?> >
                <?/* foreach($menu_item->submenu_items as $submenu_item_index => $submenu_item) { */?>
                    <li class="menu__item<?/* if ($submenu_item == $current_submenu_item) {*/?> menu__item--current<?/* } */?>">
                        <a href="<?/*=$submenu_item->url*/?>">
                            <?/*=$submenu_item->title*/?>
                        </a>
                    </li>
                    <?/* if ($submenu_item_index != count($menu_item->submenu_items) - 1) { */?>
                        <li class="menu__separator--secondary"></li>
                    <?/* } else { */?>
                        <li class="menu__break"></li>
                    <?/* } */?>
                <?/* } */?>
                </ul>
        <?/* }} */?>
    </nav>
    <div class="menu__ribbon-bottom"></div>
</div>-->


<ul id="nav7">
    <li><a href="#1">Главная</a>
        <ul>
            <li><a href="#2-1">Новости</a>
            <li><a href="#2-2">Сведения об образовательной организации</a>
            <li><a href="#2-3">Учительская</a>
            <li><a href="#2-4">Опытно-экспериментальная работа</a>
        </ul>
    <li><a href="#2">Пункт 2</a>
        <ul>
            <li><a href="#2-1">Подменю 1</a>
            <li><a href="#2-2">Подменю 2</a>
            <li><a href="#2-3">Подменю 3</a>
            <li><a href="#2-4">Подменю 4</a>
        </ul>
    <li><a href="#3">Пункт 3</a>
        <ul>
            <li><a href="#3-1">Подменю 1</a>
            <li><a href="#3-2">Подменю 2</a>
        </ul>
    <li ><a href="#4">Пункт 4</a>
        <ul>
            <li><a href="#4-1">ПодменюПодменюПодменюПодменюПодменю 1</a>
            <li><a href="#4-2">Подменю 2</a>
            <li><a href="#4-3">Подменю 3</a>
        </ul>
    <li ><a href="#4">Пункт 4</a>
        <ul>
            <li><a href="#4-1">Подменю 6</a>
            <li><a href="#4-2">Подменю 2</a>
            <li><a href="#4-3">Подменю 3</a>
        </ul><li><a href="#1">Главная</a>
        <ul>
            <li><a href="#2-1">Новости</a>
            <li><a href="#2-2">Сведения об образовательной организации</a>
            <li><a href="#2-3">Учительская</a>
            <li><a href="#2-4">Опытно-экспериментальная работа</a>
        </ul>
    <li><a href="#2">Пункт 2</a>
        <ul>
            <li><a href="#2-1">Подменю 1</a>
            <li><a href="#2-2">Подменю 2</a>
            <li><a href="#2-3">Подменю 3</a>
            <li><a href="#2-4">Подменю 4</a>
        </ul>
    <li><a href="#3">Пункт 3</a>
        <ul>
            <li><a href="#3-1">Подменю 1</a>
            <li><a href="#3-2">Подменю 2</a>
        </ul>
    <li ><a href="#4">Пункт 4</a>
        <ul>
            <li><a href="#4-1">ПодменюПодменюПодменюПодменюПодменю 1</a>
            <li><a href="#4-2">Подменю 2</a>
            <li><a href="#4-3">Подменю 3</a>
        </ul>
    <li class="right"><a href="#4">Пункт 4</a>
        <ul>
            <li><a href="#4-1">Подменю 6</a>
            <li><a href="#4-2">Подменю 2</a>
            <li><a href="#4-3">Подменю йцуйцуйцуйцу</a>
        </ul>
</ul>