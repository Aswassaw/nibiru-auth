<?php

namespace App\Libraries;

use App\Models\UserModel;

class RoleLibraries
{
    public function checkPermissionAdmin($id_user, $id_target)
    {
        $UserModel = new UserModel();
        $user = $UserModel->select('id, role')->find($id_user);
        $target = $UserModel->select('id, role')->withDeleted()->find($id_target);

        // Jika user adalah Super Admin
        if ($user['role'] == 1) {
            return true;
        }

        // Jika user adalah Normal Admin
        else if ($user['role'] == 2) {
            // Jika target adalah Super Admin
            if ($target['role'] == 1) {
                return false;
            }

            // Jika target adalah Normal Admin
            else if ($target['role'] == 2) {
                return $user['id'] == $target['id'];
            }

            // Jika target adalah User biasa
            return true;
        }

        // Jika user hanyalah User biasa
        else if ($user['role'] == 3) {
            return false;
        }

        // Anda siapa sih?
        else {
            dd('Anda siapa sih?');
        }
    }
}
