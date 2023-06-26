<?php

namespace view;

use controller\UsersTypes as UsersTypesController;

class UsersTypes
{
    private UsersTypesController $usersTypesController;

    public function __construct()
    {
        $this->usersTypesController = new UsersTypesController();
    }

    public function getController(): UsersTypesController
    {
        return $this->usersTypesController;
    }

    public function getUsersTypesController(): UsersTypesController
    {
        return $this->usersTypesController;
    }

    public function getTable(): string
    {
        $types = $this->usersTypesController->getAll();
        if ($types === false) {
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
                                                <th style="width: 400px;">#</th>
                                                <th style="width: 400px;">Role</th>
                                                <th style="width: 400px;">
                                                    <a href="?view=type&action=add"><span class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button ti-plus" type="button" title=""></span></a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>';

        foreach ($types as $type) {
            $return .= '<tr class="jsgrid-align-center" style="display: table-row;">';
            $return .= '<td style="width: 100px;">' . $type->getTypeId() . '</td>';
            $return .= '<td style="width: 100px;">' . $type->getRole() . '</td>';
            $return .= '<td style="width: 50px;"> 
                            <a href="?view=type&action=update&type_id=' . $type->getTypeId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"></span></a> 
                            <a href="?view=type&action=delete&type_id=' . $type->getTypeId() . '"><span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span></a> 
                        </td>';
            $return .= '</tr>';
        }

        $return .= '</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>';

        return $return;
    }

    public function getForm(array $action): string
    {
        $typeInfo = null;
        if (isset($action['type_id'])) {
            $typeInfo = $this->usersTypesController->getOne($_GET['type_id']);
        }

        $return = '
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Add Type</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" name="typeForm" method="POST" action="?view=type&action=' . $action['action'] . '" onkeypress="verifierCaracteres(event); return false;">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label" for="login">Role :<span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="role" value="' . ($action['action'] == 'update' ? $typeInfo->getRole() : '') . '"/>
                                        </div>
                                    </div>
    
                                    <br>
    
                                    <input type="hidden" name="type_id" value="' . ($action['action'] == 'update' ? $typeInfo->getTypeId() : '') . '">
                                    <br>
    
                                    <a class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" href="?view=type"><i class="ti-back-left"></i>Retour</a>
                                    <button type="submit" name="submit" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i>Submit</button>
    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $return;
    }
}
