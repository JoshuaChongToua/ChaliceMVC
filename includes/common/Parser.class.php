<?php

namespace common;

use controller\Users as UserController;
use controller\Login as LoginController;
use view\Dashboard as DashboardView ;
use view\Login as LoginView;
use view\Users as UserView;
use view\UsersTypes as UserTypesView;


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
            if (!empty($post)) {
                $controller = new LoginController();
                if (!$controller->verifyForm($post)) {
                    $this->display = "Error login";

                    return;
                }
            }

            if (!isset($_SESSION['login'])) {
                $view = new LoginView();
                $this->display = $view->getForm();

                return;
            } else {
                $view = new DashboardView();
                $this->display = $view->getLandingPage();

                return;
            }


        }
        //echo "<pre>" . print_r($_SESSION, true) . "</pre>";

        if (!empty($get['view'])) {
            $view = match ($get['view']) {
                'user' => new UserView(),
                'news' => new NewsView(),
                'type' => new UserTypesView(),
                default => new DashboardView()
            };

            if ($view instanceof DashboardView) {
                $this->display = $view->getLandingPage();

                return;
            }

            if (!empty($get['action'])) {
                $controller = $view->getController();


                if (!isset($controller)) {
                    $this->display = "Error: failed to load controller";
                    return;
                }

                if ($get['action'] == 'add') {
                    //echo "<pre>" . print_r($post, true) . "</pre>";
                    if (!empty($post)) {
                        if (!$controller->verifyForm($post)) {

                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->addNew($post)) {

                            $this->display = "Error: failed add data in database";
                            return;
                        }
                    } else {
                        //$userView = new UserView();
                        $this->display = $view->getForm($get['action']);

                        return;
                        //echo "<pre>" . print_r($this->display, true) . "</pre>";

                    }
                } else if ($get['action'] == 'update') {
                    if (!empty($post)) {
                        if (!$controller->verifyForm($post)) {

                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->update($post)) {
                            $this->display = "Error: failed update data in database";
                            return;
                        }
                    } else if (isset($get['user_id'])) {
                        $this->display = $view->getForm($get['action'], $get['user_id']);
                        return;
                    } else if (isset($get['type_id'])) {
                        $this->display = $view->getForm($get['action'], $get['type_id']);
                        return;
                    }
                } else if ($get['action'] == 'delete') {
                    if (!empty($post)) {
                        $this->display = "Error: failed to post data";
                        return;
                    }
                    /*if (!$controller->delete($get['user_id'])) {
                        $this->display = "Error: failed delete data in database";
                        return;
                    }*/ if (!$controller->delete($get['type_id'])) {
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