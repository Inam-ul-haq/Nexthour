@extends('layouts.admin')
@section('title','All Coupons')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
      <a href="{{route('coupons.create')}}" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Create Coupon</a>
      <!-- Delete Modal -->
      <a type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#bulk_delete"><i class="material-icons left">delete</i> Delete Selected</a>   
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
              {!! Form::open(['method' => 'POST', 'action' => 'CouponController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-block box-body table-responsive">
      <table id="full_detail_table" class="table table-hover">
        <thead>
          <tr class="table-heading-row">
            <th>
              <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>
              #
            </th>
            <th>Coupon Code</th>
            <th>Percent Off</th>
            <th>Amount Off</th>
            <th>Duration</th>
            <th>Duration In Months</th>
            <th>Max Redm..</th>
            <th>Redeem By</th>
            <th>Delete</th>
          </tr>
        </thead>
        @if ($coupons)
          <tbody>
            @foreach ($coupons as $key => $coupon)
              <tr>
                <td>
                  <div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$coupon->id}}" id="checkbox{{$coupon->id}}">
                    <label for="checkbox{{$coupon->id}}" class="material-checkbox"></label>
                  </div>
                  {{$key+1}}
                </td>
                <td>{{$coupon->coupon_code}}</td>
                <td>{{$coupon->percent_off ? $coupon->percent_off.'%' : '-'}}</td>
                <td>
                  @if($coupon->amount_off)
                    <i class="{{$currency_symbol}} main-curr"></i>{{$coupon->amount_off}}
                  @endif
                </td>
                <td>{{$coupon->duration}}</td>
                <td>{{$coupon->duration_in_months}}</td>
                <td>{{$coupon->max_redemptions}}</td>
                <td>{{$coupon->redeem_by->diffForHumans()}}</td>
                <td>
                  <div class="admin-table-action-block">
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$coupon->id}}deleteModal"><i class="material-icons">delete</i> </button>
                  </div>
                </td>
              </tr>
              <!-- Delete Modal -->
              <div id="{{$coupon->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                      {!! Form::open(['method' => 'DELETE', 'action' => ['CouponController@destroy', $coupon->id]]) !!}
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
  </script>
@endsection