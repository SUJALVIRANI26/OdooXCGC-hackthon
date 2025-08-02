<?php
// Admin only page
if ($_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Access denied.</div>';
    return;
}

$category_obj = new Category();
$categories = $category_obj->getAll();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_category'])) {
        $result = $category_obj->create($_POST['name'], $_POST['description'], $_POST['color']);
        if ($result['success']) {
            $success = $result['message'];
            // Refresh categories
            $categories = $category_obj->getAll();
        } else {
            $error = $result['message'];
        }
    } elseif (isset($_POST['update_category'])) {
        $result = $category_obj->update($_POST['category_id'], $_POST['name'], $_POST['description'], $_POST['color']);
        if ($result['success']) {
            $success = $result['message'];
            $categories = $category_obj->getAll();
        } else {
            $error = $result['message'];
        }
    } elseif (isset($_POST['delete_category'])) {
        $result = $category_obj->delete($_POST['category_id']);
        if ($result['success']) {
            $success = $result['message'];
            $categories = $category_obj->getAll();
        } else {
            $error = $result['message'];
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tags me-2"></i>Category Management
        </h1>
    </div>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-4">
        <!-- Add Category Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Category</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control form-control-color" id="color" name="color" value="#007bff">
                    </div>
                    <button type="submit" name="create_category" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-1"></i>Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Categories List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Existing Categories (<?= count($categories) ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($categories)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No categories found. Create your first category.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Color</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['id'] ?></td>
                                    <td>
                                        <span class="badge" style="background-color: <?= $category['color'] ?>; color: white;">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($category['description']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: <?= $category['color'] ?>; border-radius: 3px;"></div>
                                            <?= $category['color'] ?>
                                        </div>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($category['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategory<?= $category['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCategory<?= $category['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategory<?= $category['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                                    <div class="mb-3">
                                                        <label for="edit_name<?= $category['id'] ?>" class="form-label">Category Name</label>
                                                        <input type="text" class="form-control" id="edit_name<?= $category['id'] ?>" 
                                                               name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_description<?= $category['id'] ?>" class="form-label">Description</label>
                                                        <textarea class="form-control" id="edit_description<?= $category['id'] ?>" 
                                                                  name="description" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_color<?= $category['id'] ?>" class="form-label">Color</label>
                                                        <input type="color" class="form-control form-control-color" 
                                                               id="edit_color<?= $category['id'] ?>" name="color" value="<?= $category['color'] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="update_category" class="btn btn-primary">Update Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Category Modal -->
                                <div class="modal fade" id="deleteCategory<?= $category['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the category "<strong><?= htmlspecialchars($category['name']) ?></strong>"?</p>
                                                <p class="text-danger"><small>This action cannot be undone.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                                    <button type="submit" name="delete_category" class="btn btn-danger">Delete Category</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
