<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Company;

use Illuminate\Validation\Rule;


use DB;


class EmployeesController extends Controller
{
    //
    public function getEmployeesPage(){
        return view('employees.employee');
    }

    public function saveEmployee(Request $request){
        $data = $request->all();
        
        if($data['employee_id'] == 0){
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'phone' => 'required',
            ]);
        }else{

            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
                'email' =>  [
                    'required',
                    Rule::unique('users')->ignore($data['employee_id']),
                ],
                'password' => 'required',
                'phone' => 'required',
            ]);

        }
        if($data['employee_id'] >=1){

            $employee = User::find($data['employee_id']);

            $employee->first_name = $data['first_name'];
            $employee->last_name = $data['last_name'];
            $employee->email = $data['email'];
            if($employee->password != $data['password']){
                $employee->password = Hash::make($data['password']);
            }else{
                $employee->password = Hash::make($data['password']);
            }
            $employee->company = $data['company'];
            $employee->phone = $data['phone'];

            $employee->save();

        }else{
            
            $employee =  User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'company' => $data['company'],
                'user_type' => 2,
                'phone' => $data['phone'],
            ]);
        }


        $statusCode = -1;
    	if($employee){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['employee'] = $employee;

    	return $data_response;

    }

    public function getEmployeeList(){
        $employee = User::where('user_type', 2)->get();
        $formattedList = array();
        if(count($employee) > 0){
            foreach($employee as $item){
                $tempArray = array();

                $tempArray['id'] = $item->id;
                $tempArray['first_name'] = $item->first_name;
                $tempArray['email'] =$item->email;
                $tempArray['last_name'] = $item->last_name;
                $tempArray['phone'] = $item->phone;
                $tempArray['company_name'] = $this->getcompanyName($item->company);
                $tempArray['company_id'] = $item->company;
                $tempArray['password'] = $item->password;

                array_push($formattedList , $tempArray);
            }
        }
        return $formattedList;
    }

    public function delEmployee(Request $request){
        $data = $request->all();

        $employee = User::find($data['id']);
        $statusCode = -1;
    	if($employee){
            $employee->delete();
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['employee'] = $employee;

    	return $data_response;
    }

    public function getcompanyName($id){
        $name = '';
        $companyName = Company::find($id);
        if($companyName){
            $name = $companyName->name;
        }
        return $name;
    }
}

// $2y$10$sMBMWI6.I2A87GOoA6x.M.ZPFYsJwFpohX2l.KHspKjfdAmiwtmHK