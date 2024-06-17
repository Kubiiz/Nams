<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\SearchRequest;
use App\Models\Log;

class LogController extends Controller
{
    /**
     * Show Logs index page
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;
        $result = Log::with('user')->sortable()->paginate(10);

        if ($request) {
            $search = $request->input('search');

            $result = Log::whereAny([
                'note',
                'ip_address',
            ], 'LIKE', "%$search%");
        }

        return view('panel.logs.index', compact('result', 'search'));
    }
}
