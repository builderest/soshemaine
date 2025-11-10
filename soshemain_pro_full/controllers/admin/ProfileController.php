<?php

class ProfileController
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function updatePassword(array $payload, array $user): array
    {
        if (empty($user['id'])) {
            return ['success' => false, 'message' => 'User account not found.'];
        }

        $current = trim($payload['current_password'] ?? '');
        $new = trim($payload['new_password'] ?? '');
        $confirm = trim($payload['confirm_password'] ?? '');

        if ($current === '' || $new === '' || $confirm === '') {
            return ['success' => false, 'message' => 'All password fields are required.'];
        }

        if (!password_verify($current, $user['password'])) {
            return ['success' => false, 'message' => 'Your current password is incorrect.'];
        }

        if (strlen($new) < 8) {
            return ['success' => false, 'message' => 'New password must be at least 8 characters long.'];
        }

        if ($new !== $confirm) {
            return ['success' => false, 'message' => 'New password and confirmation do not match.'];
        }

        if (password_verify($new, $user['password'])) {
            return ['success' => false, 'message' => 'Please choose a password different from the current one.'];
        }

        $hash = password_hash($new, PASSWORD_BCRYPT);
        $updated = $this->users->update((int) $user['id'], ['password' => $hash]);

        if ($updated) {
            Auth::refreshUser((int) $user['id']);
            return ['success' => true, 'message' => 'Password updated successfully.'];
        }

        return ['success' => false, 'message' => 'Unable to update password. Please try again.'];
    }
}

