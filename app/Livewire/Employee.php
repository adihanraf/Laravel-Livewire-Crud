<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employee_id;


    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama wajib di isi',
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak sesuai',
            'alamat.required' => 'Alamat wajib di isi'
        ];

        $validated = $this->validate($rules, $pesan);
        ModelsEmployee::create($validated);
        session()->flash('message', 'Data berhasil di masukkan');

        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama wajib di isi',
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak sesuai',
            'alamat.required' => 'Alamat wajib di isi'
        ];

        $validated = $this->validate($rules, $pesan);
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);
        session()->flash('message', 'Data berhasil di update');

        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';

        $this->updateData = false;
        $this->employee_id = '';
    }

    public function delete()
    {
        $id = $this->employee_id;
        ModelsEmployee::find($id)->delete();
        session()->flash('message', 'Data berhasil di hapus');
        $this->clear();

    }

    public function delete_confirmation($id)
    {
        $this->employee_id = $id;
    }

    public function render()
    {
        $data = ModelsEmployee::orderBy('nama', 'asc')->paginate(5);
        return view('livewire.employee', ['dataEmployees' => $data]);
    }

}
