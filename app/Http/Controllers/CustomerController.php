<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        // dd($customers);
        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User([
            'name' => $request->fname . ' ' . $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->input('password')),
        ]);
        $user->save();
        $customer = new Customer();
        $customer->user_id = $user->id;

        $customer->lname = $request->lname;
        $customer->fname = $request->fname;
        $customer->addressline = $request->addressline;

        $customer->zipcode = $request->zipcode;
        $customer->phone = $request->phone;
        $customer->town = $request->town;
        $files = $request->file('uploads');
        $customer->image_path = 'storage/images/' . $files->getClientOriginalName();
        $customer->save();

        Storage::put(
            'public/images/' . $files->getClientOriginalName(),
            file_get_contents($files)
        );

        return response()->json([
            "success" => "customer created successfully.",
            "customer" => $customer,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with('user')->where('customer_id', $id)->first();
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $user = User::where('id', $customer->user_id)->first();
        $user->name = $request->fname . ' ' . $request->lname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $customer->user_id = $user->id;

        $customer->lname = $request->lname;
        $customer->fname = $request->fname;
        $customer->addressline = $request->addressline;

        $customer->zipcode = $request->zipcode;
        $customer->phone = $request->phone;
        $customer->town = $request->town;
        $files = $request->file('uploads');
        $customer->image_path = 'storage/images/' . $files->getClientOriginalName();
        $customer->save();

        Storage::put(
            'public/images/' . $files->getClientOriginalName(),
            file_get_contents($files)
        );

        return response()->json([
            "success" => "customer updated successfully.",
            "customer" => $customer,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id)->first();
        Customer::destroy($id);
        User::where('id', $customer->user_id)->delete();
        return response()->json(['message' => 'customer deleted']);
    }
}