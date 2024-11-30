<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Termwind\render;

class EmailStatController extends Controller
{
    public function index()
    {
        // $emails = EmailList::paginate(10);
        $emails = EmailList::select('id', 'name', 'subject', 'service', 'sent_from_email', 'sent_from_server', 'sent_from_site', 'summary')->orderBy('id','asc')
                        ->get();

        return view('admin.pages.dashboards.emails.index',  compact('emails'));
    }
}
