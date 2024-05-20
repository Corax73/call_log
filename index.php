<?php
require 'vendor/autoload.php';
session_start();
include 'config/const.php';
require 'src/main.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>Call log</title>
</head>

<body>
    <!-- Navigation -->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                        <?php if (isset($_SESSION['email'])) { ?>
                            <a class="nav-link" href="#">Editing</a>
                        <?php } ?>
                        <a class="nav-link" href="https://github.com/Corax73">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                            </svg>
                        </a>
                    </div>
                    <?php if (isset($_SESSION['email'])) { ?>
                        <span class="nav-link">Welcome, <?= $_SESSION['email']; ?></span>
                    <?php } ?>

                </div>
            </div>
        </nav>
        <div class="col">
            <?php if (!isset($_SESSION['email'])) { ?>
                <button class="btn btn-primary" id="loginBtn">
                    Login
                </button>
            <?php } ?>
            <form id="formLogin" class="row gx-3 gy-2 align-items-center" method="POST">
                <div class="col-sm-3">
                    <label class="visually-hidden" for="specificSizeInputLogin">Email</label>
                    <input type="text" name="email" class="form-control" id="specificSizeInputLogin" placeholder="Email">
                </div>
                <div class="col-sm-3">
                    <label for="exampleInputForLogin" class="form-label">Password</label>
                    <input type="password" name="passwordForLogin" class="form-control" id="exampleInputForLogin">
                </div>
                <div class="col-auto">
                    <?php if (isset($error['auth'])) {
                        echo $error['auth'];
                    } ?>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
        <div class="col">
            <?php if (isset($_SESSION['email'])) { ?>
                <form method="POST">
                    <input type="hidden" name="logout" value="<?= $_SESSION['email']; ?>" />
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            <?php } ?>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Dialed user</th>
                    <th scope="col">Call start time</th>
                    <th scope="col">Call end time</th>
                    <th scope="col">Call duration (in seconds)</th>
                    <th scope="col">Call cost (in kopecks)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($calls) { ?>
                    <?php for ($i = 0; $i < count($calls); $i++) { ?>
                        <tr>
                            <th scope="row"><?= $i + 1 ?></th>
                            <td><?= $calls[$i]['user'] ?></td>
                            <td><?= $calls[$i]['dialed_user'] ?></td>
                            <td><?= $calls[$i]['call_start_time'] ?></td>
                            <td><?= $calls[$i]['call_end_time'] ?></td>
                            <td><?= $calls[$i]['duration'] ?></td>
                            <td><?= $calls[$i]['call_cost'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <?php if (isset($countPages)) { ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if (isset($_GET['page']) && $_GET['page'] > 1) { ?>
                        <li class="page-item"><a class="page-link" href="/?page=<?= $_GET['page'] - 1 ?>">Previous</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $countPages; $i++) { ?>
                        <li class="page-item"><a class="page-link" href="/?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
                    <?php if (isset($_GET['page']) && $_GET['page'] < $countPages) { ?>
                        <li class="page-item"><a class="page-link" href="/?page=<?= $_GET['page'] + 1 ?>">Next</a></li>
                    <?php } ?>
                </ul>
            </nav>
        <?php } ?>
    </div>
    <script src=" /js/form.js"></script>
</body>

</html>