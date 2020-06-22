<?php

namespace App\http\Controllers\Test;

use Storage;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Upload_file;

/**
 * 
 */
class UploadController extends Controller
{
	
	// upload portal
	public function upload(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;

		if (!$request->hasFile('file')) {
			$response["status"] = "error";
			$response["error"] = "file not exists";

			return response($response, 500)
			->header('Content-Type', 'application/json+fhir');
		}

		$file = $request->file('file');
		$param = $request->input('param', ' ');

		if (!$file->isValid()) {
			$response["status"] = "error";
			$response["error"] = "file upload error";

			return response($response, 500)
			->header('Content-Type', 'application/json+fhir');
		}

		$file_name = $file->getClientOriginalName();
		$file_extension = $file->getClientOriginalExtension();
		$file_size = $file->getClientSize();

		$dir = "/var/www/laravel/storage/attachments/uploads/";
		$folder = date("Ymd");
		// Storage::makeDirectory("uploads/".$folder);
		/**
		*
		* dir: uploads/.$folder
		* file_name: $id.'_'.$file_name
		*/

		// save to sql
		$upload_file = new Upload_file;
		$upload_file->user_id = $user_id;
		$upload_file->file_name = $file_name;
		$upload_file->file_size = $file_size;
		$upload_file->folder = $folder;
		$upload_file->param = $param;
		$upload_file->save();

		$id = $upload_file->id;

		// move file
		$file->move($dir.$folder, $id.'_'.$file_name);


		$response["status"] = "ok";
		$response["fileSize"] = $file_size;
		$response["fileName"] = $file_name;

		return response($response)
			->header('Content-Type', 'application/json+fhir');
	}


	// get upload history list
	public function query() {

		$upload_files = Upload_file::where("id", ">=", 1)->orderBy('id', 'desc')->take(50)->get();
		return view('test', [
			'upload_files' => $upload_files,
		]);
	}


	// download file
	public function download($id)
	{
		$file = Upload_file::findOrFail($id);

		$file_name = $file->file_name;

		return response()->download("/var/www/laravel/storage/attachments/uploads/".$file->folder."/".$file->id."_".$file_name, $file_name);
	}
}

?>