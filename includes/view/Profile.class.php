<?php

namespace view;

use controller\Profile as ProfileController;
use controller\ImagesProfile as ImageProfileController;
use model\Profile as ProfileModel;

class Profile
{
    private ProfileController $profileController;

    public function __construct()
    {
        $this->profileController = new ProfileController();
    }

    public function getController(): ProfileController
    {
        return $this->profileController;
    }

    public function getTable(): string
    {
        $profileUserData = $this->profileController->getOne($_SESSION['user_id']);
        if ($profileUserData === false) {
            return $this->getForm([]);
        }

        //echo "<pre>" . print_r($profileUserData, true) . "</pre>";

        $profileImagePath = ($profileUserData->getImageId() ? '/admin/includes/assets/images/profiles/' . $profileUserData->getUserId() . '/' . $profileUserData->getImageId() . '.jpg' : "/admin/includes/assets/images/user-profile.jpg");

        $return = '
<div class="container">
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-profile">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="user-photo m-b-30">
                                                    <img class="img-fluid" src="' . $profileImagePath . '" alt=""/>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="user-profile-name">' . $_SESSION['login'] . '</div>
                                                <div class="user-Location">
                                                    <i class="ti-location-pin">' . $profileUserData->getCity() . '</i>  
                                                </div>
                                                <div class="user-job-title">Product Designer</div>
                                                
                                                <div class="user-send-message">
                                                    <button class="btn btn-primary btn-addon" type="button">
                                                        <i class="ti-email"></i>Send Message
                                                    </button>
                                                </div>
                                                <div class="custom-tab user-profile-tab">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li role="presentation" class="active">
                                                            <a href="#1" aria-controls="1" role="tab" data-toggle="tab">About</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="1">
                                                            <div class="contact-information">
                                                                <h4>Contact information   <a href="/admin/profile/update/' . $profileUserData->getUserId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a></h4>
                                                                
                                                                <div class="name-content">
                                                                    <span class="contact-title">Name:</span>
                                                                    <span class="phone-number">' . $profileUserData->getName() . '</span> 
                                                                </div>
                                                                <div class="name-content">
                                                                    <span class="contact-title">First Name:</span>
                                                                    <span class="phone-number">' . $profileUserData->getFirstName() . '</span>
                                                                </div>
                                                                <div class="phone-content">
                                                                    <span class="contact-title">Phone:</span>
                                                                    <span class="phone-number">' . $profileUserData->getPhone() . '</span>
                                                                </div>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Address:</span>
                                                                    <span class="mail-address">' . $profileUserData->getAddress() . '</span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Email:</span>
                                                                    <span class="contact-email">' . $profileUserData->getEmail() . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>';

        return $return;
    }

    public function getForm(array $action): string
    {
        $id = empty($action) ? $_SESSION['user_id'] : $action['id'];
        $profileUserData = $this->profileController->getOne($id);
        if (!$profileUserData) {
            $profileUserData = new ProfileModel((object)['user_id' => $id]);
        }
        $action['action'] = $action['action'] ?? "add";
        //echo "<pre>" . print_r($userInfo, true) . "</pre>";


        $imageProfileController = new ImageProfileController();
        $images = $imageProfileController->getAll($profileUserData->getUserId());

        $return = '
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title">
                    <h4>Update Profile</h4>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" name="profileForm" method="POST" action="/admin/profile/' . $action['action'] . '" onsubmit="return validateEmail()">
                            Profile Image Management: <a href="/admin/imageProfile/add/' . $profileUserData->getUserId() . '"><button type="button" class="btn btn-primary btn-sm btn-addon m-b-5 m-l-5"><i class="ti-plus"></i>Management</button></a>
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="name">Nom :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="name" value="' . ($action['action'] == 'update' ? $profileUserData->getName() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="firstName">Prenom :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="firstName" value="' . ($action['action'] == 'update' ? $profileUserData->getFirstName() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="phone">Phone :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="phone" value="' . ($action['action'] == 'update' ? $profileUserData->getPhone() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="address">Adresse :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="address" value="' . ($action['action'] == 'update' ? $profileUserData->getAddress() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="email">Email :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" id="email" name="email" value="' . ($action['action'] == 'update' ? $profileUserData->getEmail() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>
        
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label" for="city">Ville :</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="city" value="' . ($action['action'] == 'update' ? $profileUserData->getCity() : '') . '" autocomplete="off">
                                </div>
                            </div>
                            
                            <br>';

        if (!empty($images)) {
            $return .= '
                            <div class="form-group row ">
                                <label class="col-lg-3 col-form-label">ImageId:</label>
                                <div class="col-lg-9">';

            $imagesPerRow = 6;
            $imageCount = count($images);
            if ($action['action'] == "update") {
                $selected = $profileUserData->getImageId();
            }

            for ($i = 0; $i < $imageCount; $i++) {
                $image = $images[$i];
                if ($imagesPerRow == 6) {
                    $return .= '<div class="row">';
                }
                $return .= '   
                                <div class="col-lg-2">
                                    <img id="imageTab" src="includes/assets/images/profiles/' . $profileUserData->getUserId() . '/' . $image->getImageId() . '.jpg">
                                    <input type="radio" id="imageRadio" name="image_id" value="' . $image->getImageId() . '"' . ($action['action'] == "update" && $selected == $image->getImageId() ? 'checked="checked"' : '') . '>
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

        $return .= '         
                            <br>
                            <div id="test">
                            </div>
                            <input type="hidden" id="user_id" name="user_id" value="' . $id . '">
                            <a class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" href="/admin/profile"><i class="ti-back-left"></i> Retour</a>
                            <button type="submit" name="submit" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i> Submit</button>
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
