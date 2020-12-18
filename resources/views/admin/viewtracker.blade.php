@extends('layouts.admin')
@section('title','View Track')
@section('content')
  <div class="content-main-block mrg-t-40">
        <div class="content-block box-body">
                <div>

                        <!-- Nav tabs -->
                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Movies</a></li>
                          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">TV Shows</a></li>
                          
                        </ul>
                      
                        <!-- Tab panes -->
                        <div class="tab-content">

                          <div role="tabpanel" class="tab-pane fade table-responsive in active" id="home">
                              <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>Movie Name</th>
                                        <th>Views</th>
                                       
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($movies as $key => $movie)
                                      
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $movie->title }}</td>
                                        <td><i class="fa fa-eye"></i> {{ views($movie)
                                            ->unique()
                                            ->count() }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                          <div role="tabpanel" class="tab-pane fade table-responsive" id="profile">
                              <br>
                             <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tv Series Name</th>
                                        <th>Views</th>
                                       
                                    </tr>
                                </thead>

                                <tbody>
                                        @foreach ($season as $key => $s)
                                      
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $s->tvseries['title'] }} [Season: {{ $s->season_no }}]</td>
                                            <td><i class="fa fa-eye"></i> {{ views($s)
                                                ->unique()
                                                ->count() }}</td>
                                        </tr>
    
                                        @endforeach
                                </tbody>
                            </table> 
                          </div>
                          
                        </div>
                      
                      </div>
        </div>
  </div>
@endsection
@section('custom-script')
    <script>
        $(document).ready(function(){

            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
@endsection