<?php
/**
 * Default English Lexicon Entries for Cybershop
 *
 * @package cybershop
 * @subpackage lexicon
 */
//menu
$_lang['cybershop'] = 'Магазин';
$_lang['cs_menu_desc'] = 'Магазин электронной торговли Cybershop';
$_lang['cs_add'] = 'Дополнительно';


$_lang['cs_grid_complects'] = 'Таблица комплектов';
$_lang['cs_grid_filteritem'] = 'Таблица элементов фильтра';

$_lang['cs_shop'] = 'Магазин';
$_lang['cs_catalog'] = 'Каталог товаров';
$_lang['cs_catalog_desc'] = 'Каталог товаров';
$_lang['cs_orders'] = 'Заказы';
$_lang['cs_order'] = 'Заказ';
$_lang['cs_brands'] = 'Бренды';
$_lang['cs_brand'] = 'Бренд';
$_lang['cs_categorys'] = 'Категории';
$_lang['cs_category'] = 'Категория';
$_lang['cs_subcategorys'] = 'Подкатегории';
$_lang['cs_subcategory'] = 'Подкатегория';
$_lang['cs_status'] = 'Статус';
$_lang['cs_tools'] = 'Инструменты';
$_lang['cs_filtercategorys'] = 'Категории фильтров';
$_lang['cs_filters'] = 'Фильтры';
$_lang['cs_filter'] = 'Фильтр';
$_lang['cs_properties'] = 'Свойства';
$_lang['cs_currency'] = 'Курс валюты';

$_lang['cs_order'] = 'Заказ';
$_lang['cs_orders'] = 'Заказы';
$_lang['cs_orders_intro'] = 'Панель управления заказами';
$_lang['cs_orders_desc'] = 'Управление заказами';
$_lang['cs_settings'] = 'Настройки';
$_lang['cs_payment'] = 'Оплата';
$_lang['cs_payments'] = 'Способы оплаты';
$_lang['cs_payments_intro'] = 'Вы можете создавать любые способы оплаты заказов. Логика оплаты (отправка покупателя на удалённый сервис, приём оплаты и т.п.) реализуется в классе, который вы укажете.<br/>Для методов оплаты параметр "класс" обязателен.';
$_lang['cs_delivery'] = 'Доставка';
$_lang['cs_deliveries'] = 'Варианты доставки';
$_lang['cs_deliveries_intro'] = 'Возможные варианты доставки. Логика рассчёта стоимости доставки в зависимости от расстояния и веса реализуется классом, который вы укажете в настройках.<br/>Если вы не укажете свой класс, рассчеты будут производиться алгоритмом по-умолчанию.';
$_lang['cs_statuses'] = 'Статусы заказа';
$_lang['cs_statuses_intro'] = 'Существует несколько обязательных статусов заказа: "новый", "оплачен", "отправлен" и "отменён". Их можно настраивать, но нельзя удалять, так как они необходимы для работы магазина. Вы можете указать свои статусы для расширенной логики работы с заказами.<br/>Статус может быть окончательным, это значит, что его нельзя переключить на другой, например "отправлен" и "отменён". Стутус может быть зафиксирован, то есть, с него нельзя переключаться на более ранние статусы, например "оплачен" нельзя переключить на "новый".';
$_lang['cs_vendors'] = 'Производители товаров';
$_lang['cs_vendors_intro'] = 'Список возможных производителей товаров. То, что вы сюда добавите, можно выбрать в поле "vendor" товара.';
$_lang['cs_customer'] = 'Покупатель';
$_lang['cs_all'] = 'Все';
$_lang['cs_type'] = 'Тип';

$_lang['cs_catalog_err_ns_name'] = 'Ошибка имени элемента!';
$_lang['cs_catalog_err_ae'] = 'Элемент с таким названием уже существует!';
$_lang['cs_search___'] = 'Найти___';

$_lang['records'] = 'элементов';
$_lang['record'] = 'элемент';

