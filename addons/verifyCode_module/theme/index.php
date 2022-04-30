<div class="mainer"></div>
<div class="form_item">
    <label for="search">
        جستجو محصول:
    </label>
    <input onkeyup="myFunction()" name="s" type="text" id="search" placeholder="جستجو">
</div>
<table id="myTable" class="table table-striped productList">
    <thead>
    <tr>
        <th>#</th>
        <th>نام محصول</th>
        <th>گروه</th>
        <th>مشتریان</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($results as $item){
        ?>
        <tr>
            <th scope="row">
                <?= $i; ?>
            </th>
            <td>
                <?= $item->prName; ?>
            </td>
            <td>
                <?= $item->gpName; ?>
            </td>
            <td>
                <a href="<?= MODULE_URL . '&action=customers&pid=' . $item->prId; ?>">
                    مشاهده مشتریان
                </a>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </tbody>
</table>