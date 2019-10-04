<div class="header">
    <h2 class="header__title" onclick="toHome();">Narrowcast Admin Panel</h2>
    <div class="header__logout-container">
        <p class="username"><?=$_SESSION['username'];?></p>
        <button class="add-user-btn" onclick="toAddUser();">Voeg gebruiker toe</button>
        <button class="logout-btn" onclick="logOut();">Log Uit</button>
    </div>
</div>