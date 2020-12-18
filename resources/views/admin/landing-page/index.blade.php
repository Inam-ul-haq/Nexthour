@extends('layouts.admin')
@section('title','Landing Pages')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
      <a href="{{route('landing-page.create')}}" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Create A Block</a>
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
              {!! Form::open(['method' => 'POST', 'action' => 'LandingPageController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
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
            <th>Image</th>
            <th>Heading</th>
            <th>Details</th>
            <th>Button</th>
            <th>Image Position</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if ($landing_pages)
          <tbody>
            @foreach ($landing_pages as $key => $block)
              <tr id="item-{{$block->id}}">
                <td>
                  <div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$block->id}}" id="checkbox{{$block->id}}">
                    <label for="checkbox{{$block->id}}" class="material-checkbox"></label>
                  </div>
                  {{$key+1}}
                </td>
                <td>
                  @if ($block->image != null) 
                    <img src="{{ asset('images/main-home/'.$block->image) }}" width="140px" height="50px" class="img-responsive">
                  @endif
                </td>
                <td>{{$block->heading}}</td>
                <td title="{{$block->detail}}">{{str_limit($block->detail, 50)}}</td>
                <td>
                  @if ($block->button == 1)
                    @if ($block->button_link == 'login')
                      <a href="#" data-toggle="tooltip" data-original-title="Login Link" class="btn btn-prime">{{$block->button_text}}</a>
                    @elseif ($block->button_link == 'register')  
                      <a href="#" data-toggle="tooltip" data-original-title="Register Link" class="btn btn-prime">{{$block->button_text}}</a>
                    @endif
                  @endif
                </td>
                <td>{{$block->left == 1 ? 'Left' : 'Right'}}</td>
                <td>
                  <div class="admin-table-action-block">
                    <a href="{{route('landing-page.edit', $block->id)}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$block->id}}deleteModal"><i class="material-icons">delete</i> </button>
                  </div>
                </td>
              </tr>
              <!-- Delete Modal -->
              <div id="{{$block->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                      {!! Form::open(['method' => 'DELETE', 'action' => ['LandingPageController@destroy', $block->id]]) !!}
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
        app.$http.post('{{route('landing_page_reposition')}}', {item: data}).then((response) => {
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