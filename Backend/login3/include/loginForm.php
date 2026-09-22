    <?php
    function loginForm()
    {
        global $url;
    ?>
    <h1>Belépés</h1>
    <form action="<?php echo $url;?>" method="post">
        <label for="">Username: <input type="text" name="user"></label>
        <label for="">Password: <input type="password" name="pass"></label>
        <button type="submit">Belépés</button>
    </form>
    <?php
    }
    ?>