$_lang['cs_frontend_currency'] = 'руб_';
$_lang['cs_frontend_weight_unit'] = 'кг_';
$_lang['cs_frontend_count_unit'] = 'шт_';
$_lang['cs_frontend_add_to_cart'] = 'Добавить в корзину';
$_lang['cs_frontend_tags'] = 'Теги';
$_lang['cs_frontend_colors'] = 'Цвета';
$_lang['cs_frontend_color'] = 'Цвет';
$_lang['cs_frontend_sizes'] = 'Размеры';
$_lang['cs_frontend_size'] = 'Размер';
$_lang['cs_frontend_popular'] = 'Популярный товар';
$_lang['cs_frontend_favorite'] = 'Рекомендуем';
$_lang['cs_frontend_new'] = 'Новинка';
$_lang['cs_frontend_deliveries'] = 'Варианты доставки';
$_lang['cs_frontend_payments'] = 'Способы оплаты';
$_lang['cs_frontend_delivery_select'] = 'Выберите доставку';
$_lang['cs_frontend_payment_select'] = 'Выберите оплату';
$_lang['cs_frontend_credentials'] = 'Данные получателя';
$_lang['cs_frontend_address'] = 'Адрес доставки';

$_lang['cs_frontend_comment'] = 'Комментарий';
$_lang['cs_frontend_receiver'] = 'Получатель';
$_lang['cs_frontend_email'] = 'Email';
$_lang['cs_frontend_phone'] = 'Телефон';
$_lang['cs_frontend_index'] = 'Почтовый индекс';
$_lang['cs_frontend_region'] = 'Область';
$_lang['cs_frontend_city'] = 'Город';
$_lang['cs_frontend_street'] = 'Улица';
$_lang['cs_frontend_building'] = 'Дом';
$_lang['cs_frontend_room'] = 'Комната';

$_lang['cs_frontend_order_cost'] = 'Итого, с доставкой';
$_lang['cs_frontend_order_submit'] = 'Сделать заказ!';
$_lang['cs_frontend_order_cancel'] = 'Очистить форму';
$_lang['cs_frontend_order_success'] = 'Спасибо за оформление заказа <b>#[[+num]]</b> на нашем сайте <b>[[++site_name]]</b>!';

$_lang['cs_message_close_all'] = 'закрыть все';
$_lang['cs_err_unknown'] = 'Неизвестная ошибка';
$_lang['cs_err_ns'] = 'Это поле обязательно';
$_lang['cs_err_ae'] = 'Это поле должно быть уникально';
$_lang['cs_err_json'] = 'Это поле требует JSON строку';
$_lang['cs_err_order_nf'] = 'Заказ с таким идентификатором не найден_';
$_lang['cs_err_status_nf'] = 'Статус с таким идентификатором не найден_';
$_lang['cs_err_status_final'] = 'Установлен финальный статус_ Его нельзя менять_';
$_lang['cs_err_status_fixed'] = 'Установлен фиксирующий статус_ Вы не можете сменить его на более ранний_';
$_lang['cs_err_status_same'] = 'Этот статус уже установлен_';
$_lang['cs_err_register_globals'] = 'Ошибка: php параметр <b>register_globals</b> должен быть выключен_';
$_lang['cs_err_link_equal'] = 'Вы пытаетесь добавить товару ссылку на самого себя';

$_lang['cs_err_gallery_save'] = 'Не могу сохранить файл не был сохранён (см_ системный журнал)_';
$_lang['cs_err_gallery_ns'] = 'Передан пустой файл';
$_lang['cs_err_gallery_ext'] = 'Неверное расширение файла';

$_lang['cs_email_subject_new_user'] = 'Вы сделали заказ #[[+num]] на сайте [[++site_name]]';
$_lang['cs_email_subject_new_manager'] = 'У вас новый заказ #[[+num]]';
$_lang['cs_email_subject_paid_user'] = 'Вы оплатили заказ #[[+num]]';
$_lang['cs_email_subject_paid_manager'] = 'Заказ #[[+num]] был оплачен';
$_lang['cs_email_subject_sent_user'] = 'Ваш заказ #[[+num]] был отправлен';
$_lang['cs_email_subject_cancelled_user'] = 'Ваш заказ #[[+num]] был отменён';