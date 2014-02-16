<div id="cs_Cart">
<table class="table table-striped">
<tr class="header">
<th class="image span2">&nbsp;</th>
<th class="title span4">Наименование</th>
<th class="color span2">Цвет</th>
<th class="count span2">Количество</th>
[[<th class="weight span1">[[%ms2_cart_weight]]</th>]]
<th class="price span1">Цена</th>
<th class="remove span2">Удалить</th>
</tr>
[[+rows]]
<tr class="footer">
<th class="total" colspan="3">Всего:</th>
<th class="total_count"><span class="cs_total_count">[[+total_count]]</span> шт.</th>
[[<th class="total_weight"><span class="cs_total_weight">[[+total_weight]]</span> [[%cs_frontend_weight_unit]]</th>]]
<th class="total_cost"><span class="cs_total_cost">[[+total_cost]]</span> сом.</th>
<th>&nbsp;</th>
</tr>
</table>
<a href="#" data-action="cart/clean" class="cs_link"><i class="icon-remove-sign"></i> Очистить корзину </a>
<a href="[[~8]]" class="btn btn-primary">Оформить заказ</a>
</div>