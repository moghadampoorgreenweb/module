<p dir="rtl">
    تنها افرادی در این لیست هستند که یک سرویس فعال در <b><?= $name; ?></b> دارند.
</p>
<div class="form_item">
    <label for="search">
        جستجو محصول:
    </label>
    <input onkeyup="myFunction()" name="s" type="text" id="search" placeholder="جستجو">
    <a href="<?= MODULE_URL ?>&action=customers/export&pid=<?= $pid; ?>" target="_blank" class="exportFile">
        خروجی شماره ها
        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
    </a>
</div>
<table id="myTable" class="table table-striped productList">
    <thead>
    <tr>
<!--        <th>#</th>-->
        <th>مشتری</th>
        <th>شماه همراه</th>
        <th>دیگر جزئیات</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($results){
        $i = 1;
        $arr = array();
        foreach ($results as $item){
            if (!in_array($item->userid,$arr)){
    ?>
            <tr>
<!--                <td scope="row">-->
<!--                    --><?//= $i; ?>
<!--                </td>-->
                <td>
                    <?=
                    $item->firstname . ' ' . $item->lastname;
                    ?>
                </td>
                <td style="text-align: right;direction: ltr;">
                    <?php
                    if ($item->address2){
                        echo $item->address2;
                    } elseif ($item->value){
                        echo $item->value;
                    } else {
                        echo 'بدون شماره';
                    }
                    ?>
                </td>
                <td>بدون اطلاعات</td>
            </tr>
    <?php
            }
            $arr[] = $item->userid;
            $i++;
        }
    }
    ?>
    </tbody>
</table>