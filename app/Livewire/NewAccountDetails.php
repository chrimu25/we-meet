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
    #[Rule('required|date|after_or_equal:1980-01-01|before_or_equal:2006-01-01')]
    public $date_of_birth = ''; 
    #[Rule('required|string|in:Kigali,Eastern,Northern,Western,Southern')]
    public $province = ''; 
    #[Rule('required|string|min:5|max:80')]
    public $names = ''; 
    #[Rule('required|string|min:3|max:20')]
    public $district = ''; 
    #[Rule('required|string|min:3|max:20')]
    public $sector = ''; 
    #[Rule('required|string|min:3|max:20')]
    public $cell = ''; 
    #[Rule('required|email|unique:users,email')]
    public $email; 
    #[Rule('required|confirmed|min:8')]
    public $password; 
    public $password_confirmation;

    public function saveData()
    {  
        $this->validate();
        // $client = new Client();      
        // $response = Http::post('https://smarthrapi.mifotra.gov.rw/employees/getCitizen/'.$this->nid);
        // $results = json_decode($response->getBody());

        // if(empty($results)){
        //     $this->addError('nid', 'Invalid National ID');
        //     return;
        // }
        // $dob = Carbon::createFromFormat('d/m/Y',$results->dateOfBirth)->format('Y-m-d');
        // $yrs = date_diff(date_create($dob), date_create('today'))->y;
        
        // if($yrs < 18 OR $yrs > 35){
        //     $this->addError('nid', 'You are not eligible to register, Only Youth from 18 and 35 years are allowed to register');
        //     return;
        // }

        $user = User::create([
            'name' => $this->names,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'Youth',
        ]);

        $user->youthDetails()->create([
            'phone' => $this->phone,
            'national_id' => $this->nid,
            'date_of_birth' => $this->date_of_birth,
            'province' => $this->province,
            'district' => $this->district,
            'sector' => $this->sector,
            'cell' => $this->cell
        ]);

        // dd($user, $user->youthDetails);

        Auth::attempt(['email' => $user->email, 'password' => $this->password]);

        return redirect()->route('filament.admin.pages.dashboard');
    }

    public function render()
    {
        return view('livewire.new-account-details');
    }
}
