<?php
$users = App\Models\User::all(['id', 'name', 'email']);
foreach($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email}\n";
}
