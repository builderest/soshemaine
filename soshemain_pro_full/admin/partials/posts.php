<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Posts</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#postFormCollapse">Add post</button>
    </div>
    <div class="collapse" id="postFormCollapse">
        <div class="card-body">
            <form method="post" id="postForm">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="postContent" class="form-control tinymce-editor"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Categories</label>
                        <input type="text" name="categories" class="form-control" placeholder="Business, Strategy">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control" placeholder="growth, marketing">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" value="Admin">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Publish at</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta (JSON)</label>
                        <textarea name="meta_json" class="form-control" rows="2">{"og_image":""}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save post</button>
                            <button type="button" class="btn btn-outline-secondary" data-reset-form="postForm">Clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['title']); ?></td>
                        <td><span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($item['status']); ?></span></td>
                        <td><?php echo $item['published_at'] ? date('M d, Y', strtotime($item['published_at'])) : '—'; ?></td>
                        <td class="text-end">
                            <?php $postPayload = json_encode([
                                'id' => $item['id'],
                                'title' => $item['title'],
                                'slug' => $item['slug'],
                                'excerpt' => $item['excerpt'],
                                'content' => $item['content'],
                                'categories' => $item['categories'],
                                'tags' => $item['tags'],
                                'author' => $item['author'],
                                'published_at' => $item['published_at'],
                                'status' => $item['status'],
                                'meta_json' => $item['meta'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="postForm" data-fields='<?php echo e($postPayload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this post?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No posts yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
