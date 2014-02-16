<table class="table table-bordered table-cart">
<thead>
<th class="col-xs-12 col-sm-4 col-md-2 image">Изображение</th>
<th class="col-xs-12 col-sm-4 col-md-4 title">Наименование</th>
<th class="col-xs-12 col-sm-4 col-md-2 size">Размер</th>
<th class="col-xs-12 col-sm-4 col-md-1 count">Количество</th>
<th class="col-xs-12 col-sm-4 col-md-2 price">Цена</th>
<th class="col-xs-12 col-sm-4 col-md-2 remove">Удалить</th>
</thead>
<tbody>
[[+rows]]
</tbody>
<tfoot>
<th class="total" colspan="3">Всего:</th>
<th class="total_count"><span class="cs_total_count">[[+total_count]]</span> шт.</th>
<th class="total_cost"><span class="cs_total_cost">[[+total_cost]]</span> руб.</th>
<th>&nbsp;</th>
</tfoot>
</table>
<a href="[[~[[++cybershop.res_cart_order_id]]]]" class="btn btn-primary" role="button">Оформить заказ</a>
<a href="#" data-action="cart/clean" class="btn btn-default cs_link" role="button">Очистить корзину</a>