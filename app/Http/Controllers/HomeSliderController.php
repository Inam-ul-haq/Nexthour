<?php

namespace App\Http\Controllers;

use App\HomeSlider;
use App\Movie;
use App\TvSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_slides = HomeSlider::orderBy('position', 'asc')->get();
        return view('admin.homeslider.index', compact('home_slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movie_list = Movie::pluck('title', 'id')->all();
        $tv_series_list = TvSeries::pluck('title', 'id')->all();
        return view('admin.homeslider.create', compact('movie_list', 'tv_series_list'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'slide_image' => 'required|image|mimes:png,jpeg,jpg,gif'
        ]);

        $input = $request->all();

        if ($file = $request->file('slide_image'))
        {
          $name = 'slide_' . time() . $file->getClientOriginalName();
          if ($request->movie_id != null && $request->movie_id != '')
          {
            $file->move('images/home_slider/movies/', $name);
          } elseif ($request->tv_series_id != null && $request->tv_series_id != '') {
            $file->move('images/home_slider/shows/', $name);
          }
          $input['slide_image'] = $name;
        }

        if (!isset($input['active']))
        {
          $input['active'] = 0;
        }

        $input['position'] = (HomeSlider::count()+1);

        HomeSlider::create($input);

        return back()->with('added', 'Slide has been added');

    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $home_slide = HomeSlider::findOrFail($id);
        if ($home_slide->movie_id != null) {
            $movie_dtl = Movie::findOrFail($home_slide->movie_id);
            $movie_list = Movie::pluck('title', 'id')->all();
            $tv_series_list = TvSeries::pluck('title', 'id')->all();
            return view('admin.homeslider.edit', compact('home_slide', 'movie_list', 'tv_series_list', 'movie_dtl'));
        } elseif ($home_slide->tv_series_id != null) {
            $tv_series_dtl = TvSeries::findOrFail($home_slide->tv_series_id);
            $movie_list = Movie::pluck('title', 'id')->all();
            $tv_series_list = TvSeries::pluck('title', 'id')->all();
            return view('admin.homeslider.edit', compact('home_slide', 'movie_list', 'tv_series_list', 'tv_series_dtl'));
        }

    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slide_image' => 'nullable|image|mimes:png,jpeg,jpg,gif'
        ]);

        $input = $request->all();

        $slide = HomeSlider::findOrFail($id);

        if ($file = $request->file('slide_image'))
        {
          $name = 'slide_' . time() . $file->getClientOriginalName();
          if ($request->movie_id != null && $request->movie_id != '')
          {
            if ($slide->slide_image != null) {
              $image_file = @file_get_contents(public_path().'/images/home_slider/'. $slide->slide_image);
              if($image_file){
                unlink(public_path(). '/images/home_slider/movies' . $slide->slide_image);
              }
            }
            $file->move('images/home_slider/movies', $name);
          } elseif ($request->tv_series_id != null && $request->tv_series_id != '') {
            if ($slide->slide_image != null) {
              $image_file = @file_get_contents(public_path().'/images/home_slider/'. $slide->slide_image);
              if($image_file){
                unlink(public_path(). '/images/home_slider/shows' . $slide->slide_image);
              }
            }
            $file->move('images/home_slider/shows', $name);
          }
          $input['slide_image'] = $name;
        }

        if (!isset($input['active']))
        {
          $input['active'] = 0;
        }

        $slide->update($input);
        return redirect('admin/home_slider')->with('updated', 'Slide has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $home_slide = HomeSlider::findOrFail($id);

        if ($home_slide->slide_image != null) {
          if ($home_slide->movie_id != null) {
            $content = @file_get_contents(public_path() . '/images/home_slider/movies/'.$home_slide->slide_image);
            if ($content) {
              unlink(public_path() . '/images/home_slider/movies/'.$home_slide->slide_image);
            }
          }
          elseif($home_slide->tv_series_id != null) {
            $content = @file_get_contents(public_path() . '/images/home_slider/shows/'.$home_slide->slide_image);
            if ($content) {
              unlink(public_path() . '/images/home_slider/shows/'.$home_slide->slide_image);
            }
          }
        }
        $home_slide->delete();
        return back()->with('deleted', 'Slide has been deleted');
    }


    public function slide_reposition(Request $request)
    {
      if($request->item != null)
      {
          $items = explode('&', $request->item);
          $all_ids = collect();
          foreach ($items as $key => $value) {
              $all_ids->push(substr($value, 7));
          }

          $i = 0;

          foreach($all_ids as $id)
          {
              $i++;
              $item = HomeSlider::findOrFail($id);
              $item->position = $i;
              $item->save();
          }

          return response()->json(['success' => true]);

      }

      else
      {
          return response()->json(['success' => false]);
      }
    }

    public function bulk_delete(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'checked' => 'required',
      ]);

      if ($validator->fails()) {
          return back()->with('deleted', 'Please select one of them to delete');
      }

      foreach ($request->checked as $checked) {
        $home_slide = HomeSlider::findOrFail($checked);

        if ($home_slide->slide_image != null) {
          if ($home_slide->movie_id != null) {
            $content = @file_get_contents(public_path() . '/images/home_slider/movies/'. $home_slide->slide_image);
            if ($content) {
              unlink(public_path() . '/images/home_slider/movies/'. $home_slide->slide_image);
            }
          } else if ($home_slide->tv_series_id != null) {
            $content = @file_get_contents(public_path() . '/images/home_slider/shows/'. $home_slide->slide_image);
            if ($content) {
              unlink(public_path() . '/images/home_slider/shows/'. $home_slide->slide_image);
            }
          }
        }

        $home_slide->delete();
      }

      return back()->with('deleted', 'Slides has been deleted');
    }
}
