<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\StoreHotelRequest;
use App\Http\Requests\Admin\UpdateHotelRequest;

class HotelController extends Controller
{
    /**
     * Display the hotel search page.
     *
     * @return \Illuminate\View\View
     */
    public function showSearch(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.search', compact('prefectures'));
    }

    /**
     * Display the hotel search result page.
     * Note: This is for direct access, typically results are shown via searchResult().
     *
     * @return \Illuminate\View\View
     */
    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    /**
     * Show the form for editing the specified hotel.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showEdit($id): View
    {
        $hotel = Hotel::findOrFail($id);
        $prefectures = Prefecture::all();
        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }

    /**
     * Show the form for creating a new hotel.
     *
     * @return \Illuminate\View\View
     */
    public function showCreate(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.create', compact('prefectures'));
    }

    /**
     * Handle the search request and display the results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function searchResult(Request $request): View
    {
        $hotelName = $request->input('hotel_name');
        $prefectureId = $request->input('prefecture_id');

        $hotelList = Hotel::searchHotels($hotelName, $prefectureId);
        $prefectures = Prefecture::all();

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'input' => $request->all(),
        ]);
    }

    /**
     * Validate and show the confirmation screen for editing a hotel.
     *
     * @param  \App\Http\Requests\Admin\UpdateHotelRequest  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showEditConfirmation(UpdateHotelRequest $request, $id)
    {
        $validated = $request->validated();

        $hotel = Hotel::findOrFail($id);
        $prefecture = Prefecture::findOrFail($validated['prefecture_id']);

        // Store the new image temporarily in the public path
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $tempPath = 'assets/img/temp';
            $file->move(public_path($tempPath), $filename);
            $validated['new_image_path'] = $tempPath . '/' . $filename;
        }

        return view('admin.hotel.edit-confirm', [
            'hotel' => $hotel,
            'prefecture' => $prefecture,
            'input' => $validated,
        ]);
    }

    /**
     * Update the specified hotel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if ($request->filled('new_image_path')) {
            $newImagePath = $request->input('new_image_path'); // e.g., 'assets/img/temp/file.jpg'

            // Delete old image from public path
            if ($hotel->file_path && File::exists(public_path($hotel->file_path))) {
                File::delete(public_path($hotel->file_path));
            }

            // Move new image from temp to final directory in public path
            $finalPath = str_replace('assets/img/temp', 'assets/img/hotel', $newImagePath);
            File::move(public_path($newImagePath), public_path($finalPath));
            $hotel->file_path = $finalPath;
        }

        $hotel->save();

        return view('admin.hotel.edit-complete');
    }

    /**
     * Store a newly created hotel in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreHotelRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(StoreHotelRequest $request)
    {
        $validated = $request->validated();
        
        $hotel = new Hotel();
        $hotel->hotel_name = $validated['hotel_name'];
        $hotel->prefecture_id = $validated['prefecture_id'];

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $path = 'assets/img/hotel';
            $file->move(public_path($path), $filename);
            $hotel->file_path = $path . '/' . $filename;
        }

        $hotel->save();

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel created successfully.');
    }

    /**
     * Remove the specified hotel from storage and refresh the search results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
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
            'successMessage' => 'Hotel deleted successfully.'
        ]);
    }
}
