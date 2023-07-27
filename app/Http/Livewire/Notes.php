<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notes extends Component
{

    public $notes, $users, $title, $content,$deadline, $user_id, $note_id;
    public $isOpen = 0;
    public function render()
    {
         // Cek apakah pengguna yang sedang masuk memiliki peran dengan ID 1 (admin)
         $isAdmin = Auth::check() && Auth::user()->role_id === 1;

         // Jika admin, maka ambil semua catatan dan semua pengguna
         if ($isAdmin) {
             $this->notes = Note::all();
             $this->users = User::all();
         } else {
             // Jika bukan admin, ambil hanya catatan yang sesuai dengan user_id pengguna yang sedang masuk
             $this->notes = Note::where('user_id', Auth::user()->id)->get();
         }
        return view('livewire.notes');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->content = '';
        $this->note_id = '';
    }
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
   
        // Cek apakah user sedang login dan merupakan admin
    $isAdmin = Auth::check() && Auth::user()->role_id === 1;

    if ($this->note_id) {
        // Jika $note_id ada, maka proses update catatan berdasarkan ID yang ada
        $note = Note::findOrFail($this->note_id);

        // Pastikan hanya admin atau pemilik catatan yang dapat melakukan edit
        if ($isAdmin || $note->user_id === Auth::id()) {
            $note->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
            session()->flash('message', 'Post Updated Successfully.');
        } else {
            session()->flash('message', 'You are not authorized to edit this post.');
        }
    } else {
        // Jika tidak ada $note_id, maka proses membuat catatan baru
        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        // Tetapkan 'user_id' sesuai dengan user yang sedang login jika bukan admin
        if (!$isAdmin) {
            $data['user_id'] = Auth::id();
        }

        Note::create($data);
        session()->flash('message', 'Post Created Successfully.');
    }

    $this->closeModal();
    $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $this->note_id = $id;
        $this->title = $note->title;
        $this->content = $note->content;
    
        $this->openModal();
    }
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Note::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
