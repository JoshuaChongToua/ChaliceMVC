<?php

namespace view;

class Login
{

    public function __construct()
    {
    }

    public function getForm(): string
    {
        return  '
<div class="container">
<div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
<div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Login</h4>
                                    </div>
                                    <div class="card-body">
                                    <div class="basic-form">
        
            <form name="index" method="POST" action="/admin/">
            <div class="form-group">
                <label>Login:</label> 
                <input type="text" class="form-control" name="login" autocomplete="off" onkeypress="verifierCaracteres(event); return false;">
                </div>
                <div class="form-group">
                <label>Password:</label>  
                <input type="password" class="form-control" name="password" autocomplete="off">
                 </div>
                 <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
             </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                        </div>';
    }
}
