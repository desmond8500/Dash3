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
    public $size;

    function mount(){
        $this->settings = Setting::where('user_id', auth()->user()->id)->first();
        if(!$this->settings){
            $this->init_settings();
            $this->settings = Setting::where('user_id', auth()->user()->id)->first();
        }
        $this->dashboard = $this->settings->dashboard ?? 1;
        $this->color = $this->settings->color ??  "#4e73df"; ;
        $this->size = $this->settings->size ??  "container-xl"; ;
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
        $this->settings->size = $this->size;
        $this->settings->save();
        $this->reset('form');
    }
}
