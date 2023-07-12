<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeInformation;
use App\Models\EmployeeWorkingSite;
use App\Models\WorkingSite;
use Illuminate\Support\Str;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$employees = EmployeeInformation::paginate(5);
        $sites = WorkingSite::all();
        //$findSite = WorkingSite::find($employeeSite->working_site_id);
        $getEmployee = DB::table('employee_information AS ei')
        ->join('employee_working_sites AS ews', 'ews.employee_information_id', '=', 'ei.id')
        ->join('working_sites AS ws', 'ws.id', '=', 'ews.working_site_id')
        ->select('ei.*', 'ews.*', 'ws.*')
        ->get();

        //dd($getEmployee);



        //dd($getEmployee);
        // $employeeSite = EmployeeWorkingSite::find($id);
        // $findSite = WorkingSite::find($employeeSite->working_site_id);
        // dd($findSite);
        // $employees = Employee::paginate(15)->withQueryString();
        // $employees = DB::table('employee_info')->simplePaginate(1);
        //dd($site);
        return view('employee-management.employees', ['getEmployee' => $getEmployee, 'sites' => $sites]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = WorkingSite::all();

        return view('employee-management.createEmployee', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $uuid = Str::uuid()->toString();
        // Validate the form data
        //dd($request->all());
        $validatedData = $request->validate([
            'firstName' => 'required|min:2|max:24',
            'middleName' => 'nullable',
            'lastName' => 'required|min:2|max:24',
            'gender' => 'required',
            'jobTitle' => 'required|min:2|max:100',
            'dailyRate' => 'required|numeric|min:2|max:6',
            'address' => 'required',
            'contactNumber' => 'required|min:11|max:11',
        ]);
        //dd($validatedData);
        // Create a new Employee instance with the validated data
        $employee = new EmployeeInformation();
        $employee->employee_uuid = $uuid;
        $employee->first_name = $validatedData['firstName'];
        $employee->middle_name = $validatedData['middleName'];
        $employee->last_name = $validatedData['lastName'];
        $employee->gender = $validatedData['gender'];
        $employee->job_title = $validatedData['jobTitle'];
        $employee->daily_rate = $validatedData['dailyRate'];
        $employee->address = $validatedData['address'];
        $employee->contact_number = $validatedData['contactNumber'];
        
        // Save the employee to the "users" table
        $employee->save();

        // Redirect the user back to the form page or to a success page
        return redirect()->back()->with('success','Employee added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd($id);
        $employee = EmployeeInformation::find($id);
        $sites = WorkingSite::all();
        $findSite = WorkingSite::find($id);
        

        return view('employee-management.viewEmployee', compact('employee', 'sites', 'findSite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd($id);
        $employee = EmployeeInformation::find($id);
        //dd($employee->id);
        $sites = WorkingSite::all();
        //$employeeSite = EmployeeWorkingSite::find($id);
        //dd($employeeSite->id);
        $findSite = WorkingSite::find($id);
        //$findSiteExcept = WorkingSite :: whereNotIn('site_name', [$findSite->site_name]);
        // dump($employee);
        //dd($findSite);
        return view('employee-management.editEmployeeInformation', compact('employee', 'sites', 'findSite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $employee = EmployeeInformation::findorfail($id);
        $employeeSite = EmployeeWorkingSite::find($id);
        // Validate the form data
        $validatedData = $request->validate([
            'firstName' => 'required|min:2|max:24',
            'middleName' => 'required',
            'lastName' => 'required|min:2|max:24',
            'gender' => 'required',
            'working_site'=>'required',
            'jobTitle' => 'required|min:2|max:100',
            'dailyRate' => 'required|numeric|min:2',
            'address' => 'required',
            'contactNumber' => 'required|min:11|max:11',
            // Add validation rules for other fields
        ]);
        //dd($request);
        // Update the employee data with the validated form data
        $employee->first_name = $validatedData['firstName'];
        $employee->middle_name = $validatedData['middleName'];
        $employee->last_name = $validatedData['lastName'];
        $employee->gender = $validatedData['gender'];
        $employeeSite->working_site_id = $validatedData['working_site'];
        $employee->job_title = $validatedData['jobTitle'];
        $employee->daily_rate = $validatedData['dailyRate'];
        $employee->address = $validatedData['address'];
        $employee->contact_number = $validatedData['contactNumber'];
        // Update other fields with the validated form data

        // Save the updated employee record
        // dump($employeeSite);
        // dd($employee);
        $employeeSite->save();
        $employee->save();

        //Redirect the user back to the employee list or show a success message
        return redirect()->route('employees.list')->with('success', $employee->first_name . ' ' . $employee->last_name . ' information updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    //Changes: New method for adding site 
    public function addSite(Request $request)
    {
        $validatedData = $request->validate([
            'empID' => 'required',
            'working_site' => 'required',
        ]);
        $getEmployee = EmployeeInformation::join('employee_working_sites as ews', 'employee_information.id', '=', 'ews.employee_information_id')
            ->where('ews.employee_information_id', $validatedData['empID'])
            ->first();
        //dd($getEmployee);
        $duplicateSite = EmployeeWorkingSite::where('employee_information_id', $validatedData['empID'])->first();
        if ($duplicateSite) {
            return redirect()->back()->with('error', $getEmployee->first_name . ' ' . $getEmployee->last_name . ' ' . ' is already asssigned to a Site!');
        }
        $empSite = new EmployeeWorkingSite();
        $empSite->employee_information_id = $validatedData['empID'];
        $empSite->working_site_id = $validatedData['working_site'];
        $empSite->save();

        // // Redirect the user back to the form page or to a success page
        return redirect()->back()->with('success', 'Employee Site Added successfully!');
    }
}
