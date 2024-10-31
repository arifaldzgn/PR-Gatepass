<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\gatePassTicket;
use App\Models\gatePassRequest;
use Illuminate\Support\Facades\Storage;


class GatePassController extends Controller
{

    public function searchGatepass()
    {
        return view('searchGatepass');
    }

    //
    public function index(Request $request)
    {
        $request->session()->put('menu', 'gatepass');

        $userRole = auth()->user()->role;
        $userId = auth()->user()->id;
        if($userRole === 'admin' or $userRole === 'hod' or $userRole === 'hod2' or $userRole === 'security')
        {
            return view('gatepass', [
                'data' => GatePassTicket::all()
            ]);
        }
        else{
            return view('gatepass', [
                'data' => GatePassTicket::where('user_id', $userId)->get()
            ]);
        }
    }

    public function gatepassPending()
    {
        $userRole = auth()->user()->role;
        $userId = auth()->user()->id;
        if($userRole === 'admin' or $userRole === 'hod' or $userRole === 'hod2')
        {
            return view('gatepassPending', [
                'data' => GatePassTicket::where('status', 'Pending')->get()
            ]);
        }
        else{
            return view('gatepassPending', [
                'data' => GatePassTicket::where('status', 'Pending')->where('user_id', $userId)->get()
            ]);
        }


    }

    public function gatepassApproved()
    {
        return view('gatepassApproved', [
            'data' => GatePassTicket::where('status', 'Approved')->get()
        ]);
    }

    public function gatepassRejected()
    {
        $userRole = auth()->user()->role;
        $userId = auth()->user()->id;

        if($userRole === 'admin' or $userRole === 'hod' or $userRole === 'hod2')
        {
            return view('gatepassRejected', [
                'data' => GatePassTicket::where('status', 'Rejected')->get(),
            ]);
        }else{
            return view('gatepassRejected', [
                'data' => GatePassTicket::where('status', 'Rejected')->where('user_id', $userId)->get(),
            ]);
        }


    }

    public function gatepassPrinted($ticket)
    {
        // Find the GatePassTicket with the given ticket number
        $dataT = GatePassTicket::where('ticket', $ticket)->first();

        // If no ticket is found, $dataT will be null
        if (!$dataT) {
            // You can handle this situation by throwing an exception or returning a response
            // For example, throwing a 404 Not Found exception:
            abort(404, 'Ticket not found');
        }

        // If ticket exists, proceed to fetch related data
        $dataR = $dataT->gatePassRequest;

        // Pass the data to the view
        return view('gatepassPrint', [
            'dataT' => $dataT,
            'dataR' => $dataR
        ]);
    }

    public function gatepassEdit($ticket)
    {

        $dataT = GatePassTicket::where('ticket', $ticket)->get()->first();
        // dd($dataT->gatePassRequest);
        return view('gatepassEdit', [
            'dataT' => $dataT,
            'dataR' => $dataT->gatePassRequest,
            'userRole' => auth()->user()->role
        ]);
    }

    public function gatepassVerif($ticket)
    {
        $dataT = GatePassTicket::where('ticket', $ticket)->get()->first();
        // dd($dataT->gatePassRequest);
        return view('gatepassVerif', [
            'dataT' => $dataT,
            'dataR' => $dataT->gatePassRequest,
        ]);
    }



    public function gatepassUpdate(Request $request)
    {



        // Get action
        $action = $request->action;

        $validatedData = $request->validate([
            // Ticket
            'company_name' => 'required',
            'company_address' => 'required',
            'company_employee' => 'required',
            'company_vehno' => 'required',
            // Items
            'pr_request.*.quantity' => 'required',
            'pr_request.*.unit' => 'required',
            'pr_request.*.desc' => 'required',
            'pr_request.*.remark' => 'required',

        ]);

        // dd($request);


        $userId = auth()->user()->id;
        // $hodId = User::find($userId)->deptList->user_hod_id;

        $newTicket = gatePassTicket::find($request->ticket_id);
        // dd($request->ticket_id);

        $newTicket->company_name = $request->company_name;
        $newTicket->company_address = $request->company_address;
        $newTicket->company_employee = $request->company_employee;
        $newTicket->company_vehno = $request->company_vehno;
        $newTicket->save();

        foreach($request->pr_request as $prQ)
        {

            $newRequest = gatePassRequest::find($prQ['id']);
            $newRequest->update([
                'quantity' => $prQ['quantity'],
                'unit' => $prQ['unit'],
                'desc' => $prQ['desc'],
                'remark' => $prQ['remark'],
                'company_item' => $prQ['company_item'],
                'note' => $prQ['note'],
            ]);

            $ticketStatus = gatePassTicket::find($request->ticket_id);
            switch ($action) {
                case 'save':
                        $ticketStatus->status = 'Pending';
                    break;
                case 'reject':
                        $ticketStatus->status = 'Rejected';
                    break;
                case 'security_approve':
                        $ticketStatus->status = 'Approved';
                        if($ticketStatus->approved_user_id != null){
                            $ticketStatus->checked_by = auth()->user()->id;
                            $ticketStatus->date_verify = date('Y-m-d');
                        }
                    break;
                case 'manager_approve':
                        $ticketStatus->status = 'Approved';
                        $ticketStatus->date_approval = date('Y-m-d');
                        $ticketStatus->approved_user_id = auth()->user()->id;
                    break;
                default:
                    break;
            }
            $ticketStatus->save();
        }

        if($newTicket->save())
        {
            $request->session()->flash('alert-success', 'Gate pass update successfully.');
        }else{
            $request->session()->flash('alert-failed', 'Gate pass update fail.');
        }

        return redirect()->back();

    }

