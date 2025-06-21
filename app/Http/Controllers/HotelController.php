<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    protected $hotel;
    protected $prefecture;

    public function __construct(
        Hotel $hotel,
        Prefecture $prefecture
    )
    {
        $this->hotel = $hotel;
        $this->prefecture = $prefecture;
    }

    public function showList(string $prefecture_name_alpha): View
    {
        // prefecture information
        $prefectures = $this->prefecture
            ->where('prefecture_name_alpha', $prefecture_name_alpha)
            ->first();

        // hotel information
        $hotels = $this->hotel
            ->where('prefecture_id', $prefectures->prefecture_id)
            ->inRandomOrder()
            ->get();


        return view('user.hotellist', compact(
            'prefectures',
            'hotels'
        ));
    }

    public function showDetail(int $hotel_id): View
    {
        $hotel = $this->hotel
            ->find($hotel_id);

        if (!$hotel) {
            abort(404, 'Hotel not found');
        }

        return view('user.hotel.detail', compact(
            'hotel'
        ));
    }

    public function search(Request $request): JsonResponse
    {
        $hotels = Hotel::searchHotels(
            $request->query('name'),
            $request->query('prefecture_id')
        );

        return response()->json($hotels);
    }

}
