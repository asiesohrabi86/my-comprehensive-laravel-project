<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketCategoryRequest;
use App\Models\Ticket\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    public function index()
    {
        $ticketCategories = TicketCategory::all();
        return view('admin.ticket.category.index', compact('ticketCategories'));
    }

    public function create()
    {
        return view('admin.ticket.category.create');
    }

    public function store(TicketCategoryRequest $request)
    {
        $inputs = $request->all();
        TicketCategory::create($inputs);
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی جدید با موفقیت ثبت شد');
    }

    public function edit(TicketCategory $ticketCategory)
    {
        return view('admin.ticket.category.edit', compact('ticketCategory'));
    }

    public function update(TicketCategoryRequest $request, TicketCategory $ticketCategory)
    {
        $inputs = $request->all();
        $ticketCategory->update($inputs);
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');
    }

    public function destroy(TicketCategory $ticketCategory)
    {
        $ticketCategory->delete();
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد');
    }

    public function status(TicketCategory $ticketCategory)
    {
        $ticketCategory->status = $ticketCategory->status === 0 ? 1 : 0;
        $result = $ticketCategory->save();

        if ($result) {
            if ($ticketCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            }else{
                return response()->json(['status' => true, 'checked' => true]);
            }  
        }else{
            return response()->json(['status' => false]);
        }
    }

}
