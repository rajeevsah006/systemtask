<!DOCTYPE html>
<html lang="en">

<head>

    <!------------------------------- meta start ------------------------------------------>
    <?php include 'include/common/meta.php'; ?>
    <!------------------------------- meta end -------------------------------------------->

    <title>SystemTask | Login</title>

    <!------------------------------- top_link start -------------------------------------->
    <?php include 'include/common/top_link.php'; ?>
    <!------------------------------- top_link end ---------------------------------------->

    <!------------------------------- meta start ------------------------------------------>
    <?php include 'include/common/config.php'; ?>
    <!------------------------------- meta end -------------------------------------------->
    <style type="text/css">
        html {
            background: none;
        }

        body {
            font-family: "Roboto", sans-serif;
            background-color: #f8fafb;
        }

        .main-wrapper {
            padding: 9rem 0;
        }

        form {
            margin: 1rem auto;
            border: solid 1px #dee2e6;
            padding: 1rem;
            border-radius: 0.25rem;
            background-color: #fff;
        }

        form {
            width: 400px;
        }

        .btn {
            height: 40px;
            padding-left: 30px;
            padding-right: 30px;
        }
    </style>
</head>

<body class="custom-scrollbar">

    <!------------------------------- loder start ----------------------------------------->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!------------------------------- loder end ------------------------------------------->

    <div class="main-wrapper">

        <!------------------------------- login start ----------------------------------------->
        <div class="container">
            <div class="row">
                <form class="form-horizontal" id="login-user" method="post" role="form" autocomplete="on" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="user_email">Email Id</label>
                        <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email-Id" maxlength="50">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="user_password">Password</label>
                        <input name="user_password" id="user_password" type="password" class="form-control" placeholder="Password" maxlength="20">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mt-4">
                        <button name="login_button" id="login_button" type="submit" class="btn btn-block btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp; Login Me</button>
                    </div>
                    <div class="form-group mt-4">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Not a member? <a href="register">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!------------------------------- login end ------------------------------------------->

    </div>

    <!------------------------------- bottom_link start ----------------------------------->
    <?php include 'include/common/bottom_link.php'; ?>
    <!------------------------------- bottom_link end ------------------------------------->

    <script type="text/javascript" src="assets/js/user.js"></script>

</body>

</html>