<?php 

function currentUser() 
{
    if(\Auth::check()) return \Auth::user();
    else return null;
}

function currentUserId() 
{
    if(\Auth::check()) return \Auth::id();
    else return null;
}