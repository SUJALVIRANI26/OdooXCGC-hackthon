<?php
$category = new Category();
$categories = $category->getAll();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket = new Ticket();
    
    $attachment_path = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_extension = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_extension;
        $attachment_path = $upload_dir . $filename;
        
        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment_path)) {
            $attachment_path = null;
            $error = 'Failed to upload attachment';
        }
    }
    
    if (empty($error)) {
        $result = $ticket->create(
            $_POST['title'],
            $_POST['description'],
            $_POST['category_id'],
            $_SESSION['user_id'],
            $_POST['priority'],
            $attachment_path
        );
        
        if ($result['success']) {
            header('Location: index.php?page=ticket-detail&id=' . $result['ticket_id']);
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-plus me-2"></i>Create New Ticket
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=create-ticket" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>" 
                               required maxlength="200">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" 
                                                <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="low" <?= (isset($_POST['priority']) && $_POST['priority'] === 'low') ? 'selected' : '' ?>>Low</option>
                                    <option value="medium" <?= (!isset($_POST['priority']) || $_POST['priority'] === 'medium') ? 'selected' : '' ?>>Medium</option>
                                    <option value="high" <?= (isset($_POST['priority']) && $_POST['priority'] === 'high') ? 'selected' : '' ?>>High</option>
                                    <option value="urgent" <?= (isset($_POST['priority']) && $_POST['priority'] === 'urgent') ? 'selected' : '' ?>>Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="6" required 
                                  placeholder="Please describe your issue in detail..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment (Optional)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment" 
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt">
                        <div class="form-text">Maximum file size: 5MB. Allowed formats: JPG, PNG, GIF, PDF, DOC, DOCX, TXT</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?page=tickets" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Tickets
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tips for Better Support</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Be specific and descriptive in your title
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Include steps to reproduce the issue
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Attach relevant screenshots or files
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Choose the appropriate category and priority
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        Provide your system/browser information if relevant
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
