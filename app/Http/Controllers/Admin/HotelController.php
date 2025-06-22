<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.search', compact('prefectures'));
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit($id): View
    {
        $hotel = Hotel::findOrFail($id);
        $prefectures = Prefecture::all();
        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }

    public function showCreate(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.create', compact('prefectures'));
    }

    /** post methods */

    public function searchResult(Request $request): View
    {
        $hotelName = $request->input('hotel_name');
        $prefectureId = $request->input('prefecture_id');

        // If both fields are empty, show all hotels instead of showing error
        $hotelList = Hotel::searchHotels($hotelName, $prefectureId);
        $prefectures = Prefecture::all();

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'input' => $request->all(),
        ]);
    }

    public function showEditConfirmation(Request $request, $id)
    {
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|integer|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $hotel = Hotel::findOrFail($id);
        $prefecture = Prefecture::findOrFail($validated['prefecture_id']);

        // Store the new image temporarily if it exists
        if ($request->hasFile('file_path')) {
            $imagePath = $request->file('file_path')->store('temp', 'public');
            $validated['new_image_path'] = $imagePath;
        }

        return view('admin.hotel.edit-confirm', [
            'hotel' => $hotel,
            'prefecture' => $prefecture,
            'input' => $validated,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if ($request->filled('new_image_path')) {
            $newImagePath = $request->input('new_image_path');

            // Delete old image
            if ($hotel->file_path) {
                Storage::disk('public')->delete($hotel->file_path);
            }

            // Move new image from temp to hotels directory
            $finalPath = str_replace('temp/', 'hotels/', $newImagePath);
            Storage::disk('public')->move($newImagePath, $finalPath);
            $hotel->file_path = $finalPath;
        }

        $hotel->save();

        return view('admin.hotel.edit-complete');
    }

    public function create(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|integer|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $hotel = new Hotel();
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if ($request->hasFile('file_path')) {
            $imagePath = $request->file('file_path')->store('hotels', 'public');
            $hotel->file_path = $imagePath;
        }

        $hotel->save();

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel created successfully.');
    }

    public function delete(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        $hotelName = $request->input('hotel_name');
        $prefectureId = $request->input('prefecture_id');
        
        $hotelList = Hotel::searchHotels($hotelName, $prefectureId);
        $prefectures = Prefecture::all();

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'input' => $request->all(),
            'successMessage' => 'ホテル情報を削除しました。' // Pass success message
        ]);
    }
}
