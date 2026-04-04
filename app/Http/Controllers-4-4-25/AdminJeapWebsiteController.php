namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JeapWebsite;
use Illuminate\Support\Facades\File;

class AdminJeapWebsiteController extends Controller
{
      public function index()
    {
        $items = JeapWebsite::orderBy('display_order','asc')->get();
        return view('admin.website.about.jeap', compact('items'));
    }


    // ===============================
    // STORE DATA
    // ===============================
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/jeap'), $imageName);

            $imagePath = 'uploads/jeap/'.$imageName;

        }

        JeapWebsite::create([
            'title' => $request->title,
            'description' => $request->description,
            'small_titles' => $request->small_titles,
            'small_descriptions' => $request->small_descriptions,
            'image' => $imagePath
        ]);

        return back()->with('success','JEAP Data Added Successfully');

    }


    // ===============================
    // UPDATE DATA
    // ===============================
    public function update(Request $request, $id)
    {

        $item = JeapWebsite::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $item->image;

        if ($request->hasFile('image')) {

            // delete old image
            if ($item->image && File::exists(public_path($item->image))) {
                File::delete(public_path($item->image));
            }

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/jeap'), $imageName);

            $imagePath = 'uploads/jeap/'.$imageName;

        }

        $item->update([

            'title' => $request->title,
            'description' => $request->description,
            'small_titles' => $request->small_titles,
            'small_descriptions' => $request->small_descriptions,
            'image' => $imagePath

        ]);

        return back()->with('success','JEAP Data Updated Successfully');

    }


    // ===============================
    // DELETE DATA
    // ===============================
    public function delete($id)
    {

        $item = JeapWebsite::findOrFail($id);

        // delete image
        if ($item->image && File::exists(public_path($item->image))) {
            File::delete(public_path($item->image));
        }

        $item->delete();

        return back()->with('success','JEAP Data Deleted Successfully');

    }

}