<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    static function getTask($active, $client_id, $projet_id, $building_id, $stage_id, $room_id, $journal_id, $search, $paginate = 8){
        if ($active) {
            if ($client_id) {
                return Task::orderBy('priority_id', 'desc')->where('client_id', $client_id)->finished($search)->paginate($paginate);
            }
            if ($projet_id) {
                return Task::orderBy('priority_id', 'desc')->where('projet_id', $projet_id)->finished($search)->paginate($paginate);
            }
            if ($building_id) {
                return Task::orderBy('priority_id', 'desc')->where('building_id', $building_id)->finished($search)->paginate($paginate);
            }
            if ($stage_id) {
                return Task::orderBy('priority_id', 'desc')->where('stage_id', $stage_id)->finished($search)->paginate($paginate);
            }
            if ($room_id) {
                return Task::orderBy('priority_id', 'desc')->where('room_id', $room_id)->finished($search)->orderBy('priority_id', 'desc')->paginate($paginate);
            }
            if ($journal_id) {
                return Task::orderBy('priority_id', 'desc')->where('journal_id', $journal_id)->finished($search)->orderBy('priority_id', 'desc')->paginate($paginate);
            }
            return Task::finished($search)->paginate($paginate);
        } else {
            if ($client_id) {
                return Task::orderBy('priority_id', 'desc')->where('client_id', $client_id)->active($search)->paginate($paginate);
            }
            if ($projet_id) {
                return Task::orderBy('priority_id', 'desc')->where('projet_id', $projet_id)->active($search)->paginate($paginate);
            }
            if ($building_id) {
                return Task::orderBy('priority_id', 'desc')->where('building_id', $building_id)->active($search)->paginate($paginate);
            }
            if ($stage_id) {
                return Task::orderBy('priority_id', 'desc')->where('stage_id', $stage_id)->active($search)->paginate($paginate);
            }
            if ($room_id) {
                return Task::orderBy('priority_id', 'desc')->where('room_id', $room_id)->active($search)->paginate($paginate);
            }
            if ($journal_id) {
                return Task::orderBy('priority_id', 'desc')->where('journal_id', $journal_id)->active($search)->paginate($paginate);
            }
            return Task::orderBy('priority_id', 'desc')->active($search)->paginate($paginate);
        }
    }
    static function getTasklist($id, $type='', $search= '', $status = true){
        // return Task::all();
        if ($status) {
            if ($type == 'client_id') {
                return Task::orderBy('priority_id', 'desc')->where('client_id', $id)->finished($search)->get();
            }
            if ($type == 'projet_id') {
                return Task::orderBy('priority_id', 'desc')->where('projet_id', $id)->finished($search)->get();
            }
            if ($type == 'building_id') {
                return Task::orderBy('priority_id', 'desc')->where('building_id', $id)->finished($search)->get();
            }
            if ($type == 'stage_id') {
                return Task::orderBy('priority_id', 'desc')->where('stage_id', $id)->finished($search)->get();
            }
            if ($type == 'room_id') {
                return Task::orderBy('priority_id', 'desc')->where('room_id', $id)->finished($search)->orderBy('priority_id', 'desc')->get();
            }
            if ($type == 'journal_id') {
                return Task::orderBy('priority_id', 'desc')->where('journal_id', $id)->finished($search)->orderBy('priority_id', 'desc')->get();
            }
            return Task::finished($search)->get();
        } else {
            if ($type == 'client_id') {
                return Task::orderBy('priority_id', 'desc')->where('client_id', $id)->active($search)->get();
            }
            if ($type == 'projet_id') {
                return Task::orderBy('priority_id', 'desc')->where('projet_id', $id)->active($search)->get();
            }
            if ($type == 'building_id') {
                return Task::orderBy('priority_id', 'desc')->where('building_id', $id)->active($search)->get();
            }
            if ($type == 'stage_id') {
                return Task::orderBy('priority_id', 'desc')->where('stage_id', $id)->active($search)->get();
            }
            if ($type == 'room_id') {
                return Task::orderBy('priority_id', 'desc')->where('room_id', $id)->active($search)->get();
            }
            if ($type == 'journal_id') {
                return Task::orderBy('priority_id', 'desc')->where('journal_id', $id)->active($search)->get();
            }
            return Task::orderBy('priority_id', 'desc')->active($search)->get();
        }
    }
}


// if ($this->active) {
//     if ($this->client_id) {
//         return Task::orderBy('priority_id', 'desc')->where('client_id', $this->client_id)->finished($this->search)->paginate(8);
//     }
//     if ($this->projet_id) {
//         return Task::orderBy('priority_id', 'desc')->where('projet_id', $this->projet_id)->finished($this->search)->paginate(8);
//     }
//     if ($this->building_id) {
//         return Task::orderBy('priority_id', 'desc')->where('building_id', $this->building_id)->finished($this->search)->paginate(8);
//     }
//     if ($this->stage_id) {
//         return Task::orderBy('priority_id', 'desc')->where('stage_id', $this->stage_id)->finished($this->search)->paginate(8);
//     }
//     if ($this->room_id) {
//         return Task::orderBy('priority_id', 'desc')->where('room_id', $this->room_id)->finished($this->search)->orderBy('priority_id', 'desc')->paginate(8);
//     }
//     return Task::finished($this->search)->paginate(8);
// } else {
//     if ($this->client_id) {
//         return Task::orderBy('priority_id', 'desc')->where('client_id', $this->client_id)->active($this->search)->paginate(8);
//     }
//     if ($this->projet_id) {
//         return Task::orderBy('priority_id', 'desc')->where('projet_id', $this->projet_id)->active($this->search)->paginate(8);
//     }
//     if ($this->building_id) {
//         return Task::orderBy('priority_id', 'desc')->where('building_id', $this->building_id)->active($this->search)->paginate(8);
//     }
//     if ($this->stage_id) {
//         return Task::orderBy('priority_id', 'desc')->where('stage_id', $this->stage_id)->active($this->search)->paginate(8);
//     }
//     if ($this->room_id) {
//         return Task::orderBy('priority_id', 'desc')->where('room_id', $this->room_id)->active($this->search)->paginate(8);
//     }
//     return Task::orderBy('priority_id', 'desc')->active($this->search)->paginate(8);
// }
