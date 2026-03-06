<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;

class BookSearch extends Component
{
    use WithPagination;

    public $search = '';


    public function updatingSearch()
        {
            $this->resetPage();
        }

    public function render()
    {
       $books = Book::where('title', 'like', '%'.$this->search.'%')
                     ->orWhere('author', 'like', '%'.$this->search.'%')
                     ->paginate(10);

        
       return view('livewire.book-search', [
            'books' => $books,
            
            ]);
    }
}    
?>

