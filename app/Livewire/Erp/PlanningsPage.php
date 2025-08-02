<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Zap\Facades\Zap;
use Zap\Models\Schedule;

class PlanningsPage extends Component
{
    public function render()
    {
        return view('livewire.erp.plannings-page',[
            'rvs' => auth()->user()->appointmentSchedules()->get(),
            'rvs2' => auth()->user()->availabilitySchedules()->get(),
            'availability' => Schedule::availability()->get(),
            'appointments' => Schedule::appointments()->get(),
            'blocked' => Schedule::blocked()->get(),
            'schedule' => Schedule::all(),
        ]);
    }

    function add_rv(){
        $user = auth()->user();

        $schedule = Zap::for($user)
            ->named('Visite')
            ->description('Installation')
            ->from('2025-07-30')
            ->addPeriod('09:00', '10:00')
            ->save();
    }
}
