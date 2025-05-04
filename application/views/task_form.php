<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="p-4">
  <a href="<?= site_url('/') ?>" class="btn btn-secondary d-inline-flex align-items-center gap-2">
    <i class="bi bi-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<div class="container" style="max-width: 720px;">
  <div class="text-center mb-5">
    <h1 class="fw-bolder display-4">To Do.</h1>
    <p class="fs-5">Add a new task below.</p>
  </div>

  <form action="<?= site_url('store'); ?>" method="post" enctype="multipart/form-data">

    <div class="mb-4">
      <label for="title" class="form-label fw-bold">Task Title</label>
      <input name="title" id="title" type="text" class="form-control form-control-lg" placeholder="Enter your task title..." required>
    </div>

    <div class="mb-4">
      <label for="deadline" class="form-label fw-bold">Task Deadline</label>
      <input type="date" id="deadline" name="deadline" class="form-control form-control-lg" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary btn-lg">Create Task</button>
    </div>

  </form>
</div>
