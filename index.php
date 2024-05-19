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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <title>Call log</title>
</head>

<body>
    <!-- Navigation -->
    <div class="fixed-top">
        <header class="topbar">
            <div class="container">
                <div class="row">
                    <!-- social icon-->
                    <div class="col-sm-12">
                        <ul class="social-network">
                            <li><a class="fab fa-github fa-2x" style="color: #333333;" href="https://github.com/Corax73"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <li class="nav-item active">
                                <span class="nav-link">Welcome, <?= $_SESSION['email']; ?></span>
                            </li>
                        <?php } ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <?php if (isset($_SESSION['email'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Editing</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
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
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <script src="/js/form.js"></script>
</body>

</html>