@extends('layouts.admin')
@section('title', 'Page Setting')

@section('content')
  <div class="admin-form-main-block mrg-t-40">
<div class="tabsetting">
  <a href="{{url('admin/settings')}}" style="color: #7f8c8d;" ><button class="tablinks">Genral Setting</button></a>
  <a href="{{url('admin/seo')}}" style="color: #7f8c8d;" ><button class="tablinks">SEO Setting</button></a>
  <a href="{{url('admin/api-settings')}}" style="color: #7f8c8d;"><button class="tablinks">API Setting</button></a>
  <a href="{{route('mail.getset')}}" style="color: #7f8c8d;"><button class="tablinks">Mail Setting</button></a>
  <a href="#" style="color: #7f8c8d;"><button class="tablinks active">Page Setting</button></a>
</div>
<div class="content-block box-body">

      
      <div style="display: none;" id="ss" class="alert alert-info">
        
      </div>
    
    <table id="full_detail_table" class="table table-hover">
      <thead>
        <tr class="table-heading-row">
        <th>#</th>
        <th>Page Name</th>
        <th>Page Status</th>
        <th>Action</th>
        </tr>
      </thead>
      @php $i=0;@endphp
      <tbody>
        <tr>
          <td>1</td>
          <td class="ht">{{ $ht1->key }}</td>
          <td>@if($ht1->status==1) Active @else Deactive @endif</td>
          
          <td>
            <form action="{{ route('pageset.update',$ht1->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht1->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>2</td>
          <td class="ht">{{ $ht2->key }}</td>
          <td>@if($ht2->status==1) Active @else Deactive @endif</td>
         
          <td>
            <form action="{{ route('pageset.update',$ht2->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht2->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>3</td>
          <td class="ht">{{ $ht3->key }}</td>

          <td>@if($ht3->status==1) Active @else Deactive @endif</td>
         
          <td>
            <form action="{{ route('pageset.update',$ht3->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht3->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>4</td>
          <td class="ht">{{ $ht4->key }} Language</td>
          <td>@if($ht4->status==1) Active @else Deactive @endif</td>
          
          <td>
            <form action="{{ route('pageset.update',$ht4->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht4->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>5</td>
          <td class="ht">{{ $ht5->key }} Language</td>
          <td>@if($ht5->status==1) Active @else Deactive @endif</td>
         
          <td>
            <form action="{{ route('pageset.update',$ht5->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht5->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>6</td>
          <td class="ht">{{ $ht6->key }} Genre</td>
          <td>@if($ht6->status==1) Active @else Deactive @endif</td>
          
          <td>
            <form action="{{ route('pageset.update',$ht6->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht6->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>7</td>
          <td class="ht">{{ $ht7->key }} Genre</td>
          <td>@if($ht7->status==1) Active @else Deactive @endif</td>
          
          <td>
            <form action="{{ route('pageset.update',$ht7->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht7->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>

        <tr>
          <td>8</td>
          <td class="ht">{{ $ht8->key }} Genre</td>
          <td>@if($ht8->status==1) Active @else Deactive @endif</td>
         
          <td>
            <form action="{{ route('pageset.update',$ht8->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              @if($ht8->status==1)
              <input type="submit" name="submit" value="OFF" class="btn btn-sm btn-danger"/>
              @else
              <input type="submit" name="submit" value="ON" class="btn btn-sm btn-success"/>
              @endif
            </form>
          </td>
        </tr>
      </tbody>
    </table>

</div>  
  </div>
@endsection

