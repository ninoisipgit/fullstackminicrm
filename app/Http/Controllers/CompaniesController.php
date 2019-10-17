<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;

use Image;
use File;



class CompaniesController extends Controller
{
    //getCompaniesPage

    public function getCompaniesPage(){
        return view('companies.company');
    }

    public function saveCompany(Request $request){
        $data = $request->all();
        $request->validate([
            'name' => 'required',
        ]);

        $errorUploads = array();
        $errFileNameSize = 'Not Uploaded : ';
        if(isset($data['logo'])){
            $file = $request->file('logo'); 
            $tmpArray = array();
            $errCtr = 0;
            // if(explode('/', $file->getClientMimeType())[0] == 'image'){
                $file = $this->getLogoImageUploadData($file,$data);
            // }else{
                // $file = $this->getfileUploadData($file,$data);
            // }

            $data['logo'] = $file;

        }

        $data_response = array();
        if(count($errorUploads) <= 0){
            $company =  Company::create([
                'name' => $data['name'],
                'website' => $data['website'],
                'email' => $data['email'],
                'file_name' => $data['logo']['file_name'],
                'file_path' => $data['logo']['file_path'],
                'file_mime' => $data['logo']['file_extension'],
            ]);
            if($company){
                if(isset($data['logo'])){
                    $file = $request->file('logo');
                    // if(explode('/', $file->getClientMimeType())[0] == 'image'){
                        $this->imageUploadLogo($file,$data);
                    // }else{
                        // $this->fileUpload($file,$data);
                    // }
                }

            }
        }else{
            $data_response['error_msg'] = $errFileNameSize;
        }

        $statusCode = -1;
    	if($company){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['company'] = $company;

    	return $data_response;

    }

    public function getLogoImageUploadData($request,$data){
        $filename = "";
        $imageFile = "";
        $extension = "";
        $imageName = "";
        
        $file = $request;
        if($file != null){
            $file_size = $file->getSize();

            $extension = $file->getClientOriginalExtension($file->getClientMimeType());
            $imageName = pathinfo($request->getClientOriginalName(), PATHINFO_FILENAME);;
            if($extension != null){
                $newName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('-', '_', $newName);
                
                $filename = $imageName.".".$extension;
                if($filename != null){
                    $pathSmall = $this->getImagePathForCompanyLogo();
                    if($pathSmall == null){
                        $pathSmall = $this->createImagePathForCompanyLogo();
                    }
                    $result = "ok";

                    $path = $this->getImagePathForCompanyLogo();
                    $filePath = $path.$filename;
                }
            }
        }

        $data = array(
            'file_filename' => $filename,
            'file_path' => $filePath,
            'file_extension' => $extension,
            'file_name' => $filename,
            'file_size' => $file_size,
            'file_type' => 'image',
        );

        return $data;
    }



    public function imageUploadLogo($fileUpload, $data){
        $filename = "";
        $imageFile = "";
        $extension = "";
        $imageName = "";
        // dd($data['counter']);

        $file = $fileUpload;
        if($file != null){
            $file_size = $file->getSize();

            $extension = $file->getClientOriginalExtension($file->getClientMimeType());
            
            $imageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);;
            if($extension != null){
                $newName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('-', '_', $newName);
                
                $filename = $imageName.".".$extension;
                if($filename != null){
                    $pathSmall = $this->getImagePathForCompanyLogo();
                    if($pathSmall == null){
                        $pathSmall = $this->createImagePathForCompanyLogo();
                    }
                    
                    $result = "ok";

                    $smallWidht = 250;
                    $smallHeight = 250;

                    $saveFlag = true;
                    if($pathSmall != null){
                        $imageSmall = Image::make($file->getRealPath());
                        $imageSmall->save($pathSmall.$filename,100);
                    } else {
                        $saveFlag = false;
                    }

                    if($saveFlag){
                        $result = "ok";

                        $path = $this->getImagePathForCompanyLogo();
                        $filePath = $path.$filename;
                    }
                }
            }
        }
        $data = array(
            'file_filename' => $filename,
            'file_path' => $imageFile,
            'file_extension' => $extension,
            'file_name' => $imageName,
        );

        return $data;
    }


    public static function getImagePathForCompanyLogo(){
        $folder_path = "LOGO/";
        if(self::checkPath($folder_path)){
            $path = ("LOGO/");
            return $path;
        }else{
            return false;
        }
    }

    public static function createImagePathForCompanyLogo(){
        $path = null;
        $base_path = public_path("LOGO/");
        $path = $base_path;

        if(File::makeDirectory($path, 0777, true, true)){
            return $path;
        }else{
            return null;
        }  
    }

    public static function checkPath($path){
        if(file_exists($path)){
            return true;
        }
        else{
            return false;
        }
    }

    public function getCompanyList(){
        $company = Company::all();
        $formattedList = array();
        if(count($company) > 0){
            foreach($company as $item){
                $tempArray = array();
                $tempArray['id'] = $item->id;
                $tempArray['name'] = $item->name;
                $tempArray['website'] =$item->website;
                $tempArray['email'] = $item->email;
                $tempArray['file_path'] = $item->file_path;
                $tempArray['file_name'] = $item->file_name;
                array_push($formattedList , $tempArray);
            }
        }
        return $formattedList;
    }

    public function delCompany(Request $request){
        $data = $request->all();

        $filePlag = false;
        if(File::exists($data['filepath'])) {
            File::delete($data['filepath']);
            $filePlag = true;
        }

        $fileFlagDb = false;
        $company = Company::find($data['id']);
    	if($company){
            $company->delete();
            $fileFlagDb = true;
        }
        
        $statusCode = -1;
    	if($fileFlagDb ||  $filePlag){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;

    	return $data_response;

    }
}
