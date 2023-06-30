<?php

namespace view;

class Login
{
    public function __construct()
    {
    }

    public function getForm(): string
    {
        return '
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form class="form-valide" name="index" method="POST" action="/admin/homepage">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Login:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="login" autocomplete="off" onkeypress="verifierCaracteres(event); return false;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Password:</label>
                                        <div class="col-lg-9">
                                            <input type="password" class="form-control" name="password" autocomplete="off">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}
