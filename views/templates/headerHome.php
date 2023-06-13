

<header>
    <div class="banner">
        <div class="divLoginBtn">
            <div class="hello">
                <h3><?php if(isset($_SESSION["username"]) && $_SESSION["username"]) echo "Hello ".$_SESSION["username"] ?></h3>
            </div>
            <button class="loginBtn"><a href="index.php?action=homepage">Home</a></button>
            <button class="loginBtn"><a href="index.php?action=disconnect">disconnect</a></button>
        </div>
    </div>
</header>

