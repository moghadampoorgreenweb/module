<?php

use Illuminate\Database\Capsule\Manager as Capsule;


if (isset($_POST['status']) && !empty($_POST['status']) && is_numeric($_POST['status']) && $_POST['status'] == 1 || $_POST['status'] == 0) {
    Capsule::table('phone')->where('id', 1)->update([
        'is_active' => $_POST['status'],
    ]);
}


$data = Capsule::table('phone')->first();

switch (true) {
    case   $data->is_active == 0:
        echo '<h1>'.'this mudole is: Deactive'.'</h1>', '<br>';
        break;
    case   $data->is_active == 1:
        echo '<h1>'.'this mudole is: Active'.'</h1>', '<br>';
        break;
}

?>



        <tr>
            <form action="addonmodules.php?module=phone_verify" method="post">
                <label class="form-check-label" for="flexRadioDefault2">Active</label>
                <input class="form-check-input" type="radio" name="status" value="1"  <?php echo $data->is_active == 1 ?'checked':'' ; ?>>
                <br>
                <label class="form-check-label" for="flexRadioDefault2">Deactive</label>
                <input class="form-check-input" type="radio" name="status" value="0" <?php echo $data->is_active == 0 ?'checked':'' ; ?> >
                <br>
                <input class=" btn btn-info" type="submit" name="apply" value="apply"  >
            </form>








