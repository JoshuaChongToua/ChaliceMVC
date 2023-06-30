<?php

namespace view;

use common\Helper;
use controller\News as NewsController;
use controller\Images as ImagesController;

class News
{
    private NewsController $newsController;

    public function __construct()
    {
        $this->newsController = new NewsController();
    }

    public function getController(): NewsController
    {
        return $this->newsController;
    }

    public function getTable(): string
    {
        $allNews = $this->newsController->getAll();
        $imageController = new ImagesController();
        if ($allNews === false) {
            return "Error; Fail to load news";
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
                                                <th style="width: 150px;">Title</th>
                                                <th style="width: 150px;">Description</th>
                                                <th style="width: 150px;">Image</th>
                                                <th style="width: 150px;">Link</th>
                                                <th style="width: 150px;">Publication Date</th>
                                                <th style="width: 150px;">Enable</th>
                                                <th style="width: 100px;">
                                                    <a href="/admin/news/add"><span class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button ti-plus jsgrid-align-center" type="button" title=""></span></a>
                                                </th>  
                                            </tr>
                                        </thead>
                                        <tbody>';

        foreach ($allNews as $news) {
            $return .= '<tr class="jsgrid-align-center" data-newsid="' . $news->getNewsId() . '" style="display: table-row;">
                <td style="width: 150px;">' . $news->getNewsId() . '</td>
                <td style="width: 100px;">' . $news->getTitle() . '</td>
                <td style="width: 100px;">' . $news->getDescription() . '</td>';
            $imageById = $news->getImageId() !== null ? $imageController->getOne($news->getImageId()) : null;
            if ($imageById) {
                //echo "<pre>" . print_r($imageController->getOne($news->getImageId()), true) . "</pre>";

                $return .= '<td style="width: 150px;">
                    <img id="imageTabNews" src="' . Helper::getImage($news->getImageId(), 'upload') . '">' . PHP_EOL . '
                </td>';

            } else {
                $return .= '<td style="width: 100px;">' . "- - -" . '</td>';
            }
            $return .= '<td style="width: 100px;">' . $news->getLink() . '</td>
                <td style="width: 100px;">' . $news->getPublicationDate() . '</td>';
            if ($news->isEnable() == 1) {
                $return .= '<td style="width: 100px;"><i class="ti-check color-success border-success"></i></td>';
            } else {
                $return .= '<td style="width: 100px;"><i class="ti-close color-danger border-danger"></i></td>';
            }
            $return .= '<td style="width: 50px;"> 
                <a href="/admin/news/update/' . $news->getNewsId() . '"><span class="jsgrid-button jsgrid-edit-button ti-pencil" type="button" title="Edit"  ></span></a> 
                <a href="/admin/news/delete/' . $news->getNewsId() . '"><span class="jsgrid-button jsgrid-delete-button ti-trash" type="button" title="Delete"></span></a> 
            </td>

            </tr>';
        }

        $return .= '
                                        </tbody>
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
        </div>';

        return $return;
    }

    public function getForm(array $action): string
    {
        if (isset($action['id'])) {
            $newsInfo = $this->newsController->getOne($action['id']);
            //echo "<pre>" . print_r($newsInfo, true) . "</pre>";

        }
        $imagesController = new ImagesController();
        $images = $imagesController->getAll();
        $return = '
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Add News</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" name="newsForm" method="POST" action="/admin/news/' . $action['action'] . '"   >
                                    <div class="form-group row ">
                                        <label class="col-lg-3 col-form-label" for="title" >Title :<span class="text-danger"> *</span></label>  
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="title" placeholder="Title"  value="' . ($action['action'] == 'update' ? $newsInfo->getTitle() : '') . '" onkeypress="verifierCaracteres(event); return false;" />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row ">
                                        <label class="col-lg-3 col-form-label">Description:</label>
                                        <div class="col-lg-9">
                                            <textarea id="tiny" name="description">' . ($action['action'] == 'update' ? $newsInfo->getDescription() : '') . '</textarea>
                                        </div>
                                    </div>
                                    <br>';
        if (!empty($images)) {
            $return .= '
                                    <div class="form-group row ">
                                        <label class="col-lg-3 col-form-label">ImageId:</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="image_id" onchange="getImageSelect( this.value )">

                                                <option value="--">--</option>';
            foreach ($images as $image) {
                if (!empty($newsInfo)) {
                    $selected = ($image->getImageId() == $newsInfo->getImageId()) ? 'selected="selected"' : '';
                    $return .= '<option value="' . $image->getImageId() . '" ' . $selected . '  >' . $image->getName() . '</option>';
                } else {
                    $return .= '<option value="' . $image->getImageId() . ' " >' . $image->getName() . '</option>';

                }
            }
            $return .= '
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row ">  
                                        <label class="col-lg-3 col-form-label"></label>
                                        <div id="test" class="col-lg-9" >
                                        </div>            
                                    </div>';
        }
        $return .= '
                                    <div class="form-group row ">                             
                                        <label class="col-lg-3 col-form-label">Link :</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="link" placeholder="Link" value="' . ($action['action'] == 'update' ? $newsInfo->getLink() : '') . '" onkeypress="verifierCaracteres(event); return false;" autocomplete="off" />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row ">                             
                                        <label class="col-lg-3 col-form-label">Date de publication :</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="date" id="date" name="publicationDate" value="' . ($action['action'] == 'update' ? date('Y-m-d', strtotime($newsInfo->getPublicationDate())) : '') . '">
                                        </div>
                                    </div>
                                    <br>';
        if ($action['action'] == "update") {
            $selected = $newsInfo->isEnable();
        }
        $return .= '
                                    <div class="form-group row ">                                     
                                        <label class="col-lg-3 col-form-label">Enable :</label>
                                        <div class="col-lg-4">        
                                            <input type="radio"  name="enable" value="1" ' . ($action['action'] == "update" && $selected == 1 ? 'checked="checked"' : '') . '>
                                            <label>True</label>
                                        </div>
                                        <div class="col-lg-5">        
                                            <input type="radio"  name="enable" value="0" ' . ($action['action'] == "update" && $selected == 0 ? 'checked="checked"' : '') . '>
                                            <label>False</label>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" name="news_id" value="' . ($action['action'] == 'update' ? $newsInfo->getNewsId() : '') . '">
                                    <br>
                                    <a class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" href="/admin/news">
                                        <i class="ti-back-left"></i>Retour
                                    </a>
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
