<?php
require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Page.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Media.php';
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../models/Settings.php';
require_once __DIR__ . '/../models/Menu.php';
require_once __DIR__ . '/../models/Redirect.php';
require_once __DIR__ . '/../models/Job.php';

class AdminController
{
    public function requireAuth(): void
    {
        if (!Auth::check()) {
            header('Location: index.php');
            exit;
        }
    }

    public function users(): array
    {
        $this->requireAuth();
        $model = new User();
        return $model->all();
    }

    public function saveUser(array $data, ?int $id = null): bool
    {
        $this->requireAuth();
        $model = new User();
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        if ($id) {
            return $model->update($id, $data);
        }
        return $model->create($data) > 0;
    }

    public function deleteUser(int $id): bool
    {
        $this->requireAuth();
        return (new User())->delete($id);
    }

    public function genericList(string $entity): array
    {
        $this->requireAuth();
        $model = $this->resolveModel($entity);
        return $model->all();
    }

    public function genericSave(string $entity, array $data, ?int $id = null): bool
    {
        $this->requireAuth();
        $model = $this->resolveModel($entity);
        if ($id) {
            return $model->update($id, $data);
        }
        return $model->create($data) > 0;
    }

    public function genericDelete(string $entity, int $id): bool
    {
        $this->requireAuth();
        $model = $this->resolveModel($entity);
        return $model->delete($id);
    }

    private function resolveModel(string $entity)
    {
        return match ($entity) {
            'pages' => new Page(),
            'products' => new Product(),
            'categories' => new Category(),
            'posts' => new Post(),
            'media' => new Media(),
            'contacts' => new Contact(),
            'settings' => new Settings(),
            'menus' => new Menu(),
            'redirects' => new Redirect(),
            'jobs' => new Job(),
            default => throw new InvalidArgumentException('Entidad no soportada')
        };
    }
}
