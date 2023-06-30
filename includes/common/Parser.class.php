<?php

namespace common;

use controller\Users as UserController;
use controller\Login as LoginController;
use view\Dashboard as DashboardView ;
use view\ImagesProfile as ImagesProfileView ;
use view\Images as ImageView ;
use view\Login as LoginView;
use view\News as NewsView;
use view\Profile as ProfileView;
use view\Users as UserView;
use view\UsersTypes as UserTypesView;


class Parser
{
    private string $display = '';


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
        if (isset($get['view']) && $get['view'] == "logout") {
            $controller = new LoginController();
            $controller->logout();
            $view = new LoginView();
            $this->display = $view->getForm();

            return;
        }

        if (!isset($_SESSION['login'])) {
            if (!empty($post)) {
                $controller = new LoginController();
                if (!$controller->verifyForm($post)) {
                    $this->display = "Error login";
                    $view = new LoginView();
                    $this->display .= $view->getForm();

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
                'image' => new ImageView(),
                'profile' => new ProfileView(),
                'image_profile' => new ImagesProfileView(),
                default => new DashboardView()
            };

            if ($view instanceof DashboardView) {
                $this->display = $view->getLandingPage();

                return;
            }
            if ($view instanceof ImagesProfileView && empty($get['action'])) {
                $view = new ProfileView();
                $this->display = $view->getTable();
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
                            //echo "<pre>" . print_r($post, true) . "</pre>";

                            $this->display = "Error: failed add data in database";

                            return;
                        }
                    } else {
                        //$userView = new UserView();
                        $this->display = $view->getForm($get);

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
                    } else if (isset($get)) {
                        $this->display = $view->getForm($get);
                        //echo "<pre>" . print_r($get, true) . "</pre>";

                        return;
                    }
                } else if ($get['action'] == 'delete') {
                    if (!empty($post)) {
                        $this->display = "Error: failed to post data";
                        return;
                    }
                    if (!$controller->delete($get)) {
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