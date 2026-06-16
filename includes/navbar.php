<?php

?>
<nav class="navbar">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
        <a href="/index.php" class="navbar-brand">📚 Gestion Scolaire</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' && dirname($_SERVER['PHP_SELF']) === '/' ? 'active' : '' ?>">Accueil</a>
            </li>
            <li class="nav-item">
                <a href="/pages/eleves/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/eleves/') !== false ? 'active' : '' ?>">Élèves</a>
            </li>
            <li class="nav-item">
                <a href="/pages/enseignants/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/enseignants/') !== false ? 'active' : '' ?>">Enseignants</a>
            </li>
            <li class="nav-item">
                <a href="/pages/classes/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/classes/') !== false ? 'active' : '' ?>">Classes</a>
            </li>
            <li class="nav-item">
                <a href="/pages/matieres/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/matieres/') !== false ? 'active' : '' ?>">Matières</a>
            </li>
            <li class="nav-item">
                <a href="/pages/inscriptions/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/inscriptions/') !== false ? 'active' : '' ?>">Inscriptions</a>
            </li>
            <li class="nav-item">
                <a href="/pages/affectation/index.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], '/affectation/') !== false ? 'active' : '' ?>">Affectations</a>
            </li>
        </ul>
    </div>
</nav>                                                                      \a