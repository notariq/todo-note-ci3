<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="container">
    <p class="text-center text-bold fs-1 fw-bold my-4">To Do.</p>
    <div class="d-flex justify-content-between mb-3">
        <a href="<?= site_url('create') ?>" class="btn btn-success">Add New Task</a>
        <form method="post" action="<?= site_url() ?>" class="text-center">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="" disabled selected>- Sort by -</option>
                <option value="1">Deadline Des.</option>
                <option value="2">Deadline Asc.</option>
                <option value="3">Time Created Des.</option>
                <option value="4">Time Created Asc.</option>
                <option value="5">Status</option>
            </select>
        </form>
    </div>
    <table class="table table-hover table-sm align-middle w-100">
        <caption>click the task row for detail</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Deadline</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($tasks as $t): ?>
                <tr class="clickable-row cursor-pointer" data-href="<?= site_url('detail/'.$t['id']) ?>">
                    <th scope="row"><?= $i++ ?></th>
                    <td><?= $t['title'] ?></td>
                    <td><?= $t['created_at'] ?></td>
                    <td><?= $t['deadline'] ?></td>
                    <td>
                        <form method="post" action="<?= site_url('update/'.$t['id']) ?>">
                            <select name="status" class="form-select" style="width: 75%" onchange="this.form.submit()" onclick="event.stopPropagation();">
                                <option value="Pending" <?= $t['status'] == 'Pending' ? 'selected' : '' ?>>🟥 Pending</option>
                                <option value="Ongoing" <?= $t['status'] == 'Ongoing' ? 'selected' : '' ?>>🟨 Ongoing</option>
                                <option value="Finished" <?= $t['status'] == 'Finished' ? 'selected' : '' ?>>🟩 Finished</option>
                            </select>
                        </form>
                    </td>
                    <td style="width: 100px">
                        <a 
                            href="<?= site_url('delete/'.$t['id']) ?>" 
                            class="btn btn-danger btn-sm bi bi-trash" 
                            onclick="event.stopPropagation(); return confirm('Delete this task?')"
                        >
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>