<div class="Breadcrambs"><a href="">Главная</a> &gt; [[+name]]</div>
<div class="span5 Img-tovar">
<div class="Foto" id="main_foto_palceholder">
[[+foto]]
</div>
<div class="Foto-min">
[[+rows_complects]]
</div>
</div>
<div class="span7 Desc">
<h2 class="Title">[[+name]]</h2>
<form class="Order cs_form" method="post" data-action="cart/add">
<input type="hidden" value="[[+id]]" name="id" />
<input type="hidden" value="[[+complectid]]" name="complectid" />

<table>
<tr>
<td><div class="PriceT">Цена за штуку:</div></td>
<td><div class="Price">[[+price1]] руб.</div></td>
<tr>
<td><div class="PriceT">Цена за линейку:</div></td>
<td><div class="Price">[[+price2]] руб.</div></td>
<td>
<div class="Number">
<div class="input"><input type="text" name="count" class="span1 nam" value="1" size="1"/></div>
<div class="in">
<span class="plus"></span>
<span class="minus"></span>
</div>
</div>
</td>
<td>
<button type="submit" class="btn"> В корзину</button>
</td>
</tr>
</table>
</form>

<div class="Param">
<div class="span5 in"><div class="e"><span class="L">Артикул</span></div><div class="e1"><span class="R">[[+article]]</span></div></div>
<div class="span5 in"><div class="e"><span class="L">Цвет</span></div><div class="e1"><span class="R" id="active_complect_name_palceholder">[[+maincomplectname]]</span></div></div>

</div>
<div class="text">
[[+introtext]]

</div>
</div>