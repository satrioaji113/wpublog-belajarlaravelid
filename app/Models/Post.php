<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with=['author', 'category'];//daripada membuat eager loading/ lazy eager loading di bagian route, kita bisa menggunakannya pada model kita dengan route kita tetap menggunakan lazy loading

    public function author():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters) : void
    {
        $query->when($filters['search'] ?? false, function ($query, $search){
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category){
           return $query->whereHas('category', function (Builder $query) use ($category){
            $query->where('slug', $category);
           });
        });

        $query->when($filters['author'] ?? false, function ($query, $author){
           return $query->whereHas('author', function (Builder $query) use ($author){
            $query->where('username', $author);
           });
        });
    }
}

//secara default Post yang sudah menjadi model(extends Model) sudah tersambung ke database dengan table post yang sama. karena  fungsi  all dan find sudah ada di model, kita tidak perlu lagi membuat fungsi tersebut. namun, secara default eloquen orm menggunakan id untuk menyambungkan table database dan model dengan menggunakan route(/posts/$id). sehingga jika kita menggunakan fungsi find($slug) atau route(/posts/$slug) akan menampilkan error