<?php
use Illuminate\Database\Capsule\Manager as Capsule;
if (isset($_POST['message']) && !empty($_POST['message'])) {
    $command = 'SendEmail';
    $postData = array(
        'messagename' => 'Client Signup Email',
        'id' => '1',
        'customtype' => 'product',
        'customsubject' => 'Product Welcome Email',
        'custommessage' => '<p>Thank you for choosing us</p><p>Your custom is appreciated</p><p>{$custommerge}<br />{$custommerge2}</p>',
    );

    $results = localAPI($command, $postData);

    $results = localAPI('GetClientsDetails', ['clientid' => $_POST['user_id']]);

    $responce = Capsule::table('modulesmsnotify')->insert([
        'user_id' => $results['id'],
        'body' => $_POST['message'],
        'phone' => $results['phonenumber'],
        'status' => 'pending',
        'created_at' => date("Y-m-d H:i:s"),
    ]);
}
?>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo $vars['modulelink'] ?>">Home</a></li>
    <li role="presentation" class="active"><a href="<?php echo $vars['modulelink'] . '&action=log' ?>">Log</a></li>
    <li role="presentation"><a href="<?php echo $vars['modulelink'] . '&action=setting' ?>">Setting</a></li>
</ul>
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>userID</th>
            <th>Body</th>
            <th>Phone</th>
            <th>Status</th>
            <th>send</th>
        </tr>
        </thead>
        <tbody>
        <?php


        $obj= Capsule::table('modulesmsnotify')->get();

        $obj->each(function ($value,$key){ ?>
            <tr>
                <td><?php echo $value->id ?></td>
                <td><?php echo $value->user_id ?></td>
                <td><?php echo $value->body ?></td>
                <td><?php echo $value->phone ?></td>
                <td><?php echo $value->status ?></td>

                <form action="<?php echo $value->user_id.'&action=log'?>"  method="post">
                    <input type="hidden" name="user_id" value="<?php echo $value->user_id ?>">

                    <td><input type="submit" value="send-sms"></td>

                </form>
            </tr>
        <?php }); ?>
        </tbody>
    </table>
</div>
