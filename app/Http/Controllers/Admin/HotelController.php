<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        return view('admin.hotel.search');
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
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|integer|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $hotel = Hotel::findOrFail($id);
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if ($request->hasFile('file_path')) {
            // Xoá ảnh cũ
            if ($hotel->file_path) {
                Storage::disk('public')->delete($hotel->file_path);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('file_path')->store('hotels', 'public');
            $hotel->file_path = $imagePath;
        }

        $hotel->save();

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel updated successfully.');
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

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel deleted successfully.');
    }
}
