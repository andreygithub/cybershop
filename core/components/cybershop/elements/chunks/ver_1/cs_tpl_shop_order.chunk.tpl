<div class="form-horizontal cs_form" data-action="order/submit" id="cs_Order">
	<div class="row">
		<div class="span6">
			<h4>[[%cs_frontend_credentials]]:</h4>
			<div class="control-group">
				<label class="control-label" for="email">[[%cs_frontend_email]]</label>
				<div class="controls">
					<input type="text" id="email" placeholder="[[%cs_frontend_email]]" name="email" value="[[+email]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="receiver">[[%cs_frontend_receiver]]</label>
				<div class="controls">
					<input type="text" id="receiver" placeholder="[[%cs_frontend_receiver]]" name="receiver" value="[[+receiver]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="phone">[[%cs_frontend_phone]]</label>
				<div class="controls">
					<input type="text" id="phone" placeholder="[[%cs_frontend_phone]]" name="phone" value="[[+phone]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="comment">[[%cs_frontend_comment]]</label>
				<div class="controls">
					<textarea name="comment" id="comment" placeholder="[[%cs_frontend_comment]]">[[+comment]]</textarea>
				</div>
			</div>
		</div>
		<div class="span6">
			<h4>[[%cs_frontend_address]]:</h4>
			<div class="control-group">
				<label class="control-label" for="index">[[%cs_frontend_index]]</label>
				<div class="controls">
					<input type="text" id="index" placeholder="[[%cs_frontend_index]]" class="span2" name="index" value="[[+index]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="region">[[%cs_frontend_region]]</label>
				<div class="controls">
					<input type="text" id="region" placeholder="[[%cs_frontend_region]]" name="region" value="[[+region]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="city">[[%cs_frontend_city]]</label>
				<div class="controls">
					<input type="text" id="city" placeholder="[[%cs_frontend_city]]" name="city" value="[[+city]]" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="street">[[%cs_frontend_street]]</label>
				<div class="controls">
					<input type="text" id="street" placeholder="[[%cs_frontend_street]]" class="span2" name="street" value="[[+street]]" />
					<input type="text" id="building" placeholder="[[%cs_frontend_building]]" class="span1" name="building" value="[[+building]]" />
					<input type="text" id="room" placeholder="[[%cs_frontend_room]]" class="span1" name="room" value="[[+room]]" />
				</div>
			</div>
		</div>
	</div>
	<a href="#" data-action="order/clean" class="cs_link"><i class="icon-remove-sign"></i> [[%cs_frontend_order_cancel]]</a>
	<hr/>
	<div class="form-actions">
		<h3>[[%cs_frontend_order_cost]]: <span id="cs_order_cost">[[+order_cost:default=`0`]]</span> сом.</h3>
		<button  class="btn btn-primary cs_link" data-action="order/submit" id="orderSubmit">[[%cs_frontend_order_submit]]</button>
	</div>
</div>