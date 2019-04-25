<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;

/**
 * Class AutocompleteController
 *
 * @package \App\Http\Controllers
 */
class AutoCompleteController extends Controller
{
    public function getUsers(Request $request, UserRepository $userRepository)
    {
        $term = $request->get('term');
        $users = $userRepository->getAutoCompleteUsers($term, 50);

        // select2 data format
        return response()->json(['results' => $users]);
    }
}
