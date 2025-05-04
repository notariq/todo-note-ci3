<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
?>

<?php
    $statusClasses = [
        'Finished' => 'bg-success text-white',
        'Pending' => 'bg-danger text-white',
        'Ongoing' => 'bg-warning text-white'
    ];
    $bgClass = $statusClasses[$task['status']] ?? '';
?>

<div class="d-flex justify-content-between align-items-center px-2 py-4 mx-4 border-bottom">
    <a href="<?= site_url('/') ?>" class="btn btn-secondary d-inline-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Back</span>
    </a>
    <p class="m-0 fs-3 fw-bold">To Do.</p>
</div>

<div class="p-4 mt-4 container">
    <!-- Task Information -->
    <div class="border-bottom mb-4">
        <form action="<?= site_url('task/update_info/'.$task['id']) ?>" enctype="multipart/form-data" method="post">

            <div class="mb-5 d-flex justify-content-between align-items-center gap-4">
                <input type="text" name="title" class="form-control fs-1 fw-bolder border-0 p-0" 
                style="background: transparent;" 
                value="<?= $task['title'] ?>" 
                onblur="this.form.submit()" onclick="event.stopPropagation();">

                <select name="status" class="form-select <?= $bgClass ?>" style="width: 150px" onchange="this.form.submit()" onclick="event.stopPropagation();">
                    <option value="Pending" <?= $task['status'] == 'Pending' ? 'selected' : '' ?> class='bg-danger'>Pending</option>
                    <option value="Ongoing" <?= $task['status'] == 'Ongoing' ? 'selected' : '' ?> class='bg-warning'>Ongoing</option>
                    <option value="Finished" <?= $task['status'] == 'Finished' ? 'selected' : '' ?> class='bg-success'>Finished</option>
                </select>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6 mb-3">
                    <label for="created_at" class="form-label"><strong>Created At:</strong></label>
                    <p class="form-control-plaintext m-0"><?= date('Y-m-d', strtotime($task['created_at'])) ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="deadline" class="form-label"><strong>Deadline:</strong></label>
                    <input type="date" id="deadline" name="deadline" class="form-control" 
                        value="<?= date('Y-m-d', strtotime($task['deadline'])) ?>" 
                        onchange="this.form.submit()" onclick="event.stopPropagation();">
                </div>
            </div>

        </form>
    </div>
    
    <!-- Task Images -->
    <div class="mb-4">
        <?php if (!empty($task['image_path'])): ?>
            <div class="position-relative text-center mb-3">

                <img src="<?= site_url($task['image_path']) ?>" alt="Task Image" 
                    class="img-fluid mb-3" 
                    style="max-width: 400px; max-height: 400px; object-fit: cover; border-radius: 8px;">

                <div class="d-flex gap-2 position-absolute top-0 end-0">
                    <form action="<?= site_url('upload_image/' . $task['id']) ?>>" method="post" enctype="multipart/form-data">
                        <input type="file" name="task_image" id="task_image" accept="image/*" class="d-none" onchange="this.form.submit()">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('task_image').click()">
                            <i class="bi bi-image"></i> Replace Image
                        </button>
                    </form>
                    <a 
                    href="<?= site_url('delete_image/'.$task['id']) ?>" 
                    class="btn btn-outline-danger btn-sm" 
                    onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this image?')"
                    >
                        <i class="bi bi-trash"></i> Delete Image
                    </a>
                </div>
            </div>

        <?php else: ?>

            <!-- Upload form when no image exists -->
            <form action="<?= site_url('upload_image/' . $task['id']) ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="task_image" id="task_image_upload" accept="image/*" class="d-none" onchange="this.form.submit()">
                <button id="add-image-btn" type="button" class="btn btn-outline-secondary w-100 py-5" 
                onclick="document.getElementById('task_image_upload').click()">
                <i class="bi bi-image"></i> Add Image
                </button>
            </form>

        <?php endif; ?>
    </div>

    <!-- Task Description -->
    <form id="description-form" action="<?= site_url('update_description/'.$task['id']) ?>" method="post" enctype="multipart/form-data">

        <div id="description-content" class="mb-4">
            <div id="editor-content">
                <p><?= $task['description'] ?></p>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="button" id="add-paragraph-btn" class="btn btn-outline-secondary">
                <i class="bi bi-paragraph"></i> Add Paragraph
            </button>
            <button id="submit-btn" type="submit" class="btn btn-success ms-auto" style="display: block;">
                <i class="bi bi-save"></i> Save Description
            </button>
        </div>
        
        
        <input type="hidden" name="description" id="description-hidden">

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Description
    const editorContent = document.getElementById('editor-content');
    const descriptionForm = document.getElementById('description-form');
    const descriptionHidden = document.getElementById('description-hidden');
    const addParagraphBtn = document.getElementById('add-paragraph-btn');

    // Make content editable
    editorContent.contentEditable = true;
    editorContent.className = 'p-2 rounded min-h-100';
    
    // Add paragraph button click
    addParagraphBtn.addEventListener('click', function() {
        const paragraph = document.createElement('p');
        paragraph.setAttribute('contenteditable', 'true');
        paragraph.className = 'editable-paragraph';
        paragraph.innerHTML = '<br>';

        editorContent.appendChild(paragraph);

        const selection = window.getSelection();
        const range = document.createRange();
        range.selectNodeContents(paragraph);
        range.collapse(false);
        selection.removeAllRanges();
        selection.addRange(range);
        paragraph.focus();
    });

    // Form submit handler
    descriptionForm.addEventListener('submit', function(e) {
        // Copy the HTML content to the hidden input
        descriptionHidden.value = editorContent.innerHTML;
    });
});
</script>