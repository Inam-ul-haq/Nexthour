<?php
namespace App\Http\Controllers;

use App\Actor;
use App\Menu;
use App\MenuVideo;
use App\AudioLanguage;
use App\Episode;
use App\Subtitles;
use App\Genre;
use App\Season;
use App\TvSeries;
use App\Videolink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Datatables;
use App\WatchHistory;
use Auth;
use App\User;

class TvSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->is_assistant != 1)
        {
            $tv_serieses = \DB::table('tv_series')->select('id', 'title', 'thumbnail', 'poster', 'rating', 'tmdb', 'featured', 'status', 'created_by')
                ->get();
        }
        else
        {
            $tv_serieses = \DB::table('tv_series')->select('id', 'title', 'thumbnail', 'poster', 'rating', 'tmdb', 'featured', 'status', 'created_by')
                ->where('created_by', '=', Auth::user()
                ->id)
                ->get();
        }

        if ($request->ajax())
        {
            return \Datatables::of($tv_serieses)->addIndexColumn()->addColumn('checkbox', function ($tv_serieses)
            {
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="' . $tv_serieses->id . '" id="checkbox' . $tv_serieses->id . '">
                    <label for="checkbox' . $tv_serieses->id . '" class="material-checkbox"></label>
                  </div>';

                return $html;
            })->addColumn('thumbnail', function ($tv_serieses)
            {
                if ($tv_serieses->thumbnail)
                {
                    $thumnail = '<img src="' . asset('/images/tvseries/thumbnails/' . $tv_serieses->thumbnail) . '" alt="Pic" width="70px" class="img-responsive">';
                }
                else if ($tv_serieses->poster)
                {
                    $thumnail = '<img src="' . asset('/images/tvseries/posters/' . $tv_serieses->poster) . '" alt="Pic" width="70px" class="img-responsive">';
                }
                else
                {
                    $thumnail = '<img  src="http://via.placeholder.com/70x70" alt="Pic" width="70px" class="img-responsive">';
                }

                return $thumnail;

            })->addColumn('rating', function ($tv_serieses)
            {
                return 'IMDB ' . $tv_serieses->rating;
            })->addColumn('featured', function ($tv_serieses)
            {

                if ($tv_serieses->featured == 1)
                {
                    $featured = 'Y';
                }
                else
                {
                    $featured = '-';
                }

                return $featured;
            })->addColumn('status', function ($tv_serieses)
            {
                if (Auth::user()->is_assistant != 1)
                {
                    if ($tv_serieses->status == 1)
                    {
                        return "<a href=" . route('quick.tv.status', $tv_serieses->id) . " class='btn btn-sm btn-success'>Active</a>";
                    }
                    else
                    {
                        return "<a href=" . route('quick.tv.status', $tv_serieses->id) . " class='btn btn-sm btn-danger'>Deactive</a>";
                    }
                }
                else
                {
                    if ($tv_serieses->status == 1)
                    {
                        return "<a class='btn btn-sm btn-success'>Active</a>";
                    }
                    else
                    {
                        return "<a class='btn btn-sm btn-danger'>Deactive</a>";
                    }
                }
            })->addColumn('addedby', function ($tv_serieses)
            {
                $username = User::find($tv_serieses->created_by);

                if (isset($username))
                {
                    return $username->name;
                }
                else
                {
                    return 'User deleted';
                }

            })->addColumn('tmdb', function ($tv_serieses)
            {
                if ($tv_serieses->tmdb == 'Y')
                {
                    $tmdb = '<i class="material-icons done">done</i>';
                }
                else
                {
                    $tmdb = '-';
                }
                return $tmdb;
            })->addColumn('action', function ($tv_serieses)
            {
                $btn = ' <div class="admin-table-action-block">
                     <a href="' . url('show/detail', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Page Preview" target="_blank" class="btn-default btn-floating"><i class="material-icons">desktop_mac</i></a>
                    <a href="' . route('tvseries.edit', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a> 
                    <a href="' . route('tvseries.show', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Manage Seasons" class="btn-success btn-floating"><i class="material-icons">settings</i></a>
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal' . $tv_serieses->id . '"><i class="material-icons">delete</i> </button></div>';

                $btn .= '<div id="deleteModal' . $tv_serieses->id . '" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <form method="POST" action="' . route("tvseries.destroy", $tv_serieses->id) . '">
                        ' . method_field("DELETE") . '
                        ' . csrf_field() . '
                          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';

                return $btn;
            })->rawColumns(['checkbox', 'rating', 'thumbnail', 'tmdb', 'rating', 'status', 'addedby', 'action'])
                ->make(true);
        }
        return view('admin.tvseries.index', compact('tv_serieses'));
    }

    public function addedTvSeries(Request $request)
    {

        $tv_serieses = \DB::table('tv_series')->select('id', 'title', 'thumbnail', 'poster', 'rating', 'tmdb', 'featured', 'status', 'created_by')
            ->where('status', '=', 0)
            ->get();
        if ($request->ajax())
        {
            return \Datatables::of($tv_serieses)->addIndexColumn()->addColumn('checkbox', function ($tv_serieses)
            {
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="' . $tv_serieses->id . '" id="checkbox' . $tv_serieses->id . '">
                    <label for="checkbox' . $tv_serieses->id . '" class="material-checkbox"></label>
                  </div>';

                return $html;
            })->addColumn('thumbnail', function ($tv_serieses)
            {
                if ($tv_serieses->thumbnail)
                {
                    $thumnail = '<img src="' . asset('/images/tvseries/thumbnails/' . $tv_serieses->thumbnail) . '" alt="Pic" width="70px" class="img-responsive">';
                }
                else if ($tv_serieses->poster)
                {
                    $thumnail = '<img src="' . asset('/images/tvseries/posters/' . $tv_serieses->poster) . '" alt="Pic" width="70px" class="img-responsive">';
                }
                else
                {
                    $thumnail = '<img  src="http://via.placeholder.com/70x70" alt="Pic" width="70px" class="img-responsive">';
                }

                return $thumnail;

            })->addColumn('rating', function ($tv_serieses)
            {
                return 'IMDB ' . $tv_serieses->rating;
            })->addColumn('featured', function ($tv_serieses)
            {

                if ($tv_serieses->featured == 1)
                {
                    $featured = 'Y';
                }
                else
                {
                    $featured = '-';
                }

                return $featured;
            })->addColumn('status', function ($tv_serieses)
            {
                if ($tv_serieses->status == 1)
                {
                    return "<a href=" . route('quick.tv.status', $tv_serieses->id) . " class='btn btn-sm btn-success'>Active</a>";
                }
                else
                {
                    return "<a href=" . route('quick.tv.status', $tv_serieses->id) . " class='btn btn-sm btn-danger'>Deactive</a>";
                }
            })->addColumn('addedby', function ($tv_serieses)
            {
                $username = User::find($tv_serieses->created_by);

                if (isset($username))
                {
                    return $username->name;
                }
                else
                {
                    return 'User deleted';
                }

            })->addColumn('tmdb', function ($tv_serieses)
            {
                if ($tv_serieses->tmdb == 'Y')
                {
                    $tmdb = '<i class="material-icons done">done</i>';
                }
                else
                {
                    $tmdb = '-';
                }
                return $tmdb;
            })->addColumn('action', function ($tv_serieses)
            {
                $btn = ' <div class="admin-table-action-block">
                     <a href="' . url('show/detail', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Page Preview" target="_blank" class="btn-default btn-floating"><i class="material-icons">desktop_mac</i></a>
                    <a href="' . route('tvseries.edit', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a> 
                    <a href="' . route('tvseries.show', $tv_serieses->id) . '" data-toggle="tooltip" data-original-title="Manage Seasons" class="btn-success btn-floating"><i class="material-icons">settings</i></a>
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal' . $tv_serieses->id . '"><i class="material-icons">delete</i> </button></div>';

                $btn .= '<div id="deleteModal' . $tv_serieses->id . '" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <form method="POST" action="' . route("tvseries.destroy", $tv_serieses->id) . '">
                        ' . method_field("DELETE") . '
                        ' . csrf_field() . '
                          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';

                return $btn;
            })->rawColumns(['checkbox', 'rating', 'thumbnail', 'tmdb', 'rating', 'status', 'addedby', 'action'])
                ->make(true);
        }
        return view('admin.tvseries.addedindex', compact('tv_serieses'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        $genre_ls = Genre::pluck('name', 'id')->all();
        $a_lans = AudioLanguage::pluck('language', 'id')->all();
        $actor_ls = Actor::pluck('name', 'id')->all();
        return view('admin.tvseries.create', compact('actor_ls', 'genre_ls', 'a_lans', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 80);

        if (isset($request->tv_by_id))
        {
            $request->validate(['title' => 'required'

            ]);

        }
        else
        {

            $request->validate(['title2' => 'required'], ['title2.required' => 'Tv ID is required !']);
        }

        $menus = null;

        if (isset($request->menu) && count($request->menu) > 0)
        {
            $menus = $request->menu;
        }

        $TMDB_API_KEY = env('TMDB_API_KEY');
        $input = $request->all();

        // if ($input['tmdb'] != 'Y') {
        //   $request->validate([
        //       'genre_id' => 'required'
        //   ]);
        // }
        if (!isset($input['featured']))
        {
            $input['featured'] = 0;
        }

        $input['created_by'] = Auth::user()->id;

        if (Auth::user()->is_assistant == 1)
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }

        $input['status'] = $status;

        if ($input['tmdb'] == 'Y')
        {

            if ($TMDB_API_KEY == null || $TMDB_API_KEY == '')
            {
                return back()->with('deleted', 'Please provide your TMDB api key or add tvseries by custom fields');
            }

            $title = urlencode($input['title']);

            if (isset($request->tv_by_id))
            {

                $search_data = @file_get_contents('https://api.themoviedb.org/3/search/tv?api_key=' . $TMDB_API_KEY . '&query=' . $title);

                if ($search_data)
                {
                    $data = json_decode($search_data, true);
                }

                $input['fetch_by'] = "title";

            }
            else
            {
                $title2 = urlencode($request->title2);
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $title2 . '?api_key=' . $TMDB_API_KEY);

                $x2 = json_decode($search_data, true);
                $data2 = [];
                $data2[] = ['results' => [$x2]];

                $data = $data2[0];

                $input['title'] = $data['results'][0]['name'];
                // return $data;
                $input['fetch_by'] = "byID";
            }

            if (!isset($data) || $data['results'] == null)
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            if (Session::has('changed_language'))
            {
                $fetch_tv = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
                $fetch_tv_for_genres = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
            }
            else
            {
                $fetch_tv = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
                $fetch_tv_for_genres = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (!isset($fetch_tv) && !isset($fetch_tv_for_genres))
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $tmdb_tv = json_decode($fetch_tv, true);
            // Only for genre
            $tmdb_tv_for_genres = json_decode($fetch_tv_for_genres, true);

            if ($tmdb_tv != null)
            {
                $input['tmdb_id'] = $tmdb_tv['id'];
            }
            else
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $thumbnail = null;
            $poster = null;

            if ($file = $request->file('thumbnail'))
            {

                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/thumbnails', $thumbnail);

            }
            else
            {

                $url = $tmdb_tv['poster_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    $tmdb_img = Storage::disk('imdb_poster_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }

            }

            if ($file = $request->file('poster'))
            {
                $poster = 'poster_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/posters', $poster);
            }
            else
            {
                $url = $tmdb_tv['backdrop_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    $tmdb_img = Storage::disk('imdb_backdrop_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $poster = $name;
                    }
                }
            }

            // get Genres and create theme
            $tmdb_genres_id = collect();
            if (isset($tmdb_tv_for_genres) && $tmdb_tv_for_genres != null)
            {
                foreach ($tmdb_tv_for_genres['genres'] as $tmdb_genre)
                {

                    $tmdb_genre1 = $tmdb_genre['name'];
                    $check_list = Genre::where('name', 'LIKE', "%$tmdb_genre1%")->first();

                    if (!isset($check_list))
                    {
                        $created_genre = Genre::create(['name' => ['en' => $tmdb_genre['name']], ]);

                        $tmdb_genres_id->push($created_genre->id);
                    }
                    else
                    {
                        $tmdb_genres_id->push($check_list->id);
                    }
                }
            }
            $tmdb_genres_id = $tmdb_genres_id->flatten();
            $tmdb_genres_id = substr($tmdb_genres_id, 1, -1);

            $created_tv = TvSeries::create(['title' => $input['title'], 'keyword' => $input['keyword'], 'description' => $input['description'], 'tmdb_id' => $input['tmdb_id'], 'tmdb' => $input['tmdb'], 'featured' => $input['featured'], 'thumbnail' => $thumbnail, 'poster' => $poster, 'genre_id' => $tmdb_genres_id, 'detail' => $tmdb_tv['overview'], 'rating' => $tmdb_tv['vote_average'], 'episode_runtime' => $tmdb_tv['episode_run_time'], 'maturity_rating' => $input['maturity_rating'], 'fetch_by' => $input['fetch_by'], 'created_by' => Auth::user()->id, 'status' => $status]);

            if ($menus != null)
            {
                if (count($menus) > 0)
                {
                    foreach ($menus as $key => $value)
                    {
                        MenuVideo::create(['menu_id' => $value, 'tv_series_id' => $created_tv->id, ]);
                    }
                }
            }

            return back()->with('added', 'Tv Series has been added');
        }

        $genre_ids = $request->input('genre_id');
        if ($genre_ids)
        {
            $genre_ids = implode(',', $genre_ids);
            $input['genre_id'] = $genre_ids;
        }
        else
        {
            $input['genre_id'] = null;
        }

        if ($file = $request->file('thumbnail'))
        {
            $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
            $file->move('images/tvseries/thumbnails', $thumbnail);
            $input['thumbnail'] = $thumbnail;
        }

        if ($file = $request->file('poster'))
        {
            $poster = 'poster_' . time() . $file->getClientOriginalName();
            $file->move('images/tvseries/posters', $poster);
            $input['poster'] = $poster;
        }

        TvSeries::create($input);
        return back()->with('added', 'Tv Series has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = Menu::all();
        $tvseries = TvSeries::findOrFail($id);
        $genre_ls = Genre::all();
        $a_lans = AudioLanguage::all();
        $actor_ls = Actor::all();
        // get old genre list
        $old_genre = collect();
        $old_actor = collect();

        if ($tvseries->genre_id != null)
        {
            $old_list = explode(',', $tvseries->genre_id);
            for ($i = 0;$i < count($old_list);$i++)
            {
                $old = Genre::find($old_list[$i]);
                if (isset($old))
                {
                    $old_genre->push($old);
                }
            }
        }

        $genre_ls = $genre_ls->diff($old_genre);

        return view('admin.tvseries.edit', compact('tvseries', 'actor_ls', 'genre_ls', 'a_lans', 'old_actor', 'old_genre', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ini_set('max_execution_time', 80);
        $TMDB_API_KEY = env('TMDB_API_KEY');
        $tvseries = TvSeries::findOrFail($id);

        $menus = null;

        if (isset($request->menu) && count($request->menu) > 0)
        {
            $menus = $request->menu;
        }

        $input = $request->all();

        if ($input['tmdb'] != 'Y')
        {
            $request->validate(['genre_id' => 'required']);
        }

        if (!isset($input['featured']))
        {
            $input['featured'] = 0;
        }

        if ($input['tmdb'] == 'Y')
        {

            $title = urlencode($input['title']);
            $search_data = @file_get_contents('https://api.themoviedb.org/3/search/tv?api_key=' . $TMDB_API_KEY . '&query=' . $title);

            if ($search_data)
            {
                $data = json_decode($search_data, true);
            }

            if (!isset($data) || $data['results'] == null)
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            if (Session::has('changed_language'))
            {
                $fetch_tv = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
                $fetch_tv_for_genres = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
            }
            else
            {
                $fetch_tv = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
                $fetch_tv_for_genres = @file_get_contents('https://api.themoviedb.org/3/tv/' . $data['results'][0]['id'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (!isset($fetch_tv) && !isset($fetch_tv_for_genres))
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $tmdb_tv = json_decode($fetch_tv, true);
            // only for genres
            $tmdb_tv_for_genres = json_decode($fetch_tv_for_genres, true);

            if ($tmdb_tv != null)
            {
                $input['tmdb_id'] = $tmdb_tv['id'];
            }
            else
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $thumbnail = null;
            $poster = null;

            if ($file = $request->file('thumbnail'))
            {
                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $tvseries->thumbnail);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/thumbnails/" . $tvseries->thumbnail);
                }
                $file->move('images/tvseries/thumbnails', $thumbnail);
            }
            else
            {
                $url = $tmdb_tv['poster_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    if ($tvseries->thumbnail != null)
                    {
                        $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $tvseries->thumbnail);
                        if ($content)
                        {
                            unlink(public_path() . "/images/tvseries/thumbnails/" . $tvseries->thumbnail);
                        }
                    }
                    $tmdb_img = Storage::disk('imdb_poster_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }
            }

            if ($file = $request->file('poster'))
            {
                $poster = 'poster_' . time() . $file->getClientOriginalName();
                $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $tvseries->poster);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/posters/" . $tvseries->poster);
                }
                $file->move('images/tvseries/posters', $poster);
            }
            else
            {
                $url = $tmdb_tv['backdrop_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    if ($tvseries->poster != null)
                    {
                        $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $tvseries->poster);
                        if ($content)
                        {
                            unlink(public_path() . "/images/tvseries/posters/" . $tvseries->poster);
                        }
                    }
                    $tmdb_img = Storage::disk('imdb_backdrop_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $poster = $name;
                    }
                }
            }

            // get Genres and create theme
            $tmdb_genres_id = collect();
            if (isset($tmdb_tv_for_genres) && $tmdb_tv_for_genres != null)
            {
                foreach ($tmdb_tv_for_genres['genres'] as $tmdb_genre)
                {

                    $tmdb_genre1 = $tmdb_genre['name'];
                    $check_list = Genre::where('name', 'LIKE', "%$tmdb_genre1%")->first();

                    if (!isset($check_list))
                    {
                        $created_genre = Genre::create(['name' => ['en' => $tmdb_genre['name']], ]);

                        $tmdb_genres_id->push($created_genre->id);
                    }
                    else
                    {
                        $tmdb_genres_id->push($check_list->id);
                    }
                }
            }

            $tmdb_genres_id = $tmdb_genres_id->flatten();
            $tmdb_genres_id = substr($tmdb_genres_id, 1, -1);

            $tvseries->update(['title' => $input['title'], 'tmdb_id' => $input['tmdb_id'], 'keyword' => $input['keyword'], 'description' => $input['description'], 'tmdb' => $input['tmdb'], 'featured' => $input['featured'], 'thumbnail' => $thumbnail, 'poster' => $poster, 'genre_id' => $tmdb_genres_id, 'detail' => $tmdb_tv['overview'], 'rating' => $tmdb_tv['vote_average'], 'maturity_rating' => $input['maturity_rating']]);

            if ($menus != null)
            {
                if (count($menus) > 0)
                {
                    if (isset($tvseries->menus) && count($tvseries->menus) > 0)
                    {
                        foreach ($tvseries->menus as $key => $value)
                        {
                            $value->delete();
                        }
                    }
                    foreach ($menus as $key => $value)
                    {
                        MenuVideo::create(['menu_id' => $value, 'tv_series_id' => $tvseries->id, ]);
                    }
                }
            }
            else
            {
                if (isset($tvseries->menus) && count($tvseries->menus) > 0)
                {
                    foreach ($tvseries->menus as $key => $value)
                    {
                        $value->delete();
                    }
                }
            }

            return redirect('admin/tvseries')
                ->with('updated', 'Tv Series has been updated');
        }

        $genre_ids = $request->input('genre_id');
        if ($genre_ids)
        {
            $genre_ids = implode(',', $genre_ids);
            $input['genre_id'] = $genre_ids;
        }
        else
        {
            $input['genre_id'] = null;
        }

        if ($file = $request->file('thumbnail'))
        {
            $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
            $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $tvseries->thumbnail);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/thumbnails/" . $tvseries->thumbnail);
            }
            $file->move('images/tvseries/thumbnails', $thumbnail);
            $input['thumbnail'] = $thumbnail;
        }

        if ($file = $request->file('poster'))
        {
            $poster = 'poster_' . time() . $file->getClientOriginalName();
            $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $tvseries->poster);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/posters/" . $tvseries->poster);
            }
            $file->move('images/tvseries/posters', $poster);
            $input['poster'] = $poster;
        }

        $input['tmdb_id'] = null;

        $tvseries->update($input);

        if ($menus != null)
        {
            if (count($menus) > 0)
            {
                if (isset($tvseries->menus) && count($tvseries->menus) > 0)
                {
                    foreach ($tvseries->menus as $key => $value)
                    {
                        $value->delete();
                    }
                }
                foreach ($menus as $key => $value)
                {
                    MenuVideo::create(['menu_id' => $value, 'tv_series_id' => $tvseries->id, ]);
                }
            }
        }
        else
        {
            if (isset($tvseries->menus) && count($tvseries->menus) > 0)
            {
                foreach ($tvseries->menus as $key => $value)
                {
                    $value->delete();
                }
            }
        }

        return back()
            ->with('updated', 'Series has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tvseries = TvSeries::findOrFail($id);
        $watched = WatchHistory::where('tv_id', $id)->delete();
        $seasons = Season::where('tv_series_id',$id)->get();
        
        foreach($seasons as $sea){
           $episode = Episode::where('seasons_id',$sea->id)->get();
           foreach ($episode as $key => $value) {
               # code...
            $videolink = Videolink::where('episode_id',$value->id)->delete();
            $value->delete();
           }
           $sea->delete();
        }
     
        
        if ($tvseries->thumbnail != null)
        {
            $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $tvseries->thumbnail);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/thumbnails/" . $tvseries->thumbnail);
            }
        }
        if ($tvseries->poster != null)
        {
            $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $tvseries->poster);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/posters/" . $tvseries->poster);
            }
        }
       
        $tvseries->delete();
        return back()
            ->with('deleted', 'Tv Series has been deleted');
    }

    /**
     * Season Controllers
     */
    public function show($id)
    {

        $tv_series = TvSeries::findOrFail($id);
        $actor_ls = Actor::pluck('name', 'id')->all();
        $a_lans = AudioLanguage::pluck('language', 'id')->all();
        $seasons = Season::where('tv_series_id', $id)->get();

        return view('admin.tvseries.seasons', compact('tv_series', 'actor_ls', 'a_lans', 'id', 'seasons'));

    }

    public function store_seasons(Request $request)
    {
        ini_set('max_execution_time', 80);
        $request->validate(['season_no' => 'required']);

        $TMDB_API_KEY = env('TMDB_API_KEY');

        $input = $request->except('a_language', 'subtitle_list');
        $a_lans = $request->input('a_language');

        if ($a_lans)
        {
            $a_lans = implode(',', $a_lans);
            $input['a_language'] = $a_lans;
        }
        else
        {
            $input['a_language'] = null;
        }

        if ($request->subtitle == 1)
        {
            $subtitles = $request->input('subtitle_list');
            if ($subtitles)
            {
                $subtitles = implode(',', $subtitles);
                $input['subtitle_list'] = $subtitles;
            }
            else
            {
                $input['subtitle_list'] = null;
            }
        }
        else
        {
            $input['subtitle_list'] = null;
            $input['subtitle'] = 0;
        }

        if ($input['tmdb'] == 'Y')
        {

            $tvseries_tmdb = TvSeries::findOrFail($input['tv_series_id']);

            if ($tvseries_tmdb->tmdb_id == null)
            {
                return back()
                    ->with('deleted', "Please add your Tv Series with TMDB than you can add it's seasons via TMDB");
            }

            if (Session::has('changed_language'))
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
            }
            else
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (isset($search_data))
            {
                $season_data = json_decode($search_data, true);
            }

            if (!isset($season_data) || $season_data == null)
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            if ($season_data != null)
            {
                $input['tmdb_id'] = $season_data['id'];
            }
            else
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $thumbnail = null;
            $poster = null;

            if ($file = $request->file('thumbnail'))
            {
                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/thumbnails', $thumbnail);
            }
            else
            {
                $url = $season_data['poster_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    $tmdb_img = Storage::disk('imdb_poster_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }
            }

            if ($file = $request->file('poster'))
            {
                $poster = 'poster_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/posters', $poster);
            }

            // get actors and create theme
            $tmdb_actors_id = collect();
            $get_tmdb_actors_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '/credits?api_key=' . $TMDB_API_KEY);
            if ($get_tmdb_actors_data)
            {
                $get_tmdb_actors_data = json_decode($get_tmdb_actors_data, true);
                $get_tmdb_actors_data = (object)$get_tmdb_actors_data;
                if (count([$get_tmdb_actors_data]) > 0)
                {
                    foreach ($get_tmdb_actors_data->cast as $key => $item_act)
                    {
                        if ($key <= 4)
                        {
                            $actor_bio = null;
                            $actor_birth = null;
                            $actor_dob = null;
                            // getting actor id
                            $get_tmdb_actors_biography = @file_get_contents('https://api.themoviedb.org/3/person/' . $item_act['id'] . '?api_key=' . $TMDB_API_KEY);
                            if (isset($get_tmdb_actors_biography))
                            {
                                $get_tmdb_actors_biography = json_decode($get_tmdb_actors_biography, true);

                                $actor_bio = $get_tmdb_actors_biography['biography'];
                                $actor_birth = $get_tmdb_actors_biography['place_of_birth'];
                                $actor_dob = $get_tmdb_actors_biography['birthday'];

                            }
                            $check_list = Actor::where('name', $item_act['name'])->first();

                            if (!isset($check_list))
                            {
                                // Actor Image
                                $actor_image = null;
                                $act_image_url = $item_act['profile_path'];
                                $act_contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $act_image_url);
                                $act_img_name = substr($act_image_url, strrpos($act_image_url, '/') + 1);
                                $act_img_name = 'tmdb_' . $act_img_name;
                                if ($act_contents)
                                {
                                    $dir_created_img = Storage::disk('actor_image_path')->put($act_img_name, $act_contents);
                                    if ($dir_created_img)
                                    {
                                        $actor_image = $act_img_name;
                                    }
                                }

                                $tmdb_actor = Actor::create(['name' => $item_act['name'], 'image' => $actor_image, 'biography' => $actor_bio, 'place_of_birth' => $actor_birth, 'DOB' => $actor_dob, ]);

                                if (isset($tmdb_actor))
                                {
                                    $tmdb_actors_id->push($tmdb_actor->id);
                                }

                            }
                            else
                            {

                                $tmdb_actors_id->push($check_list->id);

                            }
                        }
                    }
                }
            }
            $tmdb_actors_id = $tmdb_actors_id->flatten();
            $tmdb_actors_id = substr($tmdb_actors_id, 1, -1);

            // Publish Year
            $pub_year = substr($season_data['air_date'], 0, 4);

            Season::create(['tv_series_id' => $input['tv_series_id'], 'tmdb_id' => $input['tmdb_id'], 'season_no' => $input['season_no'], 'tmdb' => $input['tmdb'], 'a_language' => $input['a_language'], 'subtitle' => $input['subtitle'], 'subtitle_list' => $input['subtitle_list'], 'publish_year' => (isset($pub_year) ? $pub_year : null) , 'thumbnail' => $thumbnail, 'poster' => $poster, 'actor_id' => $tmdb_actors_id, 'detail' => $season_data['overview'], ]);

            return back()->with('added', 'Season has been added');

        }

        $actor_id = $request->input('actor_id');
        if ($actor_id)
        {
            $actor_id = implode(',', $actor_id);
            $input['actor_id'] = $actor_id;
        }
        else
        {
            $input['actor_id'] = null;
        }

        if ($file = $request->file('thumbnail'))
        {
            $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
            $file->move('images/tvseries/thumbnails', $thumbnail);
            $input['thumbnail'] = $thumbnail;
        }

        if ($file = $request->file('poster'))
        {
            $poster = 'poster_' . time() . $file->getClientOriginalName();
            $file->move('images/tvseries/posters', $poster);
            $input['poster'] = $poster;
        }

        Season::create($input);
        return back()->with('added', 'Season has been added');

    }

    public function update_seasons(Request $request, $id)
    {
        $season = Season::findOrFail($id);

        $input = $request->all();
        $a_lans = $request->input('a_language');

        $request->validate(['season_no' => 'required']);

        $TMDB_API_KEY = env('TMDB_API_KEY');

        if ($a_lans)
        {
            $a_lans = implode(',', $a_lans);
            $input['a_language'] = $a_lans;
        }
        else
        {
            $input['a_language'] = null;
        }

        $actor_ids = $request->input('actor_id');
        if ($actor_ids)
        {
            $actor_ids = implode(',', $actor_ids);
            $input['actor_id'] = $actor_ids;
        }
        else
        {
            $input['actor_id'] = null;
        }

        if ($request->subtitle == 1)
        {
            $subtitles = $request->input('subtitle_list');
            if ($subtitles)
            {
                $subtitles = implode(',', $subtitles);
                $input['subtitle_list'] = $subtitles;
            }
            else
            {
                $input['subtitle_list'] = null;
            }
        }
        else
        {
            $input['subtitle_list'] = null;
            $input['subtitle'] = 0;
        }

        if ($input['tmdb'] == 'Y')
        {

            $tvseries_tmdb = TvSeries::findOrFail($input['tv_series_id']);

            if ($tvseries_tmdb->tmdb_id == null)
            {
                return back()
                    ->with('deleted', "Please add your Tv Series with TMDB than you can add or update it's seasons via TMDB");
            }

            if (Session::has('changed_language'))
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
            }
            else
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (isset($search_data))
            {
                $season_data = json_decode($search_data, true);
            }

            if (isset($season_data) && $season_data == null)
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            if ($season_data != null)
            {
                $input['tmdb_id'] = $season_data['id'];
            }
            else
            {
                return back()->with('deleted', 'Tv Series does not found by tmdb servers !');
            }

            $thumbnail = null;
            $poster = null;

            if ($file = $request->file('thumbnail'))
            {
                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                if ($season->thumbnail != null)
                {
                    $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $season->thumbnail);
                    if ($content)
                    {
                        unlink(public_path() . "/images/tvseries/thumbnails/" . $season->thumbnail);
                    }
                }
                $file->move('images/tvseries/thumbnails', $thumbnail);
            }
            else
            {
                $url = $season_data['poster_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    if ($season->thumbnail != null)
                    {
                        $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $season->thumbnail);
                        if ($content)
                        {
                            unlink(public_path() . "/images/tvseries/thumbnails/" . $season->thumbnail);
                        }
                    }
                    $tmdb_img = Storage::disk('imdb_poster_tv_series')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }
            }

            if ($file = $request->file('poster'))
            {
                $poster = 'poster_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/posters', $poster);
            }

            // get actors and create theme
            $tmdb_actors_id = collect();
            $get_tmdb_actors_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $input['season_no'] . '/credits?api_key=' . $TMDB_API_KEY);
            if ($get_tmdb_actors_data)
            {
                $get_tmdb_actors_data = json_decode($get_tmdb_actors_data, true);
                $get_tmdb_actors_data = (object)$get_tmdb_actors_data;
                if (count([$get_tmdb_actors_data]) > 0)
                {
                    foreach ($get_tmdb_actors_data->cast as $key => $item_act)
                    {
                        if ($key <= 4)
                        {
                            $actor_bio = null;
                            $actor_birth = null;
                            $actor_dob = null;
                            // getting actor id
                            $get_tmdb_actors_biography = @file_get_contents('https://api.themoviedb.org/3/person/' . $item_act['id'] . '?api_key=' . $TMDB_API_KEY);
                            if (isset($get_tmdb_actors_biography))
                            {
                                $get_tmdb_actors_biography = json_decode($get_tmdb_actors_biography, true);

                                $actor_bio = $get_tmdb_actors_biography['biography'];
                                $actor_birth = $get_tmdb_actors_biography['place_of_birth'];
                                $actor_dob = $get_tmdb_actors_biography['birthday'];

                            }
                            $check_list = Actor::where('name', $item_act['name'])->first();

                            if (!isset($check_list))
                            {
                                // Actor Image
                                $actor_image = null;
                                $act_image_url = $item_act['profile_path'];
                                $act_contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $act_image_url);
                                $act_img_name = substr($act_image_url, strrpos($act_image_url, '/') + 1);
                                $act_img_name = 'tmdb_' . $act_img_name;
                                if ($act_contents)
                                {
                                    $dir_created_img = Storage::disk('actor_image_path')->put($act_img_name, $act_contents);
                                    if ($dir_created_img)
                                    {
                                        $actor_image = $act_img_name;
                                    }
                                }

                                $tmdb_actor = Actor::create(['name' => $item_act['name'], 'image' => $actor_image, 'biography' => $actor_bio, 'place_of_birth' => $actor_birth, 'DOB' => $actor_dob, ]);

                                if (isset($tmdb_actor))
                                {
                                    $tmdb_actors_id->push($tmdb_actor->id);
                                }

                            }
                            else
                            {

                                $tmdb_actors_id->push($check_list->id);

                            }
                        }
                    }
                }
            }
            $tmdb_actors_id = $tmdb_actors_id->flatten();
            $tmdb_actors_id = substr($tmdb_actors_id, 1, -1);

            // Publish Year
            $pub_year = substr($season_data['air_date'], 0, 4);

            $season->update(['tv_series_id' => $input['tv_series_id'], 'tmdb_id' => $input['tmdb_id'], 'season_no' => $input['season_no'], 'tmdb' => $input['tmdb'], 'a_language' => $input['a_language'], 'subtitle' => $input['subtitle'], 'subtitle_list' => $input['subtitle_list'], 'publish_year' => (isset($pub_year) ? $pub_year : null) , 'thumbnail' => $thumbnail, 'poster' => $poster, 'actor_id' => $tmdb_actors_id, 'detail' => $season_data['overview'], ]);

            return back()->with('added', 'Season has been updated');

        }

        if ($file = $request->file('thumbnail'))
        {
            $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
            if ($season->thumbnail != null)
            {
                $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $season->thumbnail);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/thumbnails/" . $season->thumbnail);
                }
            }
            $file->move('images/tvseries/thumbnails', $thumbnail);
            $input['thumbnail'] = $thumbnail;
        }

        if ($file = $request->file('poster'))
        {
            $poster = 'poster_' . time() . $file->getClientOriginalName();
            if ($season->poster != null)
            {
                $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $season->poster);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/posters/" . $season->poster);
                }
            }
            $file->move('images/tvseries/posters', $poster);
            $input['poster'] = $poster;
        }

        $input['tmdb_id'] = null;

        $season->update($input);

        return back()->with('updated', 'Season has been updated');
    }

    public function destroy_seasons($id)
    {
        $season = Season::findOrFail($id);
         $episode = Episode::where('seasons_id',$id)->get();
      
            foreach ($episode as $key => $value) {
               # code...
                $videolink = Videolink::where('episode_id',$value->id)->delete();
                $value->delete();
            }

       
        if ($season->thumbnail != null)
        {
            $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $season->thumbnail);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/thumbnails/" . $season->thumbnail);
            }
        }
        if ($season->poster != null)
        {
            $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $season->poster);
            if ($content)
            {
                unlink(public_path() . "/images/tvseries/posters/" . $season->poster);
            }
        }
        $season->delete();
        return back()
            ->with('deleted', 'Season has been deleted');
    }

    /**
     * Episode Controllers
     */
    public function show_episodes($id)
    {
        $episodes = Episode::where('seasons_id', $id)->get();
        $a_lans = AudioLanguage::pluck('language', 'id')->all();
        $season = Season::findOrFail($id);
        $video_link = Videolink::where('episode_id', $id)->first();
        return view('admin.tvseries.episodes', compact('episodes', 'id', 'season', 'a_lans', 'video_link'));
    }

    public function store_episodes(Request $request)
    {
        if ($request->tmdb == 'N')
        {
            $request->validate(['title' => 'required']);
        }
        else if ($request->tmdb == 'Y')
        {
            $request->validate(['episode_no' => 'required']);
        }

        $TMDB_API_KEY = env('TMDB_API_KEY');

        $input = $request->all();

        $a_lans = $request->input('a_language');
        if ($a_lans)
        {
            $a_lans = implode(',', $a_lans);
            $input['a_language'] = $a_lans;
        }
        else
        {
            $input['a_language'] = null;
        }

        $subtitles = $request->input('subtitle_list');
        if ($subtitles)
        {
            $subtitles = implode(',', $subtitles);
            $input['subtitle_list'] = $subtitles;
        }
        else
        {
            $input['subtitle_list'] = null;
        }

        if (!isset($input['subtitle']))
        {
            $input['subtitle'] = 0;
        }

        if ($input['tmdb'] == 'Y')
        {

            $tvseries_tmdb = TvSeries::findOrFail($input['tv_series_id']);
            $season_tmdb = Season::findOrFail($input['seasons_id']);

            if ($season_tmdb->tmdb_id == null && $tvseries_tmdb->tmdb_id == null)
            {
                return back()
                    ->with('deleted', "Please add your Tv Series with TMDB than you can add or update it's seasons via TMDB");
            }

            if (Session::has('changed_language'))
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $season_tmdb->season_no . '/episode/' . $input['episode_no'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
            }
            else
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $season_tmdb->season_no . '/episode/' . $input['episode_no'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (isset($search_data))
            {
                $episode_data = json_decode($search_data, true);
            }

            if (!isset($episode_data) || $episode_data == null)
            {
                return back()->with('deleted', 'The Episode does not found by tmdb servers !');
            }

            if ($episode_data != null)
            {
                $input['tmdb_id'] = $episode_data['id'];
            }
            else
            {
                return back()->with('deleted', 'The Episode does not found by tmdb servers !');
            }

            if ($sub_file = $request->file('subtitle_files'))
            {
                $name = 'sub' . time() . $sub_file->getClientOriginalName();
                $sub_file->move('subtitles', $name);
                $input['subtitle_files'] = $name;
            }
            else
            {
                $input['subtitle_files'] = null;
            }

            $thumbnail = null;
            if ($file = $request->file('thumbnail'))
            {

                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/episodes/', $thumbnail);

            }
            else
            {

                $url = $episode_data['still_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    $tmdb_img = Storage::disk('imdb_poster_episode')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }
            }
            $created_episode = Episode::create(['seasons_id' => $input['seasons_id'], 'title' => $episode_data['name'], 'thumbnail' => $thumbnail, 'episode_no' => $input['episode_no'], 'tmdb' => $input['tmdb'], 'tmdb_id' => $input['tmdb_id'], 'subtitle' => $input['subtitle'], 'subtitle_list' => $input['subtitle_list'], 'subtitle_files' => $input['subtitle_files'], 'a_language' => $input['a_language'], 'duration' => $input['duration'], 'detail' => $episode_data['overview'], 'released' => $episode_data['air_date']]);

            if ($request->selecturl == "iframeurl")
            {

            }
            else
            {
                if ($request->has('sub_t'))
                {
                    foreach ($request->file('sub_t') as $key => $image)
                    {

                        $name = $image->getClientOriginalName();
                        $image->move(public_path() . '/subtitles/', $name);

                        $form = new Subtitles();
                        $form->sub_lang = $request->sub_lang[$key];
                        $form->sub_t = $name;
                        $form->m_t_id = $created_episode->id;
                        $form->save();
                    }
                }
            }

            if ($request->selecturl == "iframeurl")
            {

                VideoLink::create(['iframeurl' => $input['iframeurl'], 'episode_id' => $created_episode->id, 'ready_url' => null,

                ]);

            }
            else
            {
                if ($request->selecturl == "youtubeurl" || $request->selecturl == "vimeourl" || $request->selecturl == "customurl" || $request->selecturl == "vimeoapi" || $request->selecturl == "youtubeapi")
                {

                    VideoLink::create(['episode_id' => $created_episode->id, 'ready_url' => $input['ready_url'],

                    ]);

                }
                else if ($request->selecturl == "uploadvideo")
                {
                    // upload video code
                    $aws = 0;

                    if ($file = $request->file('upload_video'))
                    {
                        // return  $request;
                        if ($request->upload_aws == 'on')
                        {
                            $aws = 1;
                            $videoname = time() . $file->getClientOriginalName();

                            // aws storage
                            

                            $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                            $file->move('tvshow_upload/', $videoname);
                            $upload_video = $videoname;
                            $url_360 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/360_' . $videoname;
                            // 4800 format
                            $url_480 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/480_' . $videoname;

                            $url_720 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/720_' . $videoname;
                            // 1080 format
                            $url_1080 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/1080_' . $videoname;

                            $videoname = Storage::disk('s3')->url($videoname);

                        }

                        else
                        {
                            $videoname = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload/', $videoname);
                            $upload_video = $videoname;
                            // 360 format
                            $url_360 = asset('tv_360/360_' . $videoname);
                            // 4800 format
                            $url_480 = asset('tv_480/480_' . $videoname);

                            $url_720 = asset('tv_720/720_' . $videoname);
                            // 1080 format
                            $url_1080 = asset('tv_1080/1080_' . $videoname);

                        }

                    }

                    VideoLink::create(['episode_id' => $created_episode->id, 'upload_video' => $upload_video, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);
                    $videlin = Videolink::where('upload_video', $videoname)->first();
                    session()
                        ->put('last_episode', ['aws' => $aws, 'episode_id' => $created_episode->id,

                    ]);

                }
                elseif ($request->selecturl == 'multiqcustom')
                {

                    if ($file = $request->file('upload_video_360'))
                    {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload', $name);
                        $url_360 = asset('tvshow_upload/' . $name);
                    }
                    else
                    {
                        $url_360 = $request->url_360;
                    }

                    if ($file = $request->file('upload_video_480'))
                    {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload', $name);
                        $url_480 = asset('tvshow_upload/' . $name);
                    }
                    else
                    {
                        $url_480 = $request->url_480;
                    }

                    if ($file = $request->file('upload_video_720'))
                    {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload', $name);
                        $url_720 = asset('tvshow_upload/' . $name);
                    }
                    else
                    {
                        $url_720 = $request->url_720;
                    }

                    if ($file = $request->file('upload_video_1080'))
                    {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload', $name);
                        $url_1080 = asset('tvshow_upload/' . $name);
                    }
                    else
                    {
                        $url_1080 = $request->url_1080;
                    }

                    VideoLink::create(['episode_id' => $created_episode->id, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);

                }

            }

            return back()->with('added', 'Episode has been added');

        }

        if ($sub_file = $request->file('subtitle_files'))
        {
            $name = 'sub' . time() . $sub_file->getClientOriginalName();
            $sub_file->move('subtitles', $name);
            $input['subtitle_files'] = $name;
        }
        else
        {
            $input['subtitle_files'] = null;
        }

        $input['tmdb_id'] = null;
        if ($file = $request->file('thumbnail'))
        {
            $image = time() . $file->getClientOriginalName();
            $file->move('images/tvseries/episodes/', $image);
            $input['thumbnail'] = $image;

        }
        $created_episode = Episode::create($input);

        if ($request->selecturl == "iframeurl")
        {

        }
        else
        {
            if ($request->has('sub_t'))
            {
                foreach ($request->file('sub_t') as $key => $image)
                {

                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/subtitles/', $name);

                    $form = new Subtitles();
                    $form->sub_lang = $request->sub_lang[$key];
                    $form->sub_t = $name;
                    $form->m_t_id = $created_episode->id;
                    $form->save();
                }
            }
        }
        if ($request->selecturl == "iframeurl")
        {

            VideoLink::create(['iframeurl' => $input['iframeurl'], 'episode_id' => $created_episode->id, 'ready_url' => null,

            ]);

        }
        else
        {
            if ($request->selecturl == "youtubeurl" || $request->selecturl == "vimeourl" || $request->selecturl == "customurl" || $request->selecturl == "vimeoapi" || $request->selecturl == "youtubeapi")
            {

                VideoLink::create(['episode_id' => $created_episode->id, 'ready_url' => $input['ready_url'],

                ]);

            }
            else if ($request->selecturl == "uploadvideo")
            {
                $aws = 0;

                if ($file = $request->file('upload_video'))
                {
                    // return  $request;
                    if ($request->upload_aws == 'on')
                    {
                        $aws = 1;
                        $videoname = time() . $file->getClientOriginalName();

                        // aws storage
                        

                        $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                        $file->move('tvshow_upload/', $videoname);
                        $upload_video = $videoname;
                        $url_360 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/360_' . $videoname;
                        // 4800 format
                        $url_480 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/480_' . $videoname;

                        $url_720 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/720_' . $videoname;
                        // 1080 format
                        $url_1080 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/1080_' . $videoname;

                        $videoname = Storage::disk('s3')->url($videoname);

                    }

                    else
                    {
                        $videoname = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload/', $videoname);
                        $upload_video = $videoname;
                        // 360 format
                        $url_360 = asset('tv_360/360_' . $videoname);
                        // 4800 format
                        $url_480 = asset('tv_480/480_' . $videoname);

                        $url_720 = asset('tv_720/720_' . $videoname);
                        // 1080 format
                        $url_1080 = asset('tv_1080/1080_' . $videoname);

                    }

                }

                VideoLink::create(['episode_id' => $created_episode->id, 'upload_video' => $upload_video, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);
                $videlin = Videolink::where('upload_video', $videoname)->first();
                session()
                    ->put('last_episode', ['aws' => $aws, 'episode_id' => $created_episode->id,

                ]);
            }
            elseif ($request->selecturl == 'multiqcustom')
            {

                if ($file = $request->file('upload_video_360'))
                {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('tvshow_upload', $name);
                    $url_360 = asset('tvshow_upload/' . $name);
                }
                else
                {
                    $url_360 = $request->url_360;
                }

                if ($file = $request->file('upload_video_480'))
                {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('tvshow_upload', $name);
                    $url_480 = asset('tvshow_upload/' . $name);
                }
                else
                {
                    $url_480 = $request->url_480;
                }

                if ($file = $request->file('upload_video_720'))
                {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('tvshow_upload', $name);
                    $url_720 = asset('tvshow_upload/' . $name);
                }
                else
                {
                    $url_720 = $request->url_720;
                }

                if ($file = $request->file('upload_video_1080'))
                {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('tvshow_upload', $name);
                    $url_1080 = asset('tvshow_upload/' . $name);
                }
                else
                {
                    $url_1080 = $request->url_1080;
                }

                VideoLink::create(['episode_id' => $created_episode->id, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);

            }
        }

        return back()->with('added', 'Episode has been added');
    }

    public function edit_episodes($id, $ep_id)
    {
        $season = Season::findOrFail($id);
        $a_lans = AudioLanguage::pluck('language', 'id')->all();

        $video_link = Videolink::where('episode_id', $ep_id)->first();
        $episode = Episode::where('seasons_id', $id)->where('id', $ep_id)->first();
        $all_languages = AudioLanguage::all();
        // get old subtitle language values
        $old_subtitles = collect();
        $a_subs = collect();
        if ($episode->subtitle == 1)
        {
            if ($episode->subtitle_list != null)
            {
                $old_list = explode(',', $episode->subtitle_list);
                for ($i = 0;$i < count($old_list);$i++)
                {
                    $old2 = AudioLanguage::find(trim($old_list[$i]));
                    if (isset($old2))
                    {
                        $old_subtitles->push($old2);
                    }
                }
            }
        }
        $a_subs = $a_subs->filter(function ($value, $key)
        {
            return $value != null;
        });
        $a_subs = $all_languages->diff($old_subtitles);
        return view('admin.tvseries.episodeedit', compact('episode', 'season', 'a_lans', 'video_link', 'old_subtitles'));
    }

    public function update_episodes(Request $request, $id)
    {

        $main_episode = Episode::findOrFail($id);
         // if ($request->has('sub_t'))
         //    {
         //        foreach ($request->file('sub_t') as $key => $image)
         //        {

         //            $name = $image->getClientOriginalName();
         //            $image->move(public_path() . '/subtitles/', $name);

         //            $form = new Subtitles();
         //            $form->sub_lang = $request->sub_lang[$key];
         //            $form->sub_t = $name;
         //            $form->m_t_id = $main_episode->id;
         //            $form->save();
         //        }
         //    }

        if ($request->tmdb == 'N')
        {
            $request->validate(['title' => 'required']);
        }
        else if ($request->tmdb == 'Y')
        {
            $request->validate(['episode_no' => 'required']);
        }

        $TMDB_API_KEY = env('TMDB_API_KEY');

        $input = $request->all();

        $a_lans = $request->input('a_language');
        if ($a_lans)
        {
            $a_lans = implode(',', $a_lans);
            $input['a_language'] = $a_lans;
        }
        else
        {
            $input['a_language'] = null;
        }

        $subtitles = $request->input('subtitle_list');
        if ($subtitles)
        {
            $subtitles = implode(',', $subtitles);
            $input['subtitle_list'] = $subtitles;
        }
        else
        {
            $input['subtitle_list'] = null;
        }

        if (!isset($input['subtitle']))
        {
            $input['subtitle'] = 0;
        }

        if ($input['tmdb'] == 'Y')
        {

            $tvseries_tmdb = TvSeries::findOrFail($input['tv_series_id']);
            $season_tmdb = Season::findOrFail($input['seasons_id']);

            if ($season_tmdb->tmdb_id == null && $tvseries_tmdb->tmdb_id == null)
            {
                return back()
                    ->with('deleted', "Please add your Tv Series with TMDB than you can add or update it's seasons via TMDB");
            }

            if (Session::has('changed_language'))
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $season_tmdb->season_no . '/episode/' . $input['episode_no'] . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
            }
            else
            {
                $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tvseries_tmdb->tmdb_id . '/season/' . $season_tmdb->season_no . '/episode/' . $input['episode_no'] . '?api_key=' . $TMDB_API_KEY);
            }

            if (isset($search_data))
            {
                $episode_data = json_decode($search_data, true);
            }

            if (!isset($episode_data) || $episode_data == null)
            {
                return back()->with('deleted', 'The Episode does not found by tmdb servers !');
            }

            if ($episode_data != null)
            {
                $input['tmdb_id'] = $episode_data['id'];
            }
            else
            {
                return back()->with('deleted', 'The Episode does not found by tmdb servers !');
            }

            if ($sub_file = $request->file('subtitle_files'))
            {
                $name = 'sub' . time() . $sub_file->getClientOriginalName();
                if ($main_episode->subtitle_files != null)
                {
                    $content = @file_get_contents(public_path() . '/subtitles/' . $main_episode->subtitle_files);
                    if ($content)
                    {
                        unlink(public_path() . "/subtitles/" . $main_episode->subtitle_files);
                    }
                }
                $sub_file->move('subtitles', $name);
                $input['subtitle_files'] = $name;
            }
            else
            {
                $input['subtitle_files'] = $main_episode->subtitle_files;
            }
            $thumbnail = null;
            if ($file = $request->file('thumbnail'))
            {

                $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
                $file->move('images/tvseries/episodes/', $thumbnail);

            }
            else
            {

                $url = $episode_data['still_path'];
                $contents = @file_get_contents('https://image.tmdb.org/t/p/w300/' . $url);
                $name = substr($url, strrpos($url, '/') + 1);
                $name = 'tmdb_' . $name;
                if ($contents)
                {
                    $tmdb_img = Storage::disk('imdb_poster_episode')->put($name, $contents);
                    if ($tmdb_img)
                    {
                        $thumbnail = $name;
                    }
                }
            }

            $main_episode->update(['seasons_id' => $input['seasons_id'], 'title' => $episode_data['name'], 'thumbnail' => $thumbnail, 'episode_no' => $input['episode_no'], 'tmdb' => $input['tmdb'], 'tmdb_id' => $input['tmdb_id'], 'subtitle' => $input['subtitle'], 'subtitle_list' => $input['subtitle_list'], 'subtitle_files' => $input['subtitle_files'], 'a_language' => $input['a_language'], 'duration' => $input['duration'], 'detail' => $episode_data['overview'], 'released' => $episode_data['air_date']]);

            if ($request->selecturl == "iframeurl")
            {

            }
            else
            {
                if ($request->has('sub_t'))
                {
                    foreach ($request->file('sub_t') as $key => $image)
                    {

                        $name = $image->getClientOriginalName();
                        $image->move(public_path() . '/subtitles/', $name);

                        $form = new Subtitles();
                        $form->sub_lang = $request->sub_lang[$key];
                        $form->sub_t = $name;
                        $form->m_t_id = $id;
                        $form->save();
                    }
                }
            }

            if (isset($main_episode->video_link))
            {

                if ($request->selecturl == 'iframeurl')
                {

                    $main_episode
                        ->video_link
                        ->update(['iframeurl' => $input['iframeurl'], 'upload_video' => null, 'ready_url' => null, 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

                }
                else
                {
                    if ($request->selecturl == "youtubeurl" || $request->selecturl == "vimeourl" || $request->selecturl == "customurl" || $request->selecturl == "vimeoapi" || $request->selecturl == "youtubeapi")
                    {

                        $main_episode
                            ->video_link
                            ->update(['iframeurl' => null, 'upload_video' => null, 'ready_url' => $input['ready_url'], 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

                    }
                    else if ($request->selecturl == "uploadvideo")
                    {

                        $aws = 0;

                        if ($file = $request->file('upload_video'))
                        {
                            // return  $request;
                            if ($request->upload_aws == 'on')
                            {
                                $aws = 1;
                                $videoname = time() . $file->getClientOriginalName();

                                // aws storage
                                

                                $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                                $file->move('tvshow_upload/', $videoname);
                                $upload_video = $videoname;
                                $url_360 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/360_' . $videoname;
                                // 4800 format
                                $url_480 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/480_' . $videoname;

                                $url_720 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/720_' . $videoname;
                                // 1080 format
                                $url_1080 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/1080_' . $videoname;

                                $videoname = Storage::disk('s3')->url($videoname);

                            }

                            else
                            {
                                $videoname = time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload/', $videoname);
                                $upload_video = $videoname;
                                // 360 format
                                $url_360 = asset('tv_360/360_' . $videoname);
                                // 4800 format
                                $url_480 = asset('tv_480/480_' . $videoname);

                                $url_720 = asset('tv_720/720_' . $videoname);
                                // 1080 format
                                $url_1080 = asset('tv_1080/1080_' . $videoname);

                            }

                        }

                        $main_episode
                            ->video_link
                            ->update(['iframeurl' => null, 'ready_url' => null, 'upload_video' => $upload_video, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);

                        $videlin = Videolink::where('upload_video', $videoname)->first();
                        session()
                            ->put('last_episode', ['aws' => $aws, 'episode_id' => $main_episode->id,

                        ]);

                    }
                    elseif ($request->selecturl == 'multiqcustom')
                    {
                        $url = url('/tvshow_upload');

                        if ($file = $request->file('upload_video_360'))
                        {
                            if($main_episode->video_link->url_360 != ''){

                                $file_360 = trim($main_episode
                                ->video_link->url_360, $url);

                            if (file_exists('tvshow_upload/' . $file_360))
                            {
                                unlink('tvshow_upload/' . $file_360);
                            }

                            $name = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_360 = asset('tvshow_upload/' . $name);
                            }
                            else{
                                 if ($file = $request->file('upload_video_360'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_360 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }

                        }
                        else
                        {

                            if ($main_episode->video_link->url_360 != $request->url_360)
                            {

                                // if($main_episode->video_link->url_360 != ''){
                                //     $file_360 = trim($main_episode
                                //     ->video_link->url_360, $url);

                                // if (file_exists('tvshow_upload/' . $file_360))
                                // {
                                //     $file_360 = trim($main_episode
                                //         ->video_link->url_360, $url);
                                //     unlink('tvshow_upload/' . $file_360);
                                // }

                                // }

                                $url_360 = $request->url_360;

                            }
                            else
                            {
                                $url_360 = $main_episode->video_link->url_360;
                            }

                        }

                        if ($file = $request->file('upload_video_480'))
                        {
                            
                            if($main_episode->video_link->url_480 != ''){

                                $file_480 = trim($main_episode
                                ->video_link->url_480, $url);

                                if (file_exists('tvshow_upload/' . $file_480))
                                {
                                    unlink('tvshow_upload/' . $file_480);
                                }

                                $name = time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_480 = asset('tvshow_upload/' . $name);

                            }
                            else{
                                 if ($file = $request->file('upload_video_480'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_480 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }
                            

                        }
                        else
                        {

                            if ($main_episode->video_link->url_480 != $request->url_480)
                            {
                                $url_480 = $request->url_480;
                                // if($main_episode->video_link->url_480 != ''){

                                //     $file_480 = trim($main_episode
                                //     ->video_link->url_480, $url);

                                //     if (file_exists('tvshow_upload/' . $file_480))
                                //     {
                                //         $file_480 = trim($main_episode
                                //             ->video_link->url_480, $url);
                                //         unlink('tvshow_upload/' . $file_360);
                                //     }

                                //     $url_480 = $request->url_480;

                                // }
                                

                            }
                            else
                            {
                                $url_480 = $main_episode->video_link->url_480;
                            }

                        }

                        if ($file = $request->file('upload_video_720'))
                        {

                             if($main_episode->video_link->url_720 != ''){

                                $file_720 = trim($main_episode->video_link->url_720, $url);

                                if (file_exists('tvshow_upload/' . $file_720))
                                {
                                    unlink('tvshow_upload/' . $file_720);
                                }

                                $name = time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_720 = asset('tvshow_upload/' . $name);
                            }
                            else{

                                 if ($file = $request->file('upload_video_720'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_720 = asset('tvshow_upload/' . $name);

                                }
                            }

                        }
                        else
                        {

                            if ($main_episode->video_link->url_720 != $request->url_720)
                            {
                                $url_720 = $request->url_720;


//                                 if($main_episode->video_link->url_720 != ''){
// return 'hi';

//                                     $file_720 = trim($main_episode
//                                     ->video_link->url_720, $url);

//                                     if (file_exists('tvshow_upload/' . $file_720))
//                                     {
//                                         $file_720 = trim($main_episode
//                                             ->video_link->url_720, $url);
//                                         unlink('tvshow_upload/' . $file_720);
//                                     }

//                                     $url_720 = $request->url_720;
//                                 }
//                                 return 'hii';


                            }
                            else
                            {
                                $url_720 = $main_episode->video_link->url_720;
                            }

                        }

                        if ($file = $request->file('upload_video_1080'))
                        {
                            
                            if($main_episode->video_link->url_1080 != ''){
                                
                                $file_1080 = trim($main_episode->video_link->url_1080, $url);

                                if (file_exists('tvshow_upload/' . $file_1080))
                                {

                                    unlink('tvshow_upload/' . $file_1080);
                                }

                                $name = str_random(5) . time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_1080 = asset('tvshow_upload/' . $name);

                            }
                            else{
                                
                                  if ($file = $request->file('upload_video_1080'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_1080 = asset('tvshow_upload/' . $name);
                                   
                                }

                            }

                        }
                        else
                        {

                            if ($main_episode->video_link->url_1080 != $request->url_1080)
                            {
                                 $url_1080 = $request->url_1080;

                                // if($main_episode
                                //     ->video_link->url_1080 !=''){
                                //     $file_1080 = trim($main_episode
                                //     ->video_link->url_1080, $url);

                                // if (file_exists('tvshow_upload/' . $file_1080))
                                // {
                                //     $file_1080 = trim($main_episode
                                //         ->video_link->url_1080, $url);
                                //     unlink('tvshow_upload/' . $file_1080);
                                // }

                                // $url_1080 = $request->url_1080;
                                // }

                            }
                            else
                            {
                                $url_1080 = $request->url_1080;
                            }

                        }

                        $main_episode->video_link->update(['url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080,'ready_url'=>null,'iframeurl'=>null]);

                    }

                }

            }
            else
            {

                if ($request->ready_url_check == 1)
                {

                    VideoLink::create(['episode_id' => $main_episode->id, 'ready_url' => $input['ready_url'], 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

                }
                else
                {

                    VideoLink::create(['episode_id' => $main_episode->id, 'ready_url' => null, 'url_360' => $input['url_360'], 'url_480' => $input['url_480'], 'url_720' => $input['url_720'], 'url_1080' => $input['url_1080'], ]);

                }

            }

            return back()->with('updated', 'Episode has been updated');

        }

        $input['tmdb_id'] = null;

        if ($sub_file = $request->file('subtitle_files'))
        {
            $name = 'sub' . time() . $sub_file->getClientOriginalName();
            if ($main_episode->subtitle_files != null)
            {
                $content = @file_get_contents(public_path() . '/subtitles/' . $main_episode->subtitle_files);
                if ($content)
                {
                    unlink(public_path() . "/subtitles/" . $main_episode->subtitle_files);
                }
            }
            $sub_file->move('subtitles', $name);
            $input['subtitle_files'] = $name;
        }
        else
        {
            $input['subtitle_files'] = $main_episode->subtitle_files;
        }
        $thumbnail = null;
        if ($file = $request->file('thumbnail'))
        {

            $thumbnail = 'thumb_' . time() . $file->getClientOriginalName();
            $file->move('images/tvseries/episodes/', $thumbnail);
            $input['thumbnail'] = $thumbnail;
        }

        $main_episode->update($input);

        if ($request->selecturl == "iframeurl")
        {

        }
        else
        {
            if ($request->has('sub_t'))
            {
                foreach ($request->file('sub_t') as $key => $image)
                {

                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/subtitles/', $name);

                    $form = new Subtitles();
                    $form->sub_lang = $request->sub_lang[$key];
                    $form->sub_t = $name;
                    $form->m_t_id = $id;
                    $form->save();
                }
            }
        }

        if (isset($main_episode->video_link))
        {

            if ($request->selecturl == "iframeurl")
            {

                $main_episode
                    ->video_link
                    ->update(['iframeurl' => $input['iframeurl'], 'ready_url' => null, 'upload_video' => null, 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

            }
            else
            {
                if ($request->selecturl == "youtubeurl" || $request->selecturl == "vimeourl" || $request->selecturl == "customurl" || $request->selecturl == "vimeoapi" || $request->selecturl == "youtubeapi")
                {

                    $main_episode
                        ->video_link
                        ->update(['iframeurl' => null, 'upload_video' => null, 'ready_url' => $input['ready_url'], 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

                }
                else if ($request->selecturl == "uploadvideo")
                {
                    $aws = 0;

                    if ($file = $request->file('upload_video'))
                    {
                        // return  $request;
                        if ($request->upload_aws == 'on')
                        {
                            $aws = 1;
                            $videoname = time() . $file->getClientOriginalName();

                            // aws storage
                            

                            $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                            $file->move('tvshow_upload/', $videoname);
                            $upload_video = $videoname;
                            $url_360 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/360_' . $videoname;
                            // 4800 format
                            $url_480 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/480_' . $videoname;

                            $url_720 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/720_' . $videoname;
                            // 1080 format
                            $url_1080 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/1080_' . $videoname;

                            $videoname = Storage::disk('s3')->url($videoname);

                        }

                        else
                        {
                            $videoname = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload/', $videoname);
                            $upload_video = $videoname;
                            // 360 format
                            $url_360 = asset('tv_360/360_' . $videoname);
                            // 4800 format
                            $url_480 = asset('tv_480/480_' . $videoname);

                            $url_720 = asset('tv_720/720_' . $videoname);
                            // 1080 format
                            $url_1080 = asset('tv_1080/1080_' . $videoname);

                        }

                    }

                    $main_episode
                        ->video_link
                        ->update(['iframeurl' => null, 'ready_url' => null, 'upload_video' => $upload_video, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);

                    $videlin = Videolink::where('upload_video', $videoname)->first();
                    session()
                        ->put('last_episode', ['aws' => $aws, 'episode_id' => $main_episode->id,

                    ]);

                }
                elseif ($request->selecturl == 'multiqcustom')
                {
                        $url = url('/tvshow_upload');

                        if ($file = $request->file('upload_video_360'))
                        {
                            if($main_episode->video_link->url_360 != ''){

                                $file_360 = trim($main_episode
                                ->video_link->url_360, $url);

                            if (file_exists('tvshow_upload/' . $file_360))
                            {
                                unlink('tvshow_upload/' . $file_360);
                            }

                            $name = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_360 = asset('tvshow_upload/' . $name);
                            }
                            else{
                                 if ($file = $request->file('upload_video_360'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_360 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }

                        }
                        else
                        {

                            if ($main_episode->video_link->url_360 != $request->url_360)
                            {

                                // if($main_episode->video_link->url_360 != ''){
                                //     $file_360 = trim($main_episode
                                //     ->video_link->url_360, $url);

                                // if (file_exists('tvshow_upload/' . $file_360))
                                // {
                                //     $file_360 = trim($main_episode
                                //         ->video_link->url_360, $url);
                                //     unlink('tvshow_upload/' . $file_360);
                                // }

                                // }

                                $url_360 = $request->url_360;

                            }
                            else
                            {
                                $url_360 = $request->url_360;
                            }

                        }

                        if ($file = $request->file('upload_video_480'))
                        {
                            
                            if($main_episode->video_link->url_480 != ''){

                                $file_480 = trim($main_episode
                                ->video_link->url_480, $url);

                                if (file_exists('tvshow_upload/' . $file_480))
                                {
                                    unlink('tvshow_upload/' . $file_480);
                                }

                                $name = time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_480 = asset('tvshow_upload/' . $name);

                            }
                            else{
                                 if ($file = $request->file('upload_video_480'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_480 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }
                            

                        }
                        else
                        {

                            if ($main_episode->video_link->url_480 != $request->url_480)
                            {

                                    $url_480 = $request->url_480;
                                // if($main_episode->video_link->url_480 != ''){

                                //     $file_480 = trim($main_episode
                                //     ->video_link->url_480, $url);

                                //     if (file_exists('tvshow_upload/' . $file_480))
                                //     {
                                //         $file_480 = trim($main_episode
                                //             ->video_link->url_480, $url);
                                //         unlink('tvshow_upload/' . $file_360);
                                //     }

                                //     $url_480 = $request->url_480;

                                // }
                                

                            }
                            else
                            {
                                $url_480 = $request->url_480;
                            }

                        }

                        if ($file = $request->file('upload_video_720'))
                        {

                             if($main_episode->video_link->url_720 != ''){

                                $file_720 = trim($main_episode->video_link->url_720, $url);

                                if (file_exists('tvshow_upload/' . $file_720))
                                {
                                    unlink('tvshow_upload/' . $file_720);
                                }

                                $name = time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_720 = asset('tvshow_upload/' . $name);
                            }
                            else{
                                 if ($file = $request->file('upload_video_720'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_720 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }

                        }
                        else
                        {

                            if ($main_episode->video_link->url_720 != $request->url_720)
                            {
                                    $url_720 = $request->url_720;
                                // if($main_episode->video_link->url_720 != ''){

                                //     $file_720 = trim($main_episode
                                //     ->video_link->url_720, $url);

                                //     if (file_exists('tvshow_upload/' . $file_720))
                                //     {
                                //         $file_720 = trim($main_episode
                                //             ->video_link->url_720, $url);
                                //         unlink('tvshow_upload/' . $file_720);
                                //     }

                                //     $url_720 = $request->url_720;
                                // }

                            }
                            else
                            {
                                $url_720 = $request->url_720;
                            }

                        }

                        if ($file = $request->file('upload_video_1080'))
                        {
                            
                            if($main_episode->video_link->url_1080 != ''){
                                
                                $file_1080 = trim($main_episode
                                    ->video_link->url_1080, $url);

                                if (file_exists('tvshow_upload/' . $file_1080))
                                {

                                    unlink('tvshow_upload/' . $file_1080);
                                }

                                $name = str_random(5) . time() . $file->getClientOriginalName();
                                $file->move('tvshow_upload', $name);
                                $url_1080 = asset('tvshow_upload/' . $name);

                            }
                            else{
                                 if ($file = $request->file('upload_video_1080'))
                                {

                                    $name = time() . $file->getClientOriginalName();
                                    $file->move('tvshow_upload', $name);
                                    $url_1080 = asset('tvshow_upload/' . $name);
                                   
                                }
                            }

                        }
                        else
                        {

                            if ($main_episode
                                ->video_link->url_1080 != $request->url_1080)
                            {
                                 $url_1080 = $request->url_1080;
                                // if($main_episode
                                //     ->video_link->url_1080 !=''){
                                //     $file_1080 = trim($main_episode
                                //     ->video_link->url_1080, $url);

                                // if (file_exists('tvshow_upload/' . $file_1080))
                                // {
                                //     $file_1080 = trim($main_episode
                                //         ->video_link->url_1080, $url);
                                //     unlink('tvshow_upload/' . $file_1080);
                                // }

                                // $url_1080 = $request->url_1080;
                                // }

                            }
                            else
                            {
                                $url_1080 = $request->url_1080;
                            }

                        }

                        $main_episode
                            ->video_link
                            ->update(['url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080,'ready_url'=>null,'iframeurl'=>null]);

                    }
            }

        }
        else
        {

            if ($request->selecturl == "iframeurl")
            {

                VideoLink::create(['episode_id' => $main_episode->id, 'ready_url' => $input['ready_url'], 'url_360' => null, 'url_480' => null, 'url_720' => null, 'url_1080' => null]);

            }
            else if ($request->selecturl == "uploadvideo")
            {

                $aws = 0;

                if ($file = $request->file('upload_video'))
                {
                    // return  $request;
                    if ($request->upload_aws == 'on')
                    {
                        $aws = 1;
                        $videoname = time() . $file->getClientOriginalName();

                        // aws storage
                        

                        $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                        $file->move('tvshow_upload/', $videoname);
                        $upload_video = $videoname;
                        $url_360 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/360_' . $videoname;
                        // 4800 format
                        $url_480 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/480_' . $videoname;

                        $url_720 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/720_' . $videoname;
                        // 1080 format
                        $url_1080 = 'https://' . env('bucket') . '.s3.' . env('region') . '.amazonaws.com/1080_' . $videoname;

                        $videoname = Storage::disk('s3')->url($videoname);

                    }

                    else
                    {
                        $videoname = time() . $file->getClientOriginalName();
                        $file->move('tvshow_upload/', $videoname);
                        $upload_video = $videoname;
                        // 360 format
                        $url_360 = asset('tv_360/360_' . $videoname);
                        // 4800 format
                        $url_480 = asset('tv_480/480_' . $videoname);

                        $url_720 = asset('tv_720/720_' . $videoname);
                        // 1080 format
                        $url_1080 = asset('tv_1080/1080_' . $videoname);

                    }

                }

                VideoLink::create(['episode_id' => $main_episode->id, 'upload_video' => $upload_video, 'url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080]);
                $videlin = Videolink::where('upload_video', $videoname)->first();
                session()
                    ->put('last_episode', ['aws' => $aws, 'episode_id' => $main_episode->id,

                ]);

            }
            elseif ($request->selecturl == 'multiqcustom')
                    {
                        $url = url('/tvshow_upload');

                        if ($file = $request->file('upload_video_360'))
                        {
                            $file_360 = trim($main_episode
                                ->video_link->url_360, $url);

                            if (file_exists('tvshow_upload/' . $file_360))
                            {
                                unlink('tvshow_upload/' . $file_360);
                            }

                            $name = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_360 = asset('tvshow_upload/' . $name);

                        }
                        else
                        {

                            if ($main_episode
                                ->video_link->url_360 != $request->url_360)
                            {

                                // $file_360 = trim($main_episode
                                //     ->video_link->url_360, $url);

                                // if (file_exists('tvshow_upload/' . $file_360))
                                // {
                                //     $file_360 = trim($main_episode
                                //         ->video_link->url_360, $url);
                                //     unlink('tvshow_upload/' . $file_360);
                                // }
                                 $url_1080 = $request->url_1080;

                               

                            }
                            else
                            {
                                $url_360 = $request->url_360;
                            }

                        }

                        if ($file = $request->file('upload_video_480'))
                        {
                            $file_480 = trim($main_episode
                                ->video_link->url_480, $url);

                            if (file_exists('tvshow_upload/' . $file_480))
                            {
                                unlink('tvshow_upload/' . $file_480);
                            }

                            $name = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_480 = asset('tvshow_upload/' . $name);

                        }
                        else
                        {

                            if ($main_episode
                                ->video_link->url_480 != $request->url_480)
                            {

                                // $file_480 = trim($main_episode
                                //     ->video_link->url_480, $url);

                                // if (file_exists('tvshow_upload/' . $file_480))
                                // {
                                //     $file_480 = trim($movie
                                //         ->video_link->url_480, $url);
                                //     unlink('tvshow_upload/' . $file_360);
                                // }

                                $url_480 = $request->url_480;

                            }
                            else
                            {
                                $url_480 = $request->url_480;
                            }

                        }

                        if ($file = $request->file('upload_video_720'))
                        {

                            $file_720 = trim($main_episode
                                ->video_link->url_720, $url);

                            if (file_exists('tvshow_upload/' . $file_720))
                            {
                                unlink('tvshow_upload/' . $file_720);
                            }

                            $name = time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_720 = asset('tvshow_upload/' . $name);

                        }
                        else
                        {

                            if ($main_episode
                                ->video_link->url_720 != $request->url_720)
                            {

                                // $file_720 = trim($main_episode
                                //     ->video_link->url_720, $url);

                                // if (file_exists('tvshow_upload/' . $file_720))
                                // {
                                //     $file_720 = trim($main_episode
                                //         ->video_link->url_720, $url);
                                //     unlink('tvshow_upload/' . $file_720);
                                // }

                                $url_720 = $request->url_720;

                            }
                            else
                            {
                                $url_720 = $request->url_720;
                            }

                        }

                        if ($file = $request->file('upload_video_1080'))
                        {
                            $file_1080 = trim($main_episode
                                ->video_link->url_1080, $url);

                            if (file_exists('tvshow_upload/' . $file_1080))
                            {

                                unlink('tvshow_upload/' . $file_1080);
                            }

                            $name = str_random(5) . time() . $file->getClientOriginalName();
                            $file->move('tvshow_upload', $name);
                            $url_1080 = asset('tvshow_upload/' . $name);

                        }
                        else
                        {

                            if ($main_episode
                                ->video_link->url_1080 != $request->url_1080)
                            {

                                // $file_1080 = trim($main_episode
                                //     ->video_link->url_1080, $url);

                                // if (file_exists('tvshow_upload/' . $file_1080))
                                // {
                                //     $file_1080 = trim($main_episode
                                //         ->video_link->url_1080, $url);
                                //     unlink('tvshow_upload/' . $file_1080);
                                // }

                                $url_1080 = $request->url_1080;

                            }
                            else
                            {
                                $url_1080 = $request->url_1080;
                            }

                        }

                        $main_episode
                            ->video_link
                            ->create(['url_360' => $url_360, 'url_480' => $url_480, 'url_720' => $url_720, 'url_1080' => $url_1080,'ready_url'=>null,'iframeurl'=>null]);

                    }

        }

        return back()
            ->with('updated', 'Episode has been updated');
    }

    public function destroy_episodes($id)
    {
        $episode = Episode::findOrFail($id);
        if ($episode->subtitle_files != null)
        {
            $content = @file_get_contents(public_path() . '/subtitles/' . $episode->subtitle_files);
            if ($content)
            {
                unlink(public_path() . "/subtitles/" . $episode->subtitle_files);
            }
        }

        $url = url('/tvshow_upload');

        if($episode->video_link->url_360 != ''){
            $file_360 = trim($episode->video_link->url_360, $url);
            if (file_exists('tvshow_upload/' . $file_360))
            {
                unlink('tvshow_upload/' . $file_360);
            }
        }

        if($episode->video_link->url_480){
            $file_480 = trim($episode->video_link->url_480, $url);
            if (file_exists('tvshow_upload/' . $file_480))
            {
                unlink('tvshow_upload/' . $file_480);
            }
        }

       if($episode->video_link->url_720 != ''){
            $file_720 = trim($episode->video_link->url_720, $url);
            if (file_exists('tvshow_upload/' . $file_720))
            {
                unlink('tvshow_upload/' . $file_720);
            }
       }

        if($episode->video_link->url_1080 != ''){
            $file_1080 = trim($episode->video_link->url_1080, $url);
            if (file_exists('tvshow_upload/' . $file_1080))
            {
                unlink('tvshow_upload/' . $file_1080);
            }
        }

        $episode->delete();
        return back()->with('deleted', 'Episode has been deleted');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all() , ['checked' => 'required', ]);

        if ($validator->fails())
        {

            return back()
                ->with('deleted', 'Please check one of them to delete');
        }

        foreach ($request->checked as $checked)
        {
            $watched = WatchHistory::where('tv_id', $checked)->delete();

            $tvseries = TvSeries::findOrFail($checked);

            if ($tvseries->thumbnail != null)
            {
                $content = @file_get_contents(public_path() . '/images/tvseries/thumbnails/' . $tvseries->thumbnail);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/thumbnails/" . $tvseries->thumbnail);
                }
            }
            if ($tvseries->poster != null)
            {
                $content = @file_get_contents(public_path() . '/images/tvseries/posters/' . $tvseries->poster);
                if ($content)
                {
                    unlink(public_path() . "/images/tvseries/posters/" . $tvseries->poster);
                }
            }

            TvSeries::destroy($checked);
        }

        return back()->with('deleted', 'Tv Shows has been deleted');
    }

    /**
     * Translate the specified resource from storage.
     * Translate all tmdb movies on one click
     * @return \Illuminate\Http\Response
     */
    public function tmdb_translations()
    {
        ini_set('max_execution_time', 3000);
        $all_tv = TvSeries::where('tmdb', 'Y')->get();
        $TMDB_API_KEY = env('TMDB_API_KEY');

        if ($TMDB_API_KEY == null || $TMDB_API_KEY == '')
        {
            return back()->with('deleted', 'Please provide your TMDB api key to translate');
        }

        if (isset($all_tv) && count($all_tv) > 0)
        {
            foreach ($all_tv as $key => $tv)
            {
                if (Session::has('changed_language'))
                {
                    $fetch_tv = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tv->tmdb_id . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
                }
                else
                {
                    return back()->with('updated', 'Please Choose a language by admin panel top right side language menu');
                }

                $tmdb_tv = json_decode($fetch_tv, true);
                if (isset($tmdb_tv) && $tmdb_tv != null)
                {
                    $tv->update(['detail' => $tmdb_tv['overview']]);
                }

                if (isset($tv->seasons) && count($tv->seasons) > 0)
                {
                    foreach ($tv->seasons as $season)
                    {
                        if ($season->tmdb == 'Y')
                        {
                            $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tv->tmdb_id . '/season/' . $season->season_no . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
                            if (isset($search_data))
                            {
                                $season_data = json_decode($search_data, true);
                            }
                            if (isset($season_data) && $season_data != null)
                            {
                                $season->update(['detail' => $season_data['overview']]);
                            }
                            if (isset($season->episodes) && count($season->episodes) > 0)
                            {
                                foreach ($season->episodes as $episode)
                                {
                                    if ($episode->tmdb == 'Y')
                                    {
                                        $search_data = @file_get_contents('https://api.themoviedb.org/3/tv/' . $tv->tmdb_id . '/season/' . $season->season_no . '/episode/' . $episode->episode_no . '?api_key=' . $TMDB_API_KEY . '&language=' . Session::get('changed_language'));
                                        if (isset($search_data))
                                        {
                                            $episode_data = json_decode($search_data, true);
                                        }
                                        if (isset($episode_data) && $episode_data != null)
                                        {
                                            $episode->update(['detail' => $episode_data['overview']]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return back()->with('added', 'All TvSeries and its seasons and episodes (only by TMDB) has been translated');
        }
        else
        {
            return back()
                ->with('updated', 'Please create at least one tvseries by TMDB option to translate');
        }
    }

    public function upload_video()
    {
        $last_episode = Session::get('last_episode');
        $movie_id = $last_episode['episode_id'];
        $senttoaws = $last_episode['aws'];

        $id = VideoLink::where('episode_id', $movie_id)->first();
        $siteurl = \URL::to('');
        $videoname = $id->upload_video;
        if (isset($videoname))
        {

            // 360p
            \FFMpeg::fromDisk('tvshow_upload')->open($videoname)->addFilter(function ($filters)
            {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 360));
            })
                ->addFilter('-preset', 'ultrafast')
                ->export()
                ->toDisk('tv_360')
                ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                ->save('360_' . $videoname);
            if ($senttoaws == 1)
            {
                $t = Storage::disk('s3')->put('360_' . $videoname, Storage::disk('tv_360')->get('360_' . $videoname) , 'public');

                $content = @file_get_contents(public_path() . '/tv_360/' . '360_' . $videoname);
                if ($content)
                {
                    unlink(public_path() . "/tv_360/" . '360_' . $videoname);
                }

            }

            // 480p
            \FFMpeg::fromDisk('tvshow_upload')->open($videoname)->addFilter(function ($filters)
            {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(1024, 576));
            })
                ->export()
                ->toDisk('tv_480')
                ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                ->save('480_' . $videoname);
            if ($senttoaws == 1)
            {
                $t = Storage::disk('s3')->put('480_' . $videoname, Storage::disk('tv_480')->get('480_' . $videoname) , 'public');
                $content = @file_get_contents(public_path() . '/tv_480/' . '480_' . $videoname);
                if ($content)
                {
                    unlink(public_path() . "/tv_480/" . '480_' . $videoname);
                }
            }

            //720p
            \FFMpeg::fromDisk('tvshow_upload')->open($videoname)->addFilter(function ($filters)
            {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(1280, 720));
            })
                ->export()
                ->toDisk('tv_720')
                ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                ->save('720_' . $videoname);
            if ($senttoaws == 1)
            {
                $t = Storage::disk('s3')->put('720_' . $videoname, Storage::disk('tv_720')->get('720_' . $videoname) , 'public');
                $content = @file_get_contents(public_path() . '/tv_720/' . '720_' . $videoname);
                if ($content)
                {
                    unlink(public_path() . "/tv_720/" . '720_' . $videoname);
                }
            }

            // 1080p
            \FFMpeg::fromDisk('tvshow_upload')->open($videoname)->addFilter(function ($filters)
            {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(2000, 1080));
            })
                ->export()
                ->toDisk('tv_1080')
                ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                ->save('1080_' . $videoname);
            if ($senttoaws == 1)
            {
                $t = Storage::disk('s3')->put('1080_' . $videoname, Storage::disk('tv_1080')->get('1080_' . $videoname) , 'public');
                $content = @file_get_contents(public_path() . '/tv_1080/' . '1080_' . $videoname);
                if ($content)
                {
                    unlink(public_path() . "/tv_1080/" . '1080_' . $videoname);
                }
            }

        }
    }

}

