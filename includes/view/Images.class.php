<?php

namespace view;
use common\Helper;
use controller\Images as ImagesController;

class Images
{
    private ImagesController $imageController;

    public function __construct()
    {
        $this->imageController = new ImagesController();
    }



    public function getController(): ImagesController
    {
        return $this->imageController;
    }

    public function getTable(): string
    {
        $imagesCollection = $this->imageController->getAll();
        if ($imagesCollection === false) {
            return "Error; Fail to load images";
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
            <th  style="width: 300px;"></th>
            <th  style="width: 300px;">#</th>
            <th  style="width: 300px;">Name</th>
            <th  style="width: 300px;">Create date</th>
            <th  style="width: 300px;">
                    <a href="?view=image&action=add"><span class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button ti-plus" type="button" title=""></span></a>
            </th> 
        </tr>
     </thead>

    <tbody>';

        foreach ($imagesCollection as $imageItem) {
            //echo "<pre>" . print_r($imageItem->getImageId(), true) . "</pre>";

            $return .= '<tr class="jsgrid-align-center" style="display: table-row;">
            <td style="width: 150px;">
            <img id="imageTab" src="' . Helper::getImage($imageItem->getImageId(), Helper::IMG_DIR_UPLOAD) . '" alt="Image" title="' . $imageItem->getName() . '">' . PHP_EOL .'
            </td>
            <td style="width: 150px;">' . $imageItem->getImageId() . '</td>
            <td style="width: 150px;">' . $imageItem->getName() . '</td>
            <td style="width: 150px;">' . $imageItem->getCreateDate() . '</td>
            <td style="width: 50px;"> 
                <a href="?view=image&action=update&image_id=' . $imageItem->getImageId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a> 
                <a href="?view=image&action=delete&image_id=' . $imageItem->getImageId() . '"><span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span></a> 
                </td>
            </tr>';

        }


        $return .= '</tbody>
    </table>
        
    
                    </div>
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


    public function getForm(array $action): string
    {
        if (isset($action['image_id'])) {
            $image = $this->imageController->getOne($_GET['image_id']);
            //echo "<pre>" . print_r($userInfo, true) . "</pre>";
        }

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
                                        
    <form class="form-valide" name="imageForm" action="?view=image&action=' . $action['action'] . '" method="POST" enctype="multipart/form-data" onsubmit= "return validateForm(\'imageForm\',\'imageTitle\');" onkeypress="verifierCaracteres(event); return false;">
            <div class="form-group row ">                             
        <label class="col-lg-3 col-form-label" for="title">Title :<span class="text-danger">*</span></label>
        <div class="col-lg-9">
        <input class="form-control" type="text" name="name" placeholder="imageTitle" autocomplete="off" value="' . ($action['action'] == 'update' ? $image->getName() : '') . '">
        </div>
    </div>
        
        <br>';
        if ($action['action'] != 'update') {
            $return .= '
        <input type="file" name="image" >';
        }
        $return .= '<br>
        <input type="hidden" name="image_id" value="' . ($action['action'] == 'update' ? $image->getImageId() : '') . '" >
        <br>
        
        <a class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" href="?view=image"><i class="ti-back-left"></i></span>Retour</a>
        <button type="submit" name="submit"  class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i>Submit</button>
    </form>
    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div> ';
        return $return;
    }

}