<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Illuminate\Http\Response;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

class CreateIdea extends Component
{
    use WithFileUploads;

    public $title;
    public $category = 1;
    public $description;
    public $file;
    public $categories;

    protected $rules = [
        'title'       => 'required|min:4',
        'category'    => 'required|integer',
        'description' => 'required|min:4'
    ];

    public function mount(Collection $categories)
    {
        $this->categories = $categories;
    }

    public function createIdea()
    {
        if (auth()->check()) {
            
            $this->validate();

            if ($this->file != '') {
                if ($this->file->getSize() > 10000000) {
                   session()->flash('error','File Cannot be greater then 10MB');
                   return;
                }    
                $file = $this->file->storeAs('idea-photos', time().rand().'.'.$this->file->getClientOriginalExtension(),'public');
            }

            Idea::create([
                'user_id'     => auth()->id(),
                'category_id' => $this->category,
                'title'       => $this->title,
                'description' => $this->description,
                'files' => $file ?? null,
            ]);

            session()->flash('success', 'Idea was added successfully.');

            $this->reset();

            return redirect()->route('idea.index');
        }

        abort(Response::HTTP_FORBIDDEN);
    }

    public function render()
    {
        return view('livewire.create-idea', [
            'categories' => $this->categories,
        ]);
    }
}
