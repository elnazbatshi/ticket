<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\ticketMail;
use App\Priority;
use App\Ticket;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Notifications\CommentEmailNotification;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use MediaUploadingTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $id = auth()->user()->id;
        $roles=auth()->user()->roles->pluck('title')->toArray();
        $user = User::with('category_customer')->findOrFail($id);
        $priorities = Priority::all();

        if ($roles){

            $categories = $user->category_customer;
        }else{

            $categories= Category::where('id',1)->get();

        }
        return view('tickets.create', compact('categories', 'priorities'));
    }


    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);
        $author_id = auth()->user()->id;
        $customerEmail = auth()->user()->email;
        $request->request->add([
            'status_id' => 1,
            'author_id' => $author_id,
            'priority_id' => $request->priority_id
        ]);


        if ($request->category_id == 1) {

            $agents = User::whereHas('roles', function ($query) {
                return $query->where('title', 'Admin');
            })->get()->pluck('email');

        } else {

            $agents = Category::with('agents')->findOrFail($request->category_id)->agents->pluck('email');
        }


        $categoryName = Category::find($request->category_id);


        Mail::send(new ticketMail($customerEmail, $agents, $categoryName, $request));
        $ticket = Ticket::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
        }

        return redirect()->back()->withStatus('تیکت شما با موفقیت ارسال شد<a href="' . route('tickets.show', $ticket->id) . '">پیش نمایش </a>');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('comments');

        return view('tickets.show', compact('ticket'));
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment_text' => 'required'
        ]);

        $comment = $ticket->comments()->create([
            'author_name' => $ticket->author_name,
            'author_email' => $ticket->author_email,
            'comment_text' => $request->comment_text
        ]);

        $ticket->sendCommentNotification($comment);

        return redirect()->back()->withStatus('پیام شما با موفقیت ثبت شد');
    }
}
