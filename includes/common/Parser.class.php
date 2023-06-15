<?php

namespace common;

//session_start();

use view\Users as UserView;
use controller\Users as UserController;

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
                    if (!empty($post)) {
                        if (!isset($post[$get['view']])) {
                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->addNew($post[$get['view']])) {
                            $this->display = "Error: failed add data in database";
                            return;
                        }
                    } else {
                        $userView = new UserView();
                        $this->display = $userView->getForm();
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