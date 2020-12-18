@extends('layouts.admin')
@section('title','Slider')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
      <a href="{{route('home_slider.create')}}" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Add Slide</a>
      <!-- Delete Modal -->
      <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="material-icons left">delete</i> Delete Selected</a>   
      <!-- Modal -->
      <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
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
              {!! Form::open(['method' => 'POST', 'action' => 'HomeSliderController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <p class="info">You can change the position of items by DRAG &amp; DROP</p>
    <div class="content-block box-body">
      <table id="full_detail_table" class="table table-hover db">
        <thead>
          <tr class="table-heading-row">
          <th>
            <div class="inline">
              <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
              <label for="checkboxAll" class="material-checkbox"></label>
            </div>
            #
          </th>
          <th>Movie</th>
          <th>Tv Series</th>
          <th>Slide Image</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
        </thead>
        @if ($home_slides)
          <tbody>
          @foreach ($home_slides as $key => $home_slide)
            <tr id="item-{{$home_slide->id}}">
              <td>
                <div class="inline">
                  <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$home_slide->id}}" id="checkbox{{$home_slide->id}}">
                  <label for="checkbox{{$home_slide->id}}" class="material-checkbox"></label>
                </div>
                <a class="handle"><i class="fa fa-unsorted" style="opacity: 0.3"></i></a>
                {{$key+1}}
              </td>
              <td>{{$home_slide->movie ? $home_slide->movie->title : '-'}}</td>
              <td>{{$home_slide->tvseries ? $home_slide->tvseries->title : '-'}}</td>
              <td>
                @if($home_slide->movie)
                  @if ($home_slide->slide_image != null)
                    <img src="{{asset('images/home_slider/movies/'. $home_slide->slide_image)}}" class="img-responsive" alt="slider-image">
                  @elseif ($home_slide->movie->poster != null)
                    <img src="{{asset('images/movies/posters/'. $home_slide->movie->poster)}}" class="img-responsive" alt="slider-image">
                  @endif
                @else
                  @if ($home_slide->slide_image != null)
                    <img src="{{asset('images/home_slider/shows/'. $home_slide->slide_image)}}" class="img-responsive" alt="slider-image">
                  @elseif ($home_slide->tvseries->poster != null)
                    <img src="{{asset('images/tvseries/posters/'. $home_slide->tvseries->poster)}}" class="img-responsive" alt="slider-image">
                  @endif
                @endif
              </td>
              <td>{{$home_slide->active == 1 ? 'Active' : 'inactive'}}</td>
              <td>
                <div class="admin-table-action-block">
                  <a href="{{route('home_slider.edit', $home_slide->id)}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
                  <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$home_slide->id}}deleteModal"><i class="material-icons">delete</i> </button>
                </div>
              </td>
            </tr>
            <!-- Delete Modal -->
            <div id="{{$home_slide->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                    {!! Form::open(['method' => 'DELETE', 'action' => ['HomeSliderController@destroy', $home_slide->id]]) !!}
                        <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </tbody>
        @endif
      </table>
    </div>
  </div>
@endsection
@section('custom-script')
<script>
  $(function(){
    $('#checkboxAll').on('change', function(){
      if($(this).prop("checked") == true){
        $('.material-checkbox-input').attr('checked', true);
      }
      else if($(this).prop("checked") == false){
        $('.material-checkbox-input').attr('checked', false);
      }
    });
  });
  var app = new Vue({});
  $('table.db tbody').sortable({
    cursor: "move",
    revert: true,
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    forcePlaceholderSize: true,
    zIndex: 999999,
    axis: 'y',
    update: function(event, ui) {
      var data = $(this).sortable('serialize');
      app.$http.post('{{route('slide_reposition')}}', {item: data}).then((response) => {
        console.log(data);
        console.log('re');
        console.log(response);
      }).catch((e) => {
        console.log($(this).sortable('serialize'));
        console.log(e);
        console.log('err');
      });
    }
  });
  $(window).resize(function() {
    $('table.db tr').css('min-width', $('table.db').width());
  });
</script>
@endsection