<form action="index.php">
    <input type="hidden" name="m" value="order_vm">
    <input type="hidden" name="orderResult" value="true">
    <input type="hidden" name="opratingsystem" value="{$get['opratingsystem']}">
    <input type="hidden" name="disk" value="{$get['disk']}">
    <input type="hidden" name="region" value="{$get['region']}">
    <input type="hidden" name="orderResult" value="true">

    <div class="form-group">
        <label for="pwd">Plan :</label>
        <select class="js-example-basic-multiple form-control" id="e1" name="plan">
            {foreach from=$plan item=foo}
                <option value="{$foo['id']}">{$foo['name']}___{$foo['descripion']}___{$foo['region']['name']}
                    ___{$foo['spase']['name']}___{$foo['opratingsystem']['name']}</option>
            {/foreach}
        </select>
    </div>

    <button type="submit" class="btn btn-default justify-content-center btn-success">Order</button>

</form>