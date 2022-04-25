


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
            <th>biennially</th>
            <th>triennially</th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$data item=foo}

       
        <tr>
            <td>{$foo.id_tblpricing}</td>
            <td>{$foo->id_tblproducts}</td>
            <td>{$foo->name}</td>
            <td>{$foo->name_tblproductgroups}</td>
            <td>{$foo->name_tblcurrencies}</td>
            <td>{$foo->type_tblpricing}</td>
            <td>{$foo->type_tblproducts}</td>
            <td>{$foo->msetupfee}</td>
            <td>{$foo->qsetupfee}</td>
            <td>{$foo->ssetupfee}</td>
            <td>{$foo->asetupfee}</td>
            <td>{$foo->bsetupfee}</td>
            <td>{$foo->tsetupfee}</td>
            <td>{$foo->monthly}</td>
            <td>{$foo->quarterly}</td>
            <td>{$foo->semiannually}</td>
            <td>{$foo->annually}</td>
            <td>{$foo->biennially}</td>
            <td>{$foo->triennially}</td>
        </tr>

        {/foreach}
        </tbody>

    </table> <hr>

</div>



