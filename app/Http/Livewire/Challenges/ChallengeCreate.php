<?php

namespace App\Http\Livewire\Challenges;

use Livewire\Component;
use App\Models\Challenge;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;

class ChallengeCreate extends Component
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
        'description' => 'required|min:4',
    ];

    public function mount(Collection $categories)
    {
        $this->categories = $categories;
    }

    public function createChallenge()
    {
        if (auth()->check()) {
            $this->validate();

            if ($this->file != '') {
                if ($this->file->getSize() > 10000000) {
                    session()->flash('error', 'File Cannot be greater then 10MB');
                    return;
                }
                $file = $this->file->storeAs('challenge-photos', time() . rand() . '.' . $this->file->getClientOriginalExtension(), 'public');
            }

            Challenge::create([
                'user_id'     => auth()->id(),
                'category_id' => $this->category,
                'title'       => $this->title,
                'slug'        => Str::slug($this->title),
                'description' => $this->description,
                'files'       => $file ?? null,
            ]);

            session()->flash('success', 'Challenge was added successfully.');

            $this->reset();

            return redirect()->route('challenges.index');
        }

        abort(Response::HTTP_FORBIDDEN);
    }

    public function render()
    {
        return view('livewire.challenges.challenge-create', [
            'categories' => $this->categories,
        ]);
    }
}
