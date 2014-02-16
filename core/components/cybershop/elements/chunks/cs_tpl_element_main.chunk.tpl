<div class="product" id="product" data-price="[[+price]]" data-id="[[+id]]" data-complectid="[[+complectid]]">
    <h1>[[+name]]</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <a class="fancybox" href="[[+image]]"><img src="[[phpthumbof? &input=`[[+image]]` &options=`h=600`]]" alt="no image" class="img-thumbnail"></a>
            [[+images]]
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <div class="product_price_lable">
                Цена:
            </div>
            <div class="product_price_value">
                <span id="price">[[+price_print]]</span>  
                [[++cybershop.currency]]
            </div>
            <button type="button" class="btn btn-primary" id="add_to_cart">Добавить в корзину</button>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3">
            [[+select_size]]
        </div>
    </div>
    <div class="product_desc">
        <h2>Описание</h2>
        <p>[[+fulltext]]</p>
    </div>
</div>