<?php

namespace view;
use controller\Profile as ProfileController;
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
        $users = $this->profileController->getAll();
        if ($users === false) {
            return "Error; Fail to load users";
        }
        $profileUserData = $this->profileController->getOne($_SESSION['user_id']);
        $profileImagePath = ($profileUserData->getImageId() ? 'includes/assets/images/profiles/' . $profileUserData->getUserId() . '/' . $profileUserData->getUserId() . '.jpg' : "includes/assets/images/user-profile.jpg");

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
                                                            <h4>Contact information   <a href="?action=update&user_id=' . $profileUserData->getUserId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a></h4>
                                                            
                                                            
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
            </section>
        </div>
    </div>
</div>
</div>';

        return $return;
    }
}