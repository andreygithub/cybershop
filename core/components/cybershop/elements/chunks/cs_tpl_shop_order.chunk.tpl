<form role="form" class="form-horizontal" action="[[~[[++cybershop.res_cart_order_result_id]]]]" method="post" data-action="order/submit" id="cs_order_form">
  <div class="form-group">
    <label for="fullname" class="col-sm-2 control-label">ФИО*:</label>
    <div class="col-sm-10">
      <input type="text" minlength="2" class="form-control" name="fullname" id="fullname" placeholder="Введите ваше Имя, Фамилия, Отчество" required>
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email*:</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" id="email" placeholder="Введите ваш адрес Email" required>
    </div>
  </div>
  <div class="form-group">
    <label for="phone" class="col-sm-2 control-label">Телефон*:</label>
    <div class="col-sm-10">
      <input type="tel" class="form-control" name="phone" id="phone" placeholder="Введите ваш номер мобильного телефона" required>
    </div>
  </div>  
  <div class="form-group">
    <label for="adress" class="col-sm-2 control-label">Адрес:</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="street" id="adress" rows="3" placeholder="Адрес, куда достовлять товар"></textarea>
    </div>
  </div> 
  <div class="form-group">
    <label for="comment" class="col-sm-2 control-label">Комментарий:</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="comment" id="comment" rows="3" placeholder=""></textarea>
    </div>
  </div>   
  <button type="submit" class="btn btn-primary">Оформить заказ</button>
</form>