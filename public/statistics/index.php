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
                                        <option value="<?= $id ?>" <?php if (isset($statistics['errors']['formUsersStatistics']['entered_data']['user_id']) && $statistics['errors']['formUsersStatistics']['entered_data']['user_id'] == $id) print 'selected' ?>><?= $email ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($statistics['errors']['formUsersStatistics']['error'])) { ?><span class="text-danger"><?= $statistics['errors']['formUsersStatistics']['error']; ?></span><?php } ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Get user statistics</button>
                        </div>
                    </form>
                    <?php if (isset($statistics) && $statistics && !isset($statistics['errors'])) { ?>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Statistics for user <?= isset($statistics['user_email']) ? $statistics['user_email'] : '' ?> at the moment:</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total call duration (in seconds)</th>
                                    <th scope="col">Total cost of calls (in kopecks)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= date('Y.m.d h:i:s', time()) ?></td>
                                    <td><?= $statistics['quantity'] ?></td>
                                    <td><?= $statistics['total_duration'] ?></td>
                                    <td><?= $statistics['total_cost'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="/js/statisticsForm.js"></script>
</body>