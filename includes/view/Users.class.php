<?php

namespace view;
use controller\Users as UserController;
use controller\UsersTypes as UsersTypesController;

class Users
{
    private UserController $controller;
    
    
    public function __construct()
    {
        $this->controller = new UserController();
    }
    
    public function getController(): UserController
    {
        return $this->controller;
    }

    public function getTable(): string
    {
        $users = $this->controller->getAll();
        if ($users === false) {
            return "Error; Fail to load users";
        }
        $return = '
    <div class="container">
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
                                                        <a href="?view=user&action=add"><span class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button ti-plus" type="button" title=""></span></a>
                                                    </th>            
                                                </tr>
                                             </thead>
                                               <tbody>';


        foreach ($users as $user) {
            //echo "<pre>" . print_r($user, true) . "</pre>";

            if ($user->getUserId() != $_SESSION['user_id']) {
                $return .= '<tr class="jsgrid-align-center" style="display: table-row;">';
                $return .= '<td style="width: 150px;">' . $user->getUserId() . '</td>';
                $return .= '<td style="width: 100px;">' . $user->getLogin() . '</td>';
                $role = $this->controller->getRole($user->getTypeId());
                //echo "<pre>" . print_r($role, true) . "</pre>";
                $return .= '<td style="width: 100px;">' . $role .'</td>';
                //$return .= '<td style="width: 100px;"></td>';
                $return .= '<td style="width: 100px;">' . $user->getCreateDate() . '</td>';
                $return .= '<td style="width: 50px;"> 
                <a href="?view=user&action=update&user_id=' . $user->getUserId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a> 
                <a href="?view=user&action=delete&user_id=' . $user->getUserId() . '"><span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span> </a> 
                </td>';
                $return .= '</tr>';
            }
        }


        $return .= '                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->

                    
                </div>
                </div>
                ';

        return $return;
    }




    public function getForm(string $action, int $userId = null): string
    {
        if (isset($userId)) {
            $userInfo = $this->controller->getOne($_GET['user_id']);
            //echo "<pre>" . print_r($userInfo, true) . "</pre>";
        }
        $usersTypesController = new UsersTypesController();
        $usersTypesCollection = $usersTypesController->getAll();
        //echo "<pre>" . print_r($usersTypesCollection, true) . "</pre>";


        $return = ' 
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                            <div class="card-title">
                                    <h4>Add User</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-validation">
                                        
                                                
                                                    
    <form class="form-valide" name="userForm" method="POST" action="?view=user&action=' . $action . '"  >
    
    <div class="form-group row ">                             
        <label class="col-lg-3 col-form-label" for="login">Login :<span class="text-danger">*</span></label>
        <div class="col-lg-9">
         <input class="form-control" type="text" id="login" name="login"  value="' . ($action == 'update' ? $userInfo->getLogin() : '') . '" onkeypress="verifierCaracteres(event); return false;"/>
         </div>
    </div>
         
        <br>
        
        <div class="form-group row ">                             
        <label class="col-lg-3 col-form-label" for="password">Password :<span class="text-danger">*</span></label>
        <div class="col-lg-9">
        <input class="form-control" id="password" type="password" name="password"  value="' . ($action == 'update' ? $userInfo->getPassword() : '') . '">
        </div>
        </div>
        
        <br>
        
        <input type="hidden" name="user_id" value="' . ($action == 'update' ? $userInfo->getUserId() : '') . '">
        
       
               <div class="form-group row ">                             

        <label class="col-lg-3 col-form-label"for="role">Role :<span class="text-danger">*</span></label>
        <div class="col-lg-9">
            <select class="form-control" name="type_id">';
    foreach ($usersTypesCollection as $type) {

        $return .= '<option value ="' . $type->getTypeId() . '"' . ($action == 'update' ? $type->getTypeId() : '') . ' >' . $type->getRole() . '</option>';

    }

    $return .= '</select>
           
        </div>
        </div>
        <br>
      
        <a class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" href="?view=user"><i class="ti-back-left"></i></span>Retour</a>
                   
        <button type="submit" name="submit"  class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i>Submit</button>
                                        
    </form>
    </div>
    </div>
            </div>
            </div>
            </div>
            </div>
            

    ';
    return $return;
    }

}