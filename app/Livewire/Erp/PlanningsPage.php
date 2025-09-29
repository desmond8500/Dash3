<?php

namespace App\Livewire\Erp;

use Livewire\Attributes\On;
use Livewire\Component;
use Zap\Exceptions\ScheduleConflictException;
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
            'schedules' =>  $this->get_schedules(),
        ]);
    }

    #[On('get-schedules')]
    function get_schedules(){
        return auth()->user()->schedules;
    }

    function add_rv(){
        $user = auth()->user();

        try {
            $schedule = Zap::for($user)
                ->named('Visite')
                ->description('Installation')
                ->from('2025-09-30')
                ->addPeriod('09:00', '10:00')
                ->noOverlap()
                ->save();

        } catch (ScheduleConflictException $e) {

            // Gestion élégante du conflit

            $conflicts = $e->getConflictingSchedules();

            $this->js("alert('Conflit')");
        }

    }
}
