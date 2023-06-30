<?php

namespace view;

use common\Helper;
use controller\ImagesProfile as ImagesProfileController;
use controller\Users as UserController;

class ImagesProfile
{
    private ImagesProfileController $ImagesProfileController;

    public function __construct()
    {
        $this->ImagesProfileController = new ImagesProfileController();
    }

    public function getController(): ImagesProfileController
    {
        return $this->ImagesProfileController;
    }

    public function getTable(): string
    {
        return $this->getForm();
    }

    public function getForm(array $action = null): string
    {
        $profileUser = new UserController();
        $profileUserData = $profileUser->getOne($_SESSION['user_id']);
        $images = $this->ImagesProfileController->getAll($profileUserData->getUserId());
        $return = '
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Add Image</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" name="imageForm" action="/admin/image_profile/add/' . $profileUserData->getUserId() . '" method="POST" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-lg-8">
                                            <input class="form-control" type="file" name="image">
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="' . $profileUserData->getUserId() . '">
                                    <input type="hidden" name="image_id" value="' . $profileUserData->getUserId() . '">
                                    <a class="btn btn-info btn-flat btn-addon m-b-10 m-l-5" href="/admin/profile/update/' . $profileUserData->getUserId() . '">
                                        <i class="ti-back-left"></i> Retour
                                    </a>
                                    <button type="submit" name="submit" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i> Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Update Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <div class="form-group row">
                                <div class="col-lg-12">';
        if ($images === false) {
            // Gérer le cas où $images est false
            $return .= '<p>Aucune image trouvée.</p>';
        } else {
            $imagesPerRow = 6;
            $imageCount = count($images);
            for ($i = 0; $i < $imageCount; $i++) {
                $image = $images[$i];
                if ($imagesPerRow == 6) {
                    $return .= '<div class="row">';
                }
                $return .= '   
                <div class="col-lg-2">
                    <img id="imageTab" src="' . Helper::getImage($image->getImageId(),Helper::IMG_DIR_PROFILES . $profileUserData->getUserId()) . '">
                    <a href="/admin/image_profile/delete/' . $image->getImageId() . '">
                        <span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span>
                    </a> 
                </div>';
                $imagesPerRow--;
                if ($imagesPerRow == 0) {
                    $return .= '</div>';
                    $imagesPerRow = 6;
                }
            }
            if ($imagesPerRow != 6) {
                $return .= '</div>';
            }
        }
        $return .= '            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $return;
    }
}
