<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo $vars['modulelink'] ?>">Home</a></li>
    <li role="presentation"><a href="<?php echo $vars['modulelink'] . '&action=log' ?>">Log</a></li>
</ul>


<form action="">
    <input type="hidden" name="module" value="amir_module">

    <div class="form-group">
        <label for="amount">Massege:</label>
        <textarea type="text" name="massege" class="form-control" id="amount"></textarea>    </div>


    <div class="form-group">
        <label for="pwd">Select All users :</label>
        <input type="checkbox" id="checkbox"  class="checkbox btn inline">
            <select class="js-example-basic-multiple form-control" id="e1" name="user[]" multiple="multiple">
            <?php foreach ($users as $client) { ?>
                    <option value="<?php echo $client['id']?>"class="option" ><?php echo "ID:" . $client['id'] . "__Name:" . $client['firstname'] . "__Email:" . $client['email'] ?></option>
            <?php } ?>
        </select>

        </select>
    </div>


    <button type="submit" class="btn btn-default justify-content-center btn-success">Send</button>

</form>
<br>
<hr>

</table>

</div>


<div class="container">
    <th><input type="text" onkeyup="myFunction()" id="search" placeholder="search email"></th>

    <table class="table table-striped" id="myTable">
        <thead>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>id</th>
            <th>message</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $client) {
            ?>
            <tr>
                <td><?php echo $client['firstname'] ?></td>
                <td><?php echo $client['lastname'] ?></td>
                <td><?php echo $client['email'] ?></td>
                <td><?php echo $client['id'] ?></td>
                <form action="<?php echo $vars['modulelink'] . '&action=log' ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $client['id'] ?>">
                    <td><textarea name="message"></textarea></td>
                    <td><input type="submit" value="create"></td>
                </form>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
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

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $(document).ready(function() {
        $("#checkbox").click(function(){
            if($("#checkbox").is(':checked') ){ //select all
                $("#e1").find('option').prop("selected",true);
                $("#e1").trigger('change');
            } else { //deselect all
                $("#e1").find('option').prop("selected",false);
                $("#e1").trigger('change');
            }
        });
    });
</script>

