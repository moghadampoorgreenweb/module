<?php

namespace Error;
class ErrorReport
{
    private static $error;


    public static function setError($error)
    {
        self::$error = $error;
    }

    /**
     * @return mixed
     */
    public static function getError()
    {
        return self::handle(self::$error);
    }

    public static function error($error=false)
    {
        self::$error = $error;
    }

    public static function handle($bool=false)
    {
        if ($bool == false | empty($bool)) {

            return false;
        }

        echo "
        <script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: \"You won't be able to revert this!\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    })
    
    
    $('#qqqqqqqqqqq').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: \"addonmodules.php?module=suport_module\",
            type: 'GET',
            data: {
        page: 3
            },
        });
    });
$('#qqqqqqqqqqqqqqqqqqq').click(function (e) {
    e.preventDefault();
    $.ajax({
            url: \"addonmodules.php?module=suport_module\",
            type: 'GET',
            data: {
        page: 6
            },
        });
    });

</script>
        ";

    }

}