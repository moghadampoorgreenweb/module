
<div class="providerLinkingFeedback"></div>

<form method="post" action="" class="login-form" role="form">


    <div class="card mw-540 mb-md-4 mt-md-4">
        <div class="card-body px-sm-5 py-5"><h3 for="number" class="form-control-label">Login Form</h3>
            <div class="mb-4">
            </div>
            <div class="form-group">

                <label for="number" class="form-control-label">Enter Your Code:</label>
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>

                    <input type="text" class="form-control" name="number" id="inputEmail">
                </div>
            </div>
            <div class="float-left">     <input type="submit" value="verify" class="form-control btn-info btn">
            </div>
        </div>

        <div class="card-footer px-md-5">
            <small>{lang key='userLogin.notRegistered'}</small>
            <a href="{$WEB_ROOT}/register.php" class="small font-weight-bold">{lang key='userLogin.createAccount'}</a>
        </div>
    </div>

</form>



