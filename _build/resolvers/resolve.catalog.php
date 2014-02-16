<?php

/**
 * Resolve creating demo catalog
 *
 * @package cybershop
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /* @var modX $modx */
            $modx = & $object->xpdo;
            $modelPath = $modx->getOption('cybershop.core_path', null, $modx->getOption('core_path') . 'components/cybershop/') . 'model/';
            $modx->addPackage('cybershop', $modelPath);
            $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
            
            /*
            * Element id 2
            */
            
            if (!$object = $modx->getObject('csCatalog', 1)) {
                $object = $modx->newObject('csCatalog');
                $object->fromArray(array(
                    'id' => 1
                    , 'name' => 'Samsung i9300 Galaxy S III 16 Гб'
                    , 'description' => 'Телефон Samsung i9300 Galaxy S III 16 Гб синего цвета'
                    , 'article' => 'тел-samsung-gt-i9500-galaxy-s-iv-16-gb-black'
                    , 'alias' => 'samsung-gt-i9500-galaxy-s-iv-16-gb-black'
                    , 'introtext' => 'Телефон Samsung i9300 Galaxy S III 16 Гб синего цвета'
                    , 'fulltext' => 'Samsung GT-I9500 Galaxy S 4 16 Гб Black - Он будет с тобой каждую секунду жизни. Быстрый, отзывчивый, незаменимый, словно надежный и проверенный друг, которому просто и легко довериться.
Samsung Galaxy S 4 создан сделать твою жизнь проще и позволит получить удовольствие от каждого ее мгновения.
Хотите подчеркнуть свой изысканный вкус эффектным дизайном? Насладиться самыми красивыми играми? С комфортом смотреть HD-кино в дороге? Делать качественные фотографии и не носить с собой повсюду цифровой фотоаппарат? Значит, Samsung GT-I9500 Galaxy S 4 16 Гб Black создан именно для вас.
5-дюймовый сенсорный дисплей устройства, выполненный по технологии Super AMOLED, демонстрирует кристально чистую и яркую картинку в разрешении 1920х1080 пикселей. Высокая чувствительность экрана дает ему возможность прекрасно распознавать касания, сделанные в перчатках. Таким образом, пользоваться телефоном Samsung GT-I9500 Galaxy S IV 16 Гб Black будет одинаково удобно в любое время года.
Аппаратная начинка смартфона Samsung GT-I9500 Galaxy S IV 16 Гб Black представлена поистине ударным тандемом из восьмиядерного процессора Exynos, работающего с тактовой частотой 1.6 ГГц и 2 Гб оперативной памяти. С такой конфигурацией у вас, что называется, "полетит" даже самая производительная игра, да и о стабильности системы при нескольких одновременно работающих приложениях можно будет не беспокоиться.
ИК-порт даст вам возможность использовать смартфон Samsung GT-I9500 Galaxy S 4 16 Гб Black в качестве универсального пульта для мультимедийной техники.
Функция Samsung Adapt Display подберет оптимальные настройки экрана для каждого приложения.
Smart Pause остановит видео или игру в том случае, если пользователь отвернулся и не смотрит на дисплей. '
                    , 'brand' => 1
                    , 'category' => 2
                    , 'price1' => 19990
                    , 'image' => 'upload/catalog/images/catalog/1/samsung-gt-i9500-galaxy-s-iv-16-gb-black-1.jpg'
                    , 'active' => 1
                    , 'onhomepage' => 1
                        ), '', true);
                $object->save();
            }

            if (!$object = $modx->getObject('csCatalogImageTable', 1)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 1
                    , 'catalog' => 1
                    , 'name' => 'Картинка 1'
                    , 'image' => 'upload/catalog/images/catalog/1/samsung-gt-i9500-galaxy-s-iv-16-gb-black-1.jpg'
                        ), '', true);
                $object->save();
            }
            if (!$object = $modx->getObject('csCatalogImageTable', 2)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 2
                    , 'catalog' => 1
                    , 'name' => 'Картинка 2'
                    , 'image' => 'upload/catalog/images/catalog/1/samsung-gt-i9500-galaxy-s-iv-16-gb-black-2.jpg'
                        ), '', true);
                $object->save();
            }
            
            if (!$object = $modx->getObject('csCatalogComplectTable', 1)) {
                $object = $modx->newObject('csCatalogComplectTable');
                $object->fromArray(array(
                    'id' => 1
                    , 'catalog' => 1
                    , 'name' => 'размер 10х15'
                    , 'price1' => '19990'
                        ), '', true);
                $object->save();
            }
            if (!$object = $modx->getObject('csCatalogComplectTable', 2)) {
                $object = $modx->newObject('csCatalogComplectTable');
                $object->fromArray(array(
                    'id' => 2
                    , 'catalog' => 1
                    , 'name' => 'размер 15х25'
                    , 'price1' => '21990'
                        ), '', true);
                $object->save();
            }
            
            /*
            * Element id 2
            */
            
            if (!$object = $modx->getObject('csCatalog', 2)) {
                $object = $modx->newObject('csCatalog');
                $object->fromArray(array(
                    'id' => 2
                    , 'name' => 'Samsung GT-I9190 Galaxy S4 mini Black'
                    , 'description' => 'Телефон Samsung GT-I9190 Galaxy S4 mini Black'
                    , 'article' => 'тел-samsung-gt-i9190-galaxy-s-4-mini-black'
                    , 'introtext' => 'Телефон Samsung GT-I9190 Galaxy S4 mini Black'
                    , 'fulltext' => 'Привлекательный Samsung GALAXY S4 mini обладает практически всеми возможностями флагманского смартфона Samsung GALAXY S4 при своих компактных размерах, за счет которых его очень удобно носить с собой и управлять им одной рукой. Качественный карбоновый корпус, представленный в множестве цветовых решений, удовлетворит любого пользователя. Яркий дисплей с диагональю 4,3 дюйма гарантирует более чистое и четкое изображение.'
                    , 'alias' => 'samsung-gt-i9190-galaxy-s-4-mini-black'
                    , 'brand' => 1
                    , 'category' => 2
                    , 'price1' => 14990
                    , 'image' => 'upload/catalog/images/catalog/2/samsung-gt-i9190-galaxy-s-4-mini-black-1.jpg'
                    , 'active' => 1
                    , 'onhomepage' => 1
                        ), '', true);
                $object->save();
            }
            
            if (!$object = $modx->getObject('csCatalogImageTable', 3)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 3
                    , 'catalog' => 2
                    , 'name' => 'Картинка 1'
                    , 'image' => 'upload/catalog/images/catalog/2/samsung-gt-i9190-galaxy-s-4-mini-black-1.jpg'
                        ), '', true);
                $object->save();
            }
            
            if (!$object = $modx->getObject('csCatalogImageTable', 4)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 4
                    , 'catalog' => 2
                    , 'name' => 'Картинка 2'
                    , 'image' => 'upload/catalog/images/catalog/2/samsung-gt-i9190-galaxy-s-4-mini-black-2.jpg'
                        ), '', true);
                $object->save();
            }  
            
            if (!$object = $modx->getObject('csCatalogImageTable', 5)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 5
                    , 'catalog' => 2
                    , 'name' => 'Картинка 3'
                    , 'image' => 'upload/catalog/images/catalog/2/samsung-gt-i9190-galaxy-s-4-mini-black-3.jpg'
                        ), '', true);
                $object->save();
            }  

            /*
            * Element id 3
            */        
            
            if (!$object = $modx->getObject('csCatalog', 3)) {
                $object = $modx->newObject('csCatalog');
                $object->fromArray(array(
                    'id' => 3
                    , 'name' => 'Nokia Lumia 520 Yellow'
                    , 'description' => 'Телефон Nokia Lumia 520 Yellow'
                    , 'article' => 'тел-nokia-lumia-520-yellow'
                    , 'alias' => 'nokia-lumia-520-yellow'
                    , 'introtext' => 'Телефон Nokia Lumia 520 Yellow'
                    , 'fulltext' => 'Телефон Nokia Lumia 520 Yellow на платформе Windows Phone 8 оснащен эксклюзивными фотоприложениями, двухъядерным процессором 1 ГГц и сверхчувствительным сенсорным экраном, который реагирует даже на прикосновение ногтем или пальцем в перчатке. Телефон Nokia Lumia 520 оснащен фотоприложениями, которые используются только на устройствах Nokia. Друзья не смогут сдержать своего восхищения. Оживите изображения с помощью приложения «Ожившие фото». Сделайте серию кадров одним щелчком с помощью функции «Умное фото», чтобы затем выбрать идеальный снимок. 4-дюймовый сенсорный экран Nokia Lumia 520 настолько чувствителен, что реагирует на прикосновение ногтя и пальца в перчатке. Поэтому печатать, общаться и искать информацию в Интернете стало еще удобнее. '
                    , 'brand' => 2
                    , 'category' => 2
                    , 'price1' => 6990
                    , 'image' => 'upload/catalog/images/catalog/3/nokia-lumia-520-yellow-1.jpg'
                    , 'active' => 1
                    , 'onhomepage' => 0
                        ), '', true);
                $object->save();
            }

                if (!$object = $modx->getObject('csCatalogImageTable', 6)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 6
                    , 'catalog' => 3
                    , 'name' => 'Картинка 1'
                    , 'image' => 'upload/catalog/images/catalog/3/nokia-lumia-520-yellow-1.jpg'
                        ), '', true);
                $object->save();
            } 
              
            if (!$object = $modx->getObject('csCatalogImageTable', 7)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 7
                    , 'catalog' => 3
                    , 'name' => 'Картинка 2'
                    , 'image' => 'upload/catalog/images/catalog/3/nokia-lumia-520-yellow-96052.jpg'
                        ), '', true);
                $object->save();
            } 

            if (!$object = $modx->getObject('csCatalogImageTable', 8)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 8
                    , 'catalog' => 3
                    , 'name' => 'Картинка 3'
                    , 'image' => 'upload/catalog/images/catalog/3/nokia-lumia-520-yellow-2.jpg'
                        ), '', true);
                $object->save();
            }
            
            /*
            * Element id 4
            */ 
            
            if (!$object = $modx->getObject('csCatalog', 4)) {
                $object = $modx->newObject('csCatalog');
                $object->fromArray(array(
                    'id' => 4
                    , 'name' => 'LG G2 D802 32 Гб White'
                    , 'description' => 'Телефон LG G2 D802 32 Гб White'
                    , 'article' => 'тел-lg-g2-d802-32-gb-white'
                    , 'alias' => 'lg-g2-d802-32-gb-white'
                    , 'introtext' => 'Телефон LG G2 D802 32 Гб White'
                    , 'fulltext' => 'LG G2 D802 – новый флагманский смартфон от корейского производителя. Одной из изюминок модели стала необычная кнопка управления, расположенная на задней панели корпуса. Со слов инженеров LG, идея размещения аппаратных кнопок на задней панели LG G2 возникла благодаря исследованию пользователей, которые испытывали трудности при управлении смартфонами с крупными экранами. В результате расположения кнопок только на задней поверхности смартфона в 70% случаев люди стали ронять смартфоны реже. Долгое удержание верхней кнопки запускает приложение Qmemo, нижней – вызывает камеру из спящего режима. Долгое нажатие центральной кнопки активирует съёмку фото или видео.'
                    , 'brand' => 3
                    , 'category' => 2
                    , 'price1' => 22990
                    , 'image' => 'upload/catalog/images/catalog/4/lg-g2-d802-32-gb-white-1.jpg'
                    , 'active' => 1
                    , 'onhomepage' => 1
                        ), '', true);
                $object->save();
            }
            
            if (!$object = $modx->getObject('csCatalogImageTable', 9)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 9
                    , 'catalog' => 4
                    , 'name' => 'Картинка 1'
                    , 'image' => 'upload/catalog/images/catalog/4/lg-g2-d802-32-gb-white-1.jpg'
                        ), '', true);
                $object->save();
            }
                        
            if (!$object = $modx->getObject('csCatalogImageTable', 10)) {
                $object = $modx->newObject('csCatalogImageTable');
                $object->fromArray(array(
                    'id' => 10
                    , 'catalog' => 4
                    , 'name' => 'Картинка 2'
                    , 'image' => 'upload/catalog/images/catalog/4/lg-g2-d802-32-gb-white-2.jpg'
                        ), '', true);
                $object->save();
            }
            
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            if ($modx instanceof modX) {
                $modx->removeExtensionPackage('cybershop');
            }
            break;
    }
}
return true;
