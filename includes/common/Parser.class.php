<?php

namespace common;

use controller\Users as UserController;
use controller\Login as LoginController;
use view\Dashboard as DashboardView ;
use view\Login as LoginView;
use view\Users as UserView;


class Parser
{
    private string $display = '';

	/**
	 * @param array $get
	 * @param array $post
	 */
    public function __construct(array $get, array $post)
    {
        $this->parse($get, $post);
    }

    public function getDisplay(): string
    {
        return $this->display;
    }

    private function parse($get, $post): void
    {
        if (isset($get['action']) && $get['action'] == "logout") {
            $controller = new LoginController();
            $controller->logout();
        }

        if (!isset($_SESSION['login'])) {
            echo "1";
            if (!empty($post)) {
                echo "2";
                $controller = new LoginController();
                if (!$controller->verifyForm($post)) {
                    echo "3";
                    $this->display = "Error login";

                    return;
                }
            }

            if (!isset($_SESSION['login'])) {
                echo "4";
                $view = new LoginView();
                $this->display = $view->getForm();

                return;
            } else {
                $view = new DashboardView();
                echo "5";
                $this->display = $view->getLandingPage();

                return;
            }
echo "6";


        }


        if (isset($get['action'])) {
            $action = $get['action'];
        }
        //echo "<pre>" . print_r($_SESSION, true) . "</pre>";

        if (empty($_SESSION['login'])) {
            $user = new UserView();
            $this->display = $user->getFormLogin();
            //echo "<pre>" . print_r($this->display, true) . "</pre>";

            return;
        } else {
            $userView = new UserView();
            $userTable = $userView->getTable();
            $_SESSION['user_table'] = $userTable;
            $this->display = $userTable;
            //echo "<pre>" . print_r($this->display, true) . "</pre>";

        }

        if (!empty($get['view'])) {
            $view = match ($get['view']) {
                'user' => new UserView(),

            };

            if (!empty($get['action'])) {
                $controller = match ($get['view']) {
                    'user' => new UserController(),

                };

                if (!isset($controller)) {
                    $this->display = "Error: failed to load controller";
                    return;
                }

                if ($get['action'] == 'add') {
                    echo "<pre>" . print_r($post, true) . "</pre>";
                    if (!empty($post)) {
                        if (!$controller->verifyForm($post)) {
                            echo "aaaa";
                            echo "<pre>" . print_r($get, true) . "</pre>";

                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->addNew($post)) {

                            $this->display = "Error: failed add data in database";
                            return;
                        }
                    } else {
                        $userView = new UserView();
                        $this->display = $userView->getForm();
                        echo $this->display
                            ;
                        //echo "<pre>" . print_r($this->display, true) . "</pre>";

                    }
                } else if ($get['action'] == 'update') {
                    if (isset($post)) {
                        if (!isset($post[$get['view']])) {
                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->update($post[$get['view']])) {
                            $this->display = "Error: failed update data in database";
                            return;
                        }
                    } else if (isset($get['user_id'])) {
                        $this->display = $view->getForm($get['user_id']);
                    }
                } else if ($get['action'] == 'delete') {
                    if (!isset($post['user_id'])) {
                        $this->display = "Error: failed to post data";
                        return;
                    }
                    if (!$controller->delete($post['user_id'])) {
                        $this->display = "Error: failed delete data in database";
                        return;
                    }
                }
            }

            if (empty($display)) {
                $this->display = $view->getTable();
            }
        }
    }

}