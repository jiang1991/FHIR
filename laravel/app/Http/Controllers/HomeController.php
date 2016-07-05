<?php

namespace App\Http\Controllers;

use App\Patient;
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
        return view('home',[
          'patients' => $this->patients->forUser($request->user()),
        ]);
    }
}
