<?php
require '../vendor/autoload.php';
include '../config/const.php';
require '../src/main.php';
require '../src/layouts/header.php';
?>

<body>
    <?php
    require '../src/layouts/navbar.php';
    ?>
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
                        <?php if (isset($_GET['page']) && isset($perPage)) {
                            $row = $i + 1 + (($_GET['page'] - 1) * $perPage);
                        } else {
                            $row = $i + 1;
                        }
                        ?>
                        <th scope="row"><?= $row ?></th>
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
    <script type="module" src="/js/loginForm.js"></script>
</body>

</html>