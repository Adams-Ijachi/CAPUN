<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Debugbar;
use App\Models\{
    Goal,
    
};
use Livewire\WithPagination;
use Auth;
use Illuminate\Database\Eloquent\Builder;

class Rating extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $is_editing = false;
    public Goal $goal ;
    public Rating $review;
    public $rating_num = 0;


    public function render()
    {
        Debugbar::info($this->review);
        $this->getRating();
       
        return view('livewire.rating');
    }

    public function mount(Goal $goal)
    {
        $this->review = Review::make();
        $this->goal = $goal;
    }

    // get the rating of the goal for the current user
    public function getRating()
    {
        $rating = $this->goal->ratings()->where('user_id', Auth::id())->first();
        if ($rating) {
            $this->review = $rating;
            $this->rating = $rating->rating;
        }

    }

    // addRating
    public function addRating()
    {
       
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $this->goal->ratings()->updateOrCreate([
            'id'=> $this->review->id,
            'user_id' => Auth::id(),
            'goal_id' => $this->goal->id,
        ], [
            'rating' => $this->rating,
        ]);
       

        $this->rating = 0;
        
    }




    
}
