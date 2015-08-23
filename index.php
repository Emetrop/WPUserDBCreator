<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>WordPress Database User Generator</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen" />
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>WordPress Database User Generator</h1>
            <p>This tool supposed to be a great tool if you need to login into a WordPress site where you don't have any account.
                Just run generated SQL code in your database and that's it! Now your new account is ready to login!</p>
            <hr>
            <form role="form" action="index.php" method="post" class="form-horizontal">
                <input hidden name="submit" value="1">
                <div class="form-group">
                    <label for="login" class="col-sm-3 control-label">Login:</label>
                    <div class="col-sm-9">
                        <input type="text" id="login" class="form-control" name="login">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pass" class="col-sm-3 control-label">Password:</label>
                    <div class="col-sm-9">
                    <input type="text" id="pass" class="form-control" name="pass">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-9">
                    <input type="email" id="email" class="form-control" name="email" value="your@email.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-sm-3 control-label">User role:</label>
                    <div class="col-sm-9">
                    <select class="form-control" id="role" name="role">
                        <option value="administrator">Administrator</option>
                        <option value="editor">Editor</option>
                        <option value="author">Author</option>
                        <option value="contributor">Contributor</option>
                        <option value="subscriber">Subscriber</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="id" class="col-sm-3 control-label">User ID:</label>
                    <div class="col-sm-9">
                    <input type="number" id="id" class="form-control" name="id" value="9999">
                    </div>
                </div>
                <div class="form-group">
                    <label for="prefix" class="col-sm-3 control-label">Table prefix:</label>
                    <div class="col-sm-9">
                    <input type="text" id="prefix" class="form-control" name="prefix" value="wp_">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary center-block">Generate SQL</button>
            </form>
            <hr>
        </div>

        <?php
        if( ! empty( $_POST['submit'] ) ) :
            require 'PasswordHash.php';

            $hasher = new PasswordHash( 8, true );
            $hashedPass = $hasher->HashPassword( $_POST['pass'] );
        ?>
        <div class="col-sm-12">
<pre>
INSERT INTO <?php echo $_POST['prefix'] ?>users (ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name) VALUES
(<?php echo $_POST['id'] ?>, '<?php echo $_POST['login'] ?>', '<?php echo $hashedPass ?>', '<?php echo $_POST['login'] ?>', '<?php echo $_POST['email'] ?>', '', '<?php echo date( 'Y-m-d H:i:s' ) ?>', '', 0, '<?php echo $_POST['login'] ?>');

INSERT INTO <?php echo $_POST['prefix'] ?>usermeta (user_id, meta_key, meta_value) VALUES
(<?php echo $_POST['id'] ?>, 'nickname', '<?php echo $_POST['login'] ?>'),
(<?php echo $_POST['id'] ?>, 'first_name', ''),
(<?php echo $_POST['id'] ?>, 'last_name', ''),
(<?php echo $_POST['id'] ?>, 'description', ''),
(<?php echo $_POST['id'] ?>, 'rich_editing', 'true'),
(<?php echo $_POST['id'] ?>, 'comment_shortcuts', 'false'),
(<?php echo $_POST['id'] ?>, 'admin_color', 'fresh'),
(<?php echo $_POST['id'] ?>, 'use_ssl', '0'),
(<?php echo $_POST['id'] ?>, 'show_admin_bar_front', 'true'),
(<?php echo $_POST['id'] ?>, '<?php echo $_POST['prefix'] ?>capabilities', 'a:1:{s:<?php echo strlen( $_POST['role'] ) ?>:"<?php echo $_POST['role'] ?>";b:1;}'),
(<?php echo $_POST['id'] ?>, '<?php echo $_POST['prefix'] ?>user_level', '10'),
(<?php echo $_POST['id'] ?>, 'dismissed_wp_pointers', 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets'),
(<?php echo $_POST['id'] ?>, 'show_welcome_panel', '1');
</pre>
            <hr>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>