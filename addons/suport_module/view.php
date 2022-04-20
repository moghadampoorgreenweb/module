
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<?php
include_once __DIR__ . '/Models/Model.php';
$model = new Model();

$data=$model->tiketWhere($vars['ticketid']);

file_put_contents(__DIR__.'/txt.txt',json_encode($data->status_user));

$Upset_user=$data->status_user=='Upset_user'?'selected':'';
$Normal_user=$data->status_user=='Normal_user'?'selected':'';
$Technical_user=$data->status_user=='Technical_user'?'selected':'';
$User_half=$data->status_user=='User_half'?'selected':'';
echo "
<div class='alert alert-info' role='alert'>
    User Status:
    <select name='select' id='select'  class='dropdown'>
        <option value='0' >----none----</option>
        <option value='Upset_user'   $Upset_user  >Upset_user</option>
        <option value='Normal_user'  $Normal_user  >Normal_user</option>
        <option value='Technical_user' $Technical_user >Technical_user</option>
        <option value='User_half' $User_half>User_half</option>
    </select>
</div>
";

?>

<script>
    $('#select').change(function () {
        $.ajax({
            url: "supporttickets.php?action=viewticket&id=<?php echo $vars['ticketid'];?>",
            type: 'POST',
            data: {
                ticketId : <?php echo $vars['ticketid'];?>,
                selectBox : $('#select').val(),
            },
        });
    });
</script>