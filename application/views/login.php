<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #80817aff, #727466ff);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .login-box {
        width: 350px;
        padding: 30px;
        background: #ffffffcc; /* biroz shaffof oq fon */
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(53, 48, 48, 0.3);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    .login-box h2 {
        margin-bottom: 20px;
        color: #1e3d59;
    }

    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: 0.3s;
    }

    input[type=text]:focus, input[type=password]:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 5px rgba(30,144,255,0.5);
        outline: none;
    }

    input[type=submit] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #1e90ff;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    input[type=submit]:hover {
        background: #0d6efd;
    }

    .error {
        color: red;
        margin-bottom: 15px;
        font-weight: bold;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<body>
    <div class="login-box">
        <h3>Login</h3>

        <?php if($this->session->flashdata('error')): ?>
            <p class="error"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('index.php/login/auth') ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Parol" required>
            <input type="submit" value="Kirish">
        </form>
    </div>
</body>
</html>
