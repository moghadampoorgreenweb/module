<h2><b>Usage</b></h2>

<table class="table table-dark">
    <thead>
    <tr>
        <th scope="col"></th>
        <th scope="col">Username:</th>
        <th scope="col">{$username}</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Password:</th>
        <td>{$password}</td>
        <th scope="col"></th>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Bandwidth:</th>
        <td>{$bandwidth}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Domain:</th>
        <td>{$domain}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Status:</th>
        <td>{$status}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Mysql:</th>
        <td>{$mysql}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Emails:</th>
        <td>{$nemails}</td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th scope="col"></th>
        <th scope="row">Ftp:</th>
        <td>{$ftp}</td>
    </tr>
    </tbody>
</table>

<form name="submitform" method="post" action="clientarea.php?action=productdetails">
    <input type="hidden" name="id" value="{$serviceid}" />
    <input type="hidden" name="modop" value="custom" />
    <input type="hidden" name="a" value="reboot" />
</form>

<script>
    $('a:contains("RebootServer")').click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Reboot it!'
        }).then((result) => {
            if (result.isConfirmed) {

                document.submitform.submit();
                Swal.fire(
                    'Reboot!',
                    'Your server has been Reboot.',
                    'success'
                )
            }
        });
        //event.preventDefault();
    });
</script>