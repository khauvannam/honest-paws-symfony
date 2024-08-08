<?php

namespace App\Entity\Users;

enum CaseDescription: string
{
    case ResetPassword = 'Reset Password';
    case ChangePassword = 'Change Password';
    case DeleteAccount = 'Delete Account';
}
