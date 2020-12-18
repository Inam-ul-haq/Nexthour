

<form method="post" action="{{url('paytem')}}" >
    {{csrf_field()}}
 <input type="text" name="price" value="10" >

 <button type="submit">Submit</button>
</form>