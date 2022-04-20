<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo $vars['modulelink'] ?>">Tag</a></li>

</ul>
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Full Name</th>
            <th>email</th>
            <th>Title</th>
            <th>Phonenumber</th>
            <th>status user</th>
            <th>deparment name</th>
            <th>date</th>
            <th>detailes</th>
            <th>
                <form action="addonmodules.php" method="get">
                    <input type="hidden" name="module" value="suport_module">
                    <input type="text" name="status">
                    <input type="submit" value="filter">
                </form>
            </th>
        </tr>
        </thead>
        <tbody>



        <?php


        collect($allflags)->each(function ($items){ ?>
        <tr>
            <td><?php echo $items->firstname . ' ' . $items->lastname ?></td>
            <td><?php echo $items->email ?></td>
            <td><?php echo $items->title ?></td>
            <td><?php echo $items->phonenumber ?></td>
            <td><?php echo $items->status_user ?></td>
            <td><?php echo $items->dpname ?></td>
            <td><?php echo \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', $items->date)
                ?></td>
            <td>
                <form action="supporttickets.php">
                    <input type="hidden" name="action" value="view">
                    <input type="hidden" name="id" value="<?php echo $items->tiket_id ?>">
                    <input type="submit" value="detailes">
                </form>
            </td>
        <tr>
            <?php });

            ?>
        </tbody>

    </table>

</div>
<nav aria-label="...">
    <ul class="pager">


        <?php

        if ($status == null && $status == false) {
            echo "
                   <form action=\"addonmodules.php\" style=\"display: inline\">
                        <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                        <input type=\"hidden\" name=\"page\" value=\"$next\">
                        <input type=\"submit\" class=\"btn btn-warning btn-info\" value=\"Next\">
                    </form>
                   ";
        } else {
            echo " 
                       <form action=\"addonmodules.php\" style=\"display: inline\">
                        <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                        <input type=\"hidden\" name=\"status\" value=\"{$_GET['status']}\">
                        <input type=\"hidden\" name=\"page\" value=\"$next\">
                        <input type=\"submit\" class=\"btn btn-warning btn-info\" value=\"Next\">
                    </form>
                   ";
        }

        ?>

        <?php
        while ($out >= 0) {

            if ($status == null && $status == false) {
                echo " <form action=\"addonmodules.php\" style=\"display: inline\">
                        <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                        <input type=\"hidden\" name=\"page\"  value='{$out}'>
                        <input type=\"submit\" class=\"btn btn-danger \" value=\"$out\">
                   </form>";
            } else {
                echo " <form action=\"addonmodules.php\" style=\"display: inline\">
                        <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                        <input type=\"hidden\" name=\"status\" value=\"{$_GET['status']}\">
                        <input type=\"hidden\" name=\"page\"  value='{$out}'>
                        <input type=\"submit\" class=\"btn btn-danger \" value=\"$out\">
                   </form>";
            }

            $out--;
        }
        ?>

        <?php

        if ($status == null && $status == false) {
            echo "
                  <form action=\"addonmodules.php\" style=\"display: inline\">
                    <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                    <input type=\"hidden\" name=\"page\" value=\"$previous\">
                    <input type=\"submit\" class=\"btn btn-info \" value=\"Previous\">
                </form>

                   ";
        } else {
            echo " 
                         <form action=\"addonmodules.php\" style=\"display: inline\">
                            <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                            <input type=\"hidden\" name=\"status\" value=\"{$_GET['status']}\">
                            <input type=\"hidden\" name=\"page\" value=\"$previous\">
                            <input type=\"submit\" class=\"btn btn-info \" value=\"Previous\">
                        </form>
                   ";
        }

        ?>


        <?php

        if ($status == null && $status == false) {
            echo "
                         <form action=\"addonmodules.php\" method=\"get\" style=\"display: inline\">
                            <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                            <input type=\"hidden\" name=\"page\"  value='{$_GET['page']}'>
                            <input type=\"hidden\" name=\"exportExel\" value=\"true\">
                            <input type=\"submit\" class=\"btn btn-action-2 mt-5\" value=\"exportExel\">
                        </form>
                   ";
        } else {
            echo " 
                     <form action=\"addonmodules.php\" method=\"get\" style=\"display: inline\">
                            <input type=\"hidden\" name=\"module\" value=\"suport_module\">
                            <input type=\"hidden\" name=\"status\" value=\"{$_GET['status']}\">
                            <input type=\"hidden\" name=\"page\"  value='{$_GET['page']}'>
                            <input type=\"hidden\" name=\"exportExel\" value=\"true\">
                            <input type=\"submit\" class=\"btn btn-action-2 mt-5\" value=\"exportExel\">
                        </form>
                   ";
        }
        echo "
  <form action=\"addonmodules.php\" method=\"post\" style=\"display: inline\" enctype='multipart/form-data'>
        <input type=\"hidden\" name=\"module\" value=\"suport_module\">
        <input type='file' name='import' style=\"display: inline\" class='btn btn-default '>                            
        <input type=\"hidden\" name=\"importExel\" value=\"true\">
        <input type=\"submit\" class=\"btn btn-action-2 mt-5\" value=\"import\">
        </form>
";

           if ($status == null && $status == false) {
               echo "
              <form action=\"addonmodules.php\" method=\"get\" style=\"display: inline\" enctype='multipart/form-data'>
                    <input type=\"hidden\" name=\"module\" value=\"suport_module\">                      
                    <input type=\"hidden\" name=\"pdfExport\" value=\"true\">
                    <input type=\"submit\" class=\"btn btn-action-2 mt-5\" value=\"pdfExport\">
                    </form>
            ";
           }else{
               echo " 
             <form action=\"addonmodules.php\" method=\"get\" style=\"display: inline\" enctype='multipart/form-data'>
               <input type=\"hidden\" name=\"status\" value=\"{$_GET['status']}\">
                    <input type=\"hidden\" name=\"module\" value=\"suport_module\">                      
                    <input type=\"hidden\" name=\"pdfExport\" value=\"true\">
                    <input type=\"submit\" class=\"btn btn-action-2 mt-5\" value=\"pdfExport\">
                    </form>
                   
                   ";
           }
        ?>

    </ul>
</nav>


<?php

use \Error\ErrorReport;


file_put_contents(__DIR__ . '/txt.txt', json_encode($_REQUEST));