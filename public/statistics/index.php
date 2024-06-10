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
                                        <option value="<?= $id ?>" <?php if (isset($errors['errors']['formUsersStatistics']['entered_data']['user_id']) && $errors['errors']['formUsersStatistics']['entered_data']['user_id'] == $id) print 'selected' ?>><?= $email ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Get user statistics</button>
                        </div>
                    </form>
                    <?php if(isset($statistics) && $statistics) { ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Quantity</th>
                                <th scope="col">Number of outgoing calls</th>
                                <th scope="col">Number of incoming calls</th>
                                <th scope="col">Outgoing call time (in seconds)</th>
                                <th scope="col">Time of incoming calls (in seconds)</th>
                                <th scope="col">Amount of money spent (in kopecks)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($statistics) && $statistics) { ?>
                                <?php for ($i = 0; $i < count($statistics); $i++) { ?>
                                    <tr>
                                        <td><?= $statistics['quantity'] ?></td>
                                        <td><?= $statistics['quantity'] ?></td>
                                        <td><?= $statistics['quantity'] ?></td>
                                        <td><?= $statistics['quantity'] ?></td>
                                        <td><?= $statistics['quantity'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="/js/statisticsForm.js"></script>
</body>