<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Share;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;

class HomeController extends Controller
{
  /**
  * The Patient repository instance.
  *
  * @var PatientRepository
  */
  protected $patients;

    /**
     * Create a new controller instance.
     *
     * @param PatientRepository $patients
     * @return void
     */
    public function __construct(PatientRepository $patients)
    {
        $this->middleware('auth');
        $this->patients = $patients;
    }

    /**
     * Display a list of all patients belongs to this user.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
      $sharePatients = collect([ ]);
      $user = Auth::user();
      $shares = Share::where('user_id', $user->id)->get();
      foreach ($shares as $share) {
        $sharePatient = Patient::find($share->patient_id);
        $sharePatients->push($sharePatient);
      }


      return view('home',[
        'patients' => $this->patients->forUser($request->user()),
        'sharePatients' => $sharePatients,
      ]);
    }
}
