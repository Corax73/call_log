<?php

require_once '../../src/statistics.php';
?>

<body>
    <div class="container">
        <div class="row row-cols-5">
            <div class="col">
                <div class="col-xs-4 col-md-6 col-lg-6">
                    <h3 class="panel-title">Users statistics</h3>
                </div>
                <div class="row row-cols-auto">
                    <div class="col">
                        <button class="btn btn-primary" id="usersStatisticsBtn">
                            Statistics form.
                        </button>
                    </div>
                    <form method="POST" id="formUsersStatistics">
                        <div class="form-group">
                            <input required type="hidden" name="entity" class="form-control" value="user">
                            <input required type="hidden" name="form" class="form-control" value="formUsersStatistics">
                            <label for="formGroupExampleInput">User</label>
                            <select name="user_id" class="form-select" aria-label="Default select example" required>
                                <option selected>Open this select menu</option>
                                <?php if (isset($users) && count($users) > 0) { ?>
                                    <?php foreach ($users as $email => $id) { ?>
                                        <option value="<?= $id ?>" <?php if (isset($errors['errors']['formPhone']['entered_data']['user_id']) && $errors['errors']['formPhone']['entered_data']['user_id'] == $id) print 'selected' ?>><?= $email ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($errors['errors']['formPhone'])) { ?><span class="text-danger"><?= $errors['errors']['formPhone']['error']; ?></span><?php } ?>
                        <?php if (isset($saved['formPhone']) && $saved['formPhone']) { ?>
                            <div class="alert alert-success" role="alert">
                                Phone number saved!
                            </div><?php } ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Get user statistics</button>
                        </div>
                    </form>
                    <table class="table" id="formUsersStatistics">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Number of outgoing calls</th>
                                <th scope="col">Number of incoming calls</th>
                                <th scope="col">Outgoing call time (in seconds)</th>
                                <th scope="col">Time of incoming calls (in seconds)</th>
                                <th scope="col">Amount of money spent (in kopecks)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($calls) && $calls) { ?>
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
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="/js/statisticsForm.js"></script>
</body>