<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Youth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NewAccountDetails extends Component
{
    #[Rule('required|numeric|unique:youths,national_id')]
    public $nid = ''; 
    #[Rule('required|numeric|unique:youths,phone|digits:10')]
    public $phone; 
    #[Rule('required|email|unique:users,email')]
    public $email; 
    #[Rule('required|confirmed|min:8')]
    public $password; 
    public $password_confirmation;

    public function saveData()
    {  
        $this->validate();
        // $client = new Client();      
        $response = Http::post('https://smarthrapi.mifotra.gov.rw/employees/getCitizen/'.$this->nid);
        $results = json_decode($response->getBody());

        if(empty($results)){
            $this->addError('nid', 'Invalid National ID');
            return;
        }
        $dob = Carbon::createFromFormat('d/m/Y',$results->dateOfBirth)->format('Y-m-d');
        $yrs = date_diff(date_create($dob), date_create('today'))->y;
        // dd($yrs);
        if($yrs < 18 OR $yrs > 35){
            $this->addError('nid', 'You are not eligible to register, Only Youth from 18 and 35 years are allowed to register');
            return;
        }

        $user = User::create([
            'name' => $results->foreName.' '.$results->surnames,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'Youth',
        ]);

        $youth = Youth::create([
            'phone' => $this->phone,
            'national_id' => $this->nid,
            'date_of_birth' => $dob,
            'province' => $results->province,
            'district' => $results->district,
            'sector' => $results->sector,
            'cell' => $results->cell,
            'user_id'=>$user->id,
        ]);

        Auth::attempt(['email' => $user->email, 'password' => $this->password]);

        return redirect()->route('filament.admin.pages.dashboard');
    }

    public function render()
    {
        return view('livewire.new-account-details');
    }
}
