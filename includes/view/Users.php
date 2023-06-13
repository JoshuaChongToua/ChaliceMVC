<?php

namespace view;
use controller\Users as UserController;

class Users
{
    private UserController $controller;

    /**
     * @param UserController $controller
     */
    public function __construct()
    {
        $this->controller = new UserController();
    }

    public function getTable(): string
    {
        $users = $this->controller->getAll();
        if ($users === false) {
            return "Error; Fail to load users";
        }
        echo '
                <div id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
    <table class="table table-striped">
            <thead>
           <tr class="jsgrid-align-center">
                <th style="width: 150px;">#</th>
                <th style="width: 150px;">Login</th>
                <th style="width: 150px;">Role</th>
                <th style="width: 200px;">Create Date</th>
                <th style="width: 100px;">
                    <a href="?action=create"><span class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button ti-plus" type="button" title=""></span></a>
                </th>            
            </tr>
         </thead>
           <tbody>';


        foreach ($users as $user) {
            if ($user->user_id != $_SESSION['user_id']) {
                $return = '<tr class="jsgrid-align-center" style="display: table-row;">';
                $return .= '<td style="width: 150px;">' . $user->user_id . '</td>';
                $return .= '<td style="width: 100px;">' . $user->login . '</td>';
                $role = getRole($user->type_id);
                //echo "<pre>" . print_r($role, true) . "</pre>";
                $return .= '<td style="width: 100px;">' . $role[0]->role . '</td>';
                $return .= '<td style="width: 100px;">' . $user->create_date . '</td>';
                $return .= '<td style="width: 50px;"> 
                <a href="?action=update&user_id=' . $user->user_id . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a> 
                <a href="?action=delete&user_id=' . $user->user_id . '"><span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span></a> 
                </td>';
                $return .= '</tr>';
            }
        }


        echo '</tbody>
    </table>
    
    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->

                    
                </div>';
        return $return;
    }


}