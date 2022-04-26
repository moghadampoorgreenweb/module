<form action="index.php">
    <input type="hidden" name="m" value="order_vm">
    <input type="hidden" name="orderResult" value="true">

    <div class="form-group">
        <label for="pwd">Region :</label>
        <select class="js-example-basic-multiple form-control" id="region" name="region">
            <option class="none" value="">Select</option>
            {foreach from=$region item=foo}
                <option value="{$foo['id']}">{$foo['name']}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <label for="pwd">Opratingsystem :</label>
        <select class="js-example-basic-multiple form-control" id="opratingsystem" name="opratingsystem">
            <option class="none" value="">Select</option>
        </select>
    </div>

    <div class="form-group">
        <label for="pwd">Disk :</label>
        <select class="js-example-basic-multiple form-control" id="disk" name="disk">
            <option class="none" value="">Select</option>
        </select>
    </div>
    <div class="form-group">
        <label for="pwd">Plan :</label>
        <select class="js-example-basic-multiple form-control" id="plan" name="plan">
            <option class="none" value="">Select</option>
        </select>
    </div>

    <button type="submit" id="submit" class="btn btn-default justify-content-center btn-success">Order</button>

</form>

<script>


    $('#region').change(function () {

        $.ajax({
            url: "index.php?m=order_vm&action=region",
            cache: false,
            type: "GET",
            data: {
                region: $('#region').val()
            },
            success: function (result) {
                result = JSON.parse(result);
                $('#opratingsystem').empty();
                $('#opratingsystem').append("<option value=''>Select</option>");
                result.forEach(function (item) {
                    console.log(item.name);
                    $('#opratingsystem').append("<option value=" + item.id + " >" + item.name + "</option>");
                });
            }
        });
    });

    $('#opratingsystem').change(function () {
        $.ajax({
            url: "index.php?m=order_vm&action=os",
            cache: false,
            type: "GET",
            data: {
                region: $('#region').val(),
                opratingsystem: $('#opratingsystem').val()
            },
            success: function (result) {
                result = JSON.parse(result);
                $('#disk').empty();
                $('#disk').append("<option value=''>Select</option>");
                result.forEach(function (item) {
                    $('#disk').append("<option value=" + item.id + " >" + item.name + "</option>");
                });
            }
        });
    });
    $('#disk').change(function () {
        $.ajax({
            url: "index.php?m=order_vm&action=plan",
            cache: false,
            type: "GET",
            data: {
                region: $('#region').val(),
                opratingsystem: $('#opratingsystem').val(),
                disk: $('#disk').val()
            },
            success: function (result) {
                result = JSON.parse(result);
                $('#plan').empty();
                $('#plan').append("<option value=''>Select</option>");
                result.forEach(function (item) {
                    $('#plan').append("<option value=" + item.id + " >" + item.name + "</option>");
                });
            }
        });
    });


    $('#submit').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "index.php?m=order_vm&action=submit",
            cache: false,
            type: "POST",
            data: {
                region: $('#region').val(),
                opratingsystem: $('#opratingsystem').val(),
                disk: $('#disk').val(),
                plan: $('#plan').val(),
            },
            success: function (result) {
                result = JSON.parse(result);
            }
        });
    });


</script>

