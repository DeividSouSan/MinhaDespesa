<header class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">
            <?php echo htmlspecialchars($_SESSION['Username']); ?>
        </span>
        <div class="d-flex">
            <a href="/logout" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </div>
</header>
