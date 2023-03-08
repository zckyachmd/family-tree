<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'gender',
        'parent_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'parent_id' => 'integer',
    ];

    /**
     * The rules are defined so that data can be stored
     *
     * @return array<string, mixed>
     */
    public $rules = [
        'name'      => 'required|string|max:100',
        'gender'    => 'required|in:male,female',
        'parent'    => 'nullable|integer|exists:families,id',
    ];

    /**
     * Get the children for the family tree.
     *
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(Family::class, 'parent_id', 'id');
    }

    /**
     * Get the uncles for the family tree.
     *
     * @param  int|null  $parentId
     * @return mixed
     */
    public static function buildFamilyTree($parentId = null)
    {
        // Initialize the result
        $result = [];

        // Get the data
        $query = self::with('children')
            ->where('parent_id', $parentId);

        // If the parent ID is null, then get the root
        $data = $query->get();

        // Loop through the data
        foreach ($data as $row) {
            $child = [];
            $child['id'] = $row->id;
            $child['name'] = $row->name;
            $child['gender'] = $row->gender;

            // If the child has children, then call the function recursively
            if ($row->children->count() > 0) {
                // Get the children
                $child['children'] = self::buildFamilyTree($row->id);
            }

            // Add the child to the result
            $result[] = $child;
        }

        // Return the result
        return $result;
    }
}
