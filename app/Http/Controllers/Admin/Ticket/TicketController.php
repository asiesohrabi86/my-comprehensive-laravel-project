<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use App\Http\Requests\Admin\Ticket\TicketRequest;

class TicketController extends Controller
{

    public function newTickets(){
        $tickets = Ticket::where('seen', 0)->get();
        foreach($tickets as $ticket){
            $ticket->seen = 1;
            $ticket->save();
        }
        return view('admin.ticket.index', compact('tickets'));
    }

    public function openTickets(){
        $tickets = Ticket::where('status', 0)->get();
        return view('admin.ticket.index', compact('tickets'));
    }

    public function closeTickets(){
        $tickets = Ticket::where('status', 1)->get();
        return view('admin.ticket.index', compact('tickets'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        
        return view('admin.ticket.show', compact('ticket'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function answer(TicketRequest $request, Ticket $ticket)
    {
        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['status'] = 0;
        $inputs['seen'] = 1;
        $inputs['reference_id'] = $ticket->reference_id;
        $inputs['user_id'] = 1;
        $inputs['category_id'] = $ticket->category_id;
        $inputs['priority_id'] = $ticket->priority_id;
        $inputs['ticket_id'] = $ticket->id;
        
        Ticket::create($inputs);
        return redirect()->route('admin.ticket.index')->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }

    public function change(Ticket $ticket)
    {
        $ticket->status = $ticket->status === 1 ? 0 : 1;
        $result = $ticket->save();
        if($result){
            if($ticket->status == 1){
                return redirect()->route('admin.ticket.index')->with('swal-success', 'تیکت شما با موفقیت بسته شد');
            }else{
                return redirect()->route('admin.ticket.index')->with('swal-success', 'تیکت شما با موفقیت باز شد');
            }
        }else{
            return redirect()->route('admin.ticket.index')->with('swal-error', 'خطایی پیش آمد');
        }
        
    }

}
