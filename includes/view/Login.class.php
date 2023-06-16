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
        <form name="index" method="POST" action="/chaliceMVC">
            Logina : <input type="text" name="login" autocomplete="off" onkeypress="verifierCaracteres(event); return false;">
            Password : <input type="password" name="password" autocomplete="off" >
            <input type="submit" name="submit" value="submit">
        </form>';
    }


}