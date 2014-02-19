<div class="span3 LSidebar">
[[+rows_nav]]
<div id="catalog_nav_placeholder">
[[+rows_nav_ajax]]    
</div>
<div class="Block-in">
<h2 class="HD2">Диапазон цен</h2>
<div class="in">
<p>
<input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
</p>
<div id="slider-range"></div>
</div>
</div>
<input type="hidden" value="[[+categorysgroup]]" id="categorysgroup" />
<input type="hidden" value="" id="categorysInput" />
<input type="hidden" value="" id="brandsInput" />
<input type="hidden" value="" id="filtersInput" />
<input type="hidden" value="[[+cs_min_slider-range]]" id="cs_min_range" />
<input type="hidden" value="[[+cs_max_slider-range]]" id="cs_max_range" />
<input type="hidden" value="" id="pricemin" />
<input type="hidden" value="" id="pricemax" />
<input type="hidden" value="" id="page" />
<input type="hidden" id="cs_action_url" value="[[~[[*id]]]]" />
</div>
<div class="span9 Catalog">
<div class="Breadcrambs"><a href="">Главная</a> &gt; Каталог - [[+category_name]]</div>
<h2 class="HD">Каталог - [[+category_name]]</h2>
<div class="in" id="catalog_placeholder">
[[+rows_result]]
</div>
<div class="pagination">
<ul id="pagination_placeholder">
[[+pagination]]
</ul>
</div>
</div>