    public function gatepassDelete($ticket)
    {
        $deleteRequest = gatePassTicket::findOrFail($ticket);
        $deleteRequest->delete();
    }

    public function gatepassUpdate2(Request $request)
    {
        $validatedData = $request->validate([
            // 'pr_request.*.id' => 'required|integer',
            'pr_request.*.checked_image_url.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // dd($validatedData);

        foreach($request->pr_request as $prQ) {
            if (!isset($prQ['id'])) {
                continue; // or handle the error as needed
            }

            $newRequest = gatePassRequest::find($prQ['id']);
            if (!$newRequest) {
                continue; // Handle case where no request is found
            }

            // Handle image upload
            $imageUrls = [];
            if (isset($prQ['checked_image_url'])) {
                foreach ($prQ['checked_image_url'] as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imageUrls[] = Storage::url($imagePath);
                }
            }

            $newRequest->checked_image_url = json_encode($imageUrls);
            $newRequest->save();
        }

        $updateTicket = gatePassTicket::find($request->ticket_id);
        if ($updateTicket) {
            $updateTicket->checked_user_id = auth()->user()->id;
            $updateTicket->status = 'Approved';
            $updateTicket->save();
        }

        return redirect()->back();
    }


    public function create_gatepass(Request $request)
    {
        // dd($request);
        try {
            $validatedData = $request->validate([
                // Ticket
                'company_name' => 'required|min:1',
                'company_address' => 'required|min:1',
                'company_employee' => 'required|min:1',
                'company_vehno' => 'required|min:1',
                // Items
                'pr_request.*.quantity' => 'required|min:1',
                'pr_request.*.unit' => 'required|min:1',
                'pr_request.*.desc' => 'required',
                'pr_request.*.remark' => 'required',
                'pr_request.*.company_item' => 'required',
                // Image
                'pr_request.*.image_url.*' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Adjust max size as needed
            ]);

            $userId = auth()->user()->id;
            // $hodId = User::find($userId)->deptList->user_hod_id;

            // Ticket number generator
            $lastTicket = gatePassTicket::orderBy('ticket', 'desc')->first();
            $newTicketNumber = $lastTicket ? $lastTicket->ticket + 1 : 1; // If no ticket found, start from 1

            // Create the ticket
            $newTicket = gatePassTicket::create([
                'ticket' => $newTicketNumber,
                'user_id' => $userId,
                'approved_user_id' => null, //~
                'checked_user_id' => null, //~
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_employee' => $request->company_employee,
                'company_vehno' => $request->company_vehno,
                'status' => 'Pending',
            ]);

            foreach ($validatedData['pr_request'] as $prQ) {

                // Handle image upload
                $imageUrls = [];
                if (isset($prQ['image_url'])) {
                    foreach ($prQ['image_url'] as $image) {
                        $imagePath = $image->store('images', 'public'); // Store image in storage/app/public/images
                        $imageUrls[] = Storage::url($imagePath);
                    }
                }

                $prQ['ticket_id'] = $newTicket->id;

                // Insert data into gate_pass_requests
                gatePassRequest::create([
                    'quantity' => $prQ['quantity'],
                    'unit' => $prQ['unit'],
                    'desc' => $prQ['desc'],
                    'remark' => $prQ['remark'],
                    'ticket_id' => $prQ['ticket_id'],
                    'company_item' => $prQ['company_item'],
                    'image_url' => json_encode($imageUrls) ?? null, // Ensure image_url is set or default to null
                ]);

            }

            return response()->json(['message' => 'New Request Successfully added']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
