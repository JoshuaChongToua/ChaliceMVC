<?php


namespace common;

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
        if (!empty($get['view'])) {
            $view = match ($get['view']) {
                'user' => new UserView(),
                /*
                'scan' => new ScanView(),
                'movie' => new MovieView(),
                default => new LandingPage(),
                */
            };

            if (!empty($get['action'])) {
                $controller = match ($get['view']) {
                    'user' => new UserController(),
                    /*
                    'scan' => new ScanController(),
                    'movie' => new MovieController()
                    */
                };

                if (!isset($controller)) {
                    $this->display = "Error: failed to load controller";
                    return;
                }

                if ($get['action'] == 'add') {
                    if (isset($post)) {
                        if (!isset($post[$get['view']])) {
                            $this->display = "Error: failed to post data";
                            return;
                        }

                        if (!$controller->addNew($post[$get['view']])) {
                            $this->display = "Error: failed add data in database";
                            return;
                        }
                    } else {
                        $this->display = $view->getForm();
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