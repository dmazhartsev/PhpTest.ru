<?php

namespace App\Services;

class Redirect
{

    public function toIndex(): void
    {
        header('Location: /');
        exit;
    }

    public function toRegistration(): void
    {
        header('Location: /?c=User&a=registration');
        exit;
    }

    public function toEdit(): void
    {
        header('Location: /?c=User&a=edit');
        exit;
    }

    public function toChangePassword(): void
    {
        header('Location: /?c=User&a=change_password');
        exit;
    }

    public function toInfo(): void
    {
        header('Location: /?c=User&a=info');
        exit;
    }

    public function toAuthorisation(): void
    {
        header('Location: /?c=User&a=authorisation');
        exit;
    }

    public function to404(): void
    {
        header('Location: /404', true, 404);
        exit;
    }

    public function to405(): void
    {
        header('Location: /405', true, 405);
        exit;
    }
}
