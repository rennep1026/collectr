<div class="container">
    <div class="cr-bucket col-lg-7">
        <h1>Login</h1>
        <p>Login using your Collectr user info</p>
        <?php if(isset($_GET['err'])): ?>

            <div class="alert alert-danger" role="alert">
                <?php if($_GET['err']=='invalid'){
                    echo "Either the username/email or password was invalid. Please check your inputs and try again";
                }?>
            </div>

        <?php endif; ?>
        <form method="post" action="userLogin.php">
        <input type="hidden" name="submitted">
            <div class="form-group">
                <input class="form-control input-lg" type="input" id="userName" name="userName"
                       placeholder="Username or Email">
            </div>
            <div class="form-group">
                <input class="form-control input-lg" type="password" id="userPassword" name="userPassword"
                       placeholder="Password">
            </div>
            <div class="form-group">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Login">
            </div>
            <div class="form-group">
                <a href="register" class="btn btn-default btn-lg btn-block" type="button" action="register">
                    Register to join Collectr</a>
            </div>
        </form>
    </div>
</div>