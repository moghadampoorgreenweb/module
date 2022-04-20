
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo $vars['modulelink']?>">Home</a></li>
    <li role="presentation"><a href="<?php echo $vars['modulelink'].'&action=log'?>">Log</a></li>
    <li role="presentation"><a href="<?php echo $vars['modulelink'].'&action=setting'?>">Setting</a></li>
</ul>
<div class="container">
    <table class="table table-striped">
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
        <?php foreach ($users['clients']['client'] as $client) { ?>
            <tr>
                <td><?php echo $client['firstname'] ?></td>
                <td><?php echo $client['lastname'] ?></td>
                <td><?php echo $client['email'] ?></td>
                <td><?php echo $client['id'] ?></td>
               <form action="<?php echo $vars['modulelink'].'&action=log'?>"  method="post">
                <input type="hidden" name="user_id" value="<?php echo $client['id'] ?>">
                <td><textarea name="message"></textarea></td>
                <td><input type="submit" value="create"></td>

                    </form> <?php echo $client['id'] ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



