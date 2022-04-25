
<form action="index.php">
    <input type="hidden" name="m" value="order_vm">
    <input type="hidden" name="orderResult" value="true">

    <div class="form-group">
        <label for="pwd">Region :</label>
        <select class="js-example-basic-multiple form-control" id="region" name="region">
            {foreach from=$region item=foo}
                <option value="{$foo['id']}">{$foo['name']}</option>
            {/foreach}
        </select>

    </div>
    <div class="form-group">
        <label for="pwd">Opratingsystem :</label>
        <select class="js-example-basic-multiple form-control" id="opratingsystem" name="opratingsystem">
            {foreach from=$opratingsystem item=foo}
                <option value="{$foo['id']}">{$foo['name']}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label for="pwd">Disk :</label>
        <select class="js-example-basic-multiple form-control" id="disk" name="disk">
            {foreach from=$space item=foo}
                <option value="{$foo['id']}">{$foo['name']}</option>
            {/foreach}
        </select>
    </div>

    <button type="submit" class="btn btn-default justify-content-center btn-success">Order</button>

</form>

<script>






    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

    $(document).ready(function () {
        $("#checkbox").click(function () {
            if ($("#checkbox").is(':checked')) { //select all
                $("#e1").find('option').prop("selected", true);
                $("#e1").trigger('change');
            } else { //deselect all
                $("#e1").find('option').prop("selected", false);
                $("#e1").trigger('change');
            }
        });
    });



</script>

