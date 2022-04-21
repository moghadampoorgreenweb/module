
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo $vars['modulelink']?>">Update</a></li>

</ul>
<br>
<div  >


    <form action="">
        <input type="hidden" name="module" value="product_update_payment_period">
        <div class="form-group">
            <label for="pwd">Operation:</label>
            <select name="operation" id="" class="mce-selectbox form-control mb-5 "  style="width: 100%" >
                <option value="Percent" class="option" >Percent</option>
                <option value="Total" class="option" >Total</option>
            </select>
        </div>
        <div class="form-group">
                <label for="amount">Price increase :</label>
            <input type="text" name="amount" class="form-control" id="amount">
        </div>
        <div class="form-group">
            <label for="pwd">Price cycle:</label>
            <select name="cycle" id="" class="mce-selectbox form-control mb-5 "  style="width: 100%" multiple>
                <option value="monthly" class="option" >monthly</option>
                <option value="quarterly" class="option" >quarterly</option>
                <option value="semiannually" class="option" >semiannually</option>
                <option value="annually" class="option" >annually</option>
                <option value="biennially" class="option" >biennially</option>
                <option value="triennially" class="option" >triennially</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pwd">Product (optional):</label>
            <select name="product" id="" class="mce-selectbox form-control mb-5 "  style="width: 100%" multiple>
                <?php
                $data->each(function ($item){
                    echo "
                      <option value=\"$item->id_tblproducts\" class=\"option\" >$item->id_tblpricing .$item->name .$item->name_tblproductgroups </option>
                    ";
                });
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pwd">Currency:</label>
            <select name="currency" id="" class="mce-selectbox form-control mb-5 "  style="width: 100%" multiple>
                <?php
                $currency->each(function ($item){
                    echo "
                      <option value=\"$item->id\" class=\"option\" >$item->id . $item->code </option>
                    ";
                });
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="pwd">Group:</label>
            <select name="group" id="" class="mce-selectbox form-control"  style="width: 100%" multiple>
                <?php
                $group->each(function ($item){
                    echo "
                      <option value=\"$item->id\" class=\"option\" >$item->id . $item->name Group</option>
                    ";
                });
                ?>


            </select>

        </div>
        <button type="submit"  class="btn btn-default justify-content-center btn-success">Apply</button>

    </form>
<br>
<hr>
    <table style="" class="table table-responsive">
        <thead>
        <tr class="">
            <th>Id Picing</th>
            <th>Id Products</th>
            <th>P Name</th>
            <th>G Name</th>
            <th>Currency</th>
            <th>Type Tblpricing</th>
            <th>Type Tblproducts</th>
            <th>Msetupfee</th>
            <th>Qsetupfee</th>
            <th>ssetupfee</th>
            <th>asetupfee</th>
            <th>bsetupfee</th>
            <th>bsetupfee</th>
            <th>monthly</th>
            <th>quarterly</th>
            <th>semiannually</th>
            <th>annually</th>
            <th>triennially</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $items) { ?>
            <tr>
                <td><?php echo $items->id_tblpricing ?></td>
                <td><?php echo $items->id_tblproducts ?></td>
                <td><?php echo $items->name ?></td>
                <td><?php echo $items->name_tblproductgroups ?></td>
                <td><?php echo $items->name_tblcurrencies?></td>
                <td><?php echo $items->type_tblpricing ?></td>
                <td><?php echo $items->type_tblproducts ?></td>
                <td><?php echo $items->msetupfee ?></td>
                <td><?php echo $items->qsetupfee?></td>
                <td><?php echo $items->ssetupfee?></td>
                <td><?php echo $items->asetupfee?></td>
                <td><?php echo $items->bsetupfee?></td>
                <td><?php echo $items->tsetupfee?></td>
                <td><?php echo $items->monthly?></td>
                <td><?php echo $items->quarterly?></td>
                <td><?php echo $items->semiannually?></td>
                <td><?php echo $items->annually?></td>
                <td><?php echo $items->biennially?></td>
                <td><?php echo $items->triennially?></td>
            </tr>
        <?php } ?>
        </tbody>

    </table> <hr>

</div>



