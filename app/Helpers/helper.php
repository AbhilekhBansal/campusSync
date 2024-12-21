<?php


function greetUser($name)
{
    return "Hello, " . ucfirst($name) . "!";
}



function isUserActive($user)
{
    $response = [
        'status' => 0,
        'user' => $user
    ];
    if (isset($user->status)) {
        if ($user->status !== 1) {
            return $response;
        }
    }


    $relatedTable = ucfirst($user->role); // e.g., "Teacher", "Student", "Admin"

    // Special case for Superadmin
    if ($relatedTable === 'Superadmin') {
        $response['status'] = true;
        return $response;
    }

    $relatedModel = app("App\\Models\\{$relatedTable}");
    $record = $relatedModel::where('user_id', $user->id)->first();

    if (!$record || $record->status !== 1) {
        $user->status = $record->status;
        $response['status'] = 1;
        $response['user'] = $user;
        return $response;
    }

    $user->status = $record->status;

    $response['status'] = 1;
    $response['user'] = $user;

    return $response;
}
