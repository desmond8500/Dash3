<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class Preferences extends Component
{
    public $settings;
    public $form = 0;

    public $dashboard;
    public $color;
    public $color1;
    public $color2;
    public $color3;
    public $year;

    function mount(){
        $this->settings = Setting::where('user_id', auth()->user()->id)->first();
        $this->dashboard = $this->settings->dashboard;
        $this->color = $this->settings->color;
    }

    public function render()
    {
        return view('livewire.settings.preferences',[
            'settings' => $this->settings,
        ]);
    }

    function init_settings(){
        Setting::create([
            'user_id'=> auth()->user()->id,
        ]);
    }

    function edit(){

    }

    function update(){
        $this->settings->dashboard = $this->dashboard;
        $this->settings->color = $this->color;
        $this->settings->year = $this->year;
        $this->settings->save();
        $this->reset('form');
    }
}
