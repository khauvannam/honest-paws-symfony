<?php

namespace App\Entity\Users;

enum UserVerify : string
{
case verify = 'verify';
case unverify = 'unverify';
}
