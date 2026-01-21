<?php
namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryListController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->get('category', '')); // Get and trim input safely

        if ($query === '') {
            return response()->json(['results' => []]); // Return empty if no keyword
        }

        // Fetch matching categories
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'type' => 'Category',
                ];
            });

        // Fetch matching users (only those with serviceproviderprofile)
        // Fetch matching users (only those with serviceproviderprofile)
        $users = User::whereHas('serviceproviderprofile', function ($queryBuilder) use ($query) {
            $queryBuilder->where('company_name', 'LIKE', "%{$query}%");
        })
            ->where('status','verified')
            ->with('serviceproviderprofile') // Load the polymorphic relationship
            ->select('id') // Only select the necessary columns
            ->get();

        // Process users and their profiles
        $users = $users->map(function ($user) {
            $profile = $user->serviceproviderprofile; // This should be a ServiceProviderProfile object
            return [
                'id' => $user->id,
                'name' => $profile ? $profile->company_name : 'Unknown',
                'type' => 'Service Provider',
            ];
        });

        // Convert categories to a collection (it might be an array)
        $categories = collect($categories);
        // Convert categories to a collection (it might be an array)
        $users = collect($users);

        // Merge results
        $results = $users->merge($categories);

        return response()->json(['results' => $results]);
    }


}
