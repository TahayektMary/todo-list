<header>
    <nav class="nav-bar">
        <div class="left">
            <i class="fas fa-check-double"></i>
            <span class="app-title">My To-Do</span>
        </div>
        
        <div class="right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>
                        <?php 
                        if (isset($_SESSION['nom'])) {
                            echo htmlspecialchars($_SESSION['nom']);
                        } elseif (isset($_SESSION['email'])) {
                            echo htmlspecialchars($_SESSION['email']);
                        } else {
                            echo "Utilisateur";
                        }
                        ?>
                    </span>
                    <a href="auth/logout.php" class="btn logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="auth/login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                <a href="auth/register.php" class="btn register"><i class="fas fa-user-plus"></i> Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
