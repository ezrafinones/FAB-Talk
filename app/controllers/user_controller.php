<?php
class UserController extends AppController
{
    public function register()
    {
        $userinfo = new UserInfo;
        $user = new User;
        $page = Param::get('page_next','register');

        switch ($page) {
            case 'register':
                break;
            case 'write_end':
                $userinfo->firstname = Param::get('firstname');
                $userinfo->lastname = Param::get('lastname');
                $userinfo->email = Param::get('email');
                $userinfo->username = Param::get('username');
                $userinfo->password = Param::get('password');
                $userinfo->validate_password = Param::get('validate_password');

                $user->firstname = Param::get('firstname');
                $user->lastname = Param::get('lastname');
                $user->email = Param::get('email');
                $user->username = Param::get('username');
                $user->password = Param::get('password');

                if (!$this->matchPassword()) {
                    $userinfo->validation_errors['password']['match'] = true;
                }

                try {
                    $user->register($userinfo);
                }
                catch (ValidationException $e) {
                    $page = 'register';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");    
                break;
        }
        $this->set(get_defined_vars()); 
        $this->render($page);
    }

    public function login()
    {
        $user = new User;
        $page = Param::get('page_next','login');

        switch ($page) {
            case 'login':
                break;
            case 'user_profile':
                $user->firstname = Param::get('firstname');
                $user->lastname = Param::get('lastname');
                $user->login();
                break;
            default:
                throw new NotFoundException("{$page} is not found");    
                break;
        }
        $this->set(get_defined_vars()); 
    }

    public function matchPassword()
    {
        $isMatch = Param::get('password') == Param::get('validate_password');
        if ($isMatch) {
            return true;
        }
    }
}

