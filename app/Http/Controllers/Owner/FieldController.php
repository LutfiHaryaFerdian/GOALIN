<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with(['category', 'location'])
            ->where('owner_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('owner.fields.index', compact('fields'));
    }

    public function create()
    {
        $categories = FieldCategory::where('is_active', true)->orderBy('name')->get();
        $locations = Location::where('is_active', true)->orderBy('city')->get();

        return view('owner.fields.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:field_categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'description' => ['nullable', 'string'],
            'price_per_hour' => ['required', 'numeric', 'min:1000'],
            'capacity' => ['required', 'integer', 'min:1'],
            'facilities' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive,maintenance'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['owner_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name).'-'.Str::random(4);

        // Upload images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('fields', 'public');
            }
        }
        $data['images'] = $imagePaths ?: null;

        Field::create($data);

        return redirect()->route('owner.fields.index')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Field $field)
    {
        $this->authorizeOwner($field);
        $categories = FieldCategory::where('is_active', true)->orderBy('name')->get();
        $locations = Location::where('is_active', true)->orderBy('city')->get();

        return view('owner.fields.edit', compact('field', 'categories', 'locations'));
    }

    public function update(Request $request, Field $field)
    {
        $this->authorizeOwner($field);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:field_categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'description' => ['nullable', 'string'],
            'price_per_hour' => ['required', 'numeric', 'min:1000'],
            'capacity' => ['required', 'integer', 'min:1'],
            'facilities' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive,maintenance'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        // Upload new images if provided
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('fields', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $field->update($data);

        return redirect()->route('owner.fields.index')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Field $field)
    {
        $this->authorizeOwner($field);
        $field->update(['status' => 'inactive']);

        return redirect()->route('owner.fields.index')
            ->with('success', 'Lapangan berhasil dinonaktifkan.');
    }

    private function authorizeOwner(Field $field): void
    {
        if ($field->owner_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke lapangan ini.');
        }
    }
}
