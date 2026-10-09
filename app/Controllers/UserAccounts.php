<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserAccounts extends BaseController
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function index()
    {
        return view('users/index', [
            'title' => 'User Accounts',
            // Never include password hashes in data sent to the view.
            'users' => $this->users
                ->select('id, username, full_name, created_at, avatar')
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function createForm()
    {
        return view('users/form', [
            'title'  => 'Add User',
            'user'   => [],
            'action' => site_url('users'),
            'isEdit' => false,
        ]);
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password'  => 'required|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            // Keep only non-secret form values; never flash the password back.
            return redirect()->to(site_url('users/new'))
                ->with('user_form_errors', $this->validator->getErrors())
                ->with('old_username', trim((string) $this->request->getPost('username')))
                ->with('old_full_name', trim((string) $this->request->getPost('full_name')));
        }

        $this->users->insert([
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'password'  => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'avatar'    => null,
        ]);

        return redirect()->to(site_url('users'))->with('success', 'User added successfully.');
    }

    public function edit(int $id)
    {
        $user = $this->users->find($id);
        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/form', [
            'title'  => 'Edit User',
            'user'   => $user,
            'action' => site_url('users/' . $id),
            'isEdit' => true,
        ]);
    }

    public function update(int $id)
    {
        $user = $this->users->find($id);
        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username'  => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
        ];

        $avatar = $this->request->getFile('avatar');
        $hasNewAvatar = $avatar !== null && $avatar->getError() !== UPLOAD_ERR_NO_FILE;
        if ($hasNewAvatar) {
            $rules['avatar'] = [
                'label' => 'Avatar',
                'rules' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]',
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $avatarName = $user['avatar'] ?? null;
        $newAvatarPath = null;

        if ($hasNewAvatar) {
            $extension = strtolower($avatar->getExtension());
            if (! in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
                return redirect()->back()->withInput()->with('upload_error', 'Choose a JPG or PNG image.');
            }

            $avatarName = bin2hex(random_bytes(16)) . '.' . $extension;
            $uploadDirectory = FCPATH . 'uploads/avatars';
            if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0755, true) && ! is_dir($uploadDirectory)) {
                return redirect()->back()->withInput()->with('upload_error', 'The avatar upload folder could not be created.');
            }
            $newAvatarPath = $uploadDirectory . DIRECTORY_SEPARATOR . $avatarName;

            try {
                service('image')->withFile($avatar->getTempName())->fit(256, 256, 'center')->save($newAvatarPath, 85);
            } catch (\Throwable $exception) {
                return redirect()->back()->withInput()->with('upload_error', 'The avatar could not be prepared. Make sure PHP GD is enabled, then try again.');
            }
        }

        $updated = $this->users->update($id, [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'avatar'    => $avatarName,
        ]);

        if (! $updated) {
            if ($newAvatarPath !== null && is_file($newAvatarPath)) {
                unlink($newAvatarPath);
            }
            return redirect()->back()->withInput()->with('upload_error', 'The user could not be updated. Please try again.');
        }

        $oldAvatar = $user['avatar'] ?? null;
        if ($hasNewAvatar && is_string($oldAvatar) && $oldAvatar !== '' && basename($oldAvatar) === $oldAvatar) {
            $oldPath = FCPATH . 'uploads/avatars' . DIRECTORY_SEPARATOR . $oldAvatar;
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        return redirect()->to(site_url('users'))->with('success', 'User updated successfully.');
    }

}
