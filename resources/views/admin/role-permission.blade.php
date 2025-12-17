@extends('admin.layouts.master')
@section('content')
    <div class="content-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 d-none">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Department Permission</h4>
                        </div>
                        
                    </div>
                </div>
                <!-- end -->
                
                <div class="col-lg-12">
                    <form method="post" action="{{route('admin.saveDepartmentPermission')}}" method="post">
                        @csrf
                    <input type="hidden" name="departmentId" value="{{Request::get('department')}}">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><b>{{$singleData->name}}</b> Permission</h4> 
                            <button class="btn btn-primary">Submit</button>
                        </div>
                        <div class="card-body">
                            <!-- <h5>Project Listing</h5>
                                               <hr> -->

                            <div class="row">
                                @php $i =1; @endphp
                                @foreach($menusArray as $key=>$val)
                                <div class="row">
                                          <div class="form-check form-switch">
                                            <input class="form-check-input" name="parentId[]" value="{{$val['_id']}}" type="checkbox" id="flexSwitchCheckDefault{{$val['_id']}}" onclick="parentCheckUncheck(`{{$val['_id']}}`)" {{in_array((string) $val['_id'], $parentId) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault{{$val['_id']}}" onclick="parentCheckUncheck(`{{$val['_id']}}`)">
                                               <strong> {{$val['name']}} </strong>
                                            </label>
                                          </div>
                                         
                                          @foreach ($val['routes'] as $k=>$v)
                                          <div class="col-xl-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input {{$val['_id']}}" name="childId[]" value="{{$v['_id']}}" type="checkbox" id="flexSwitchCheckDefaultS{{$key+$i}}" onclick="childCheckUncheck(`{{$val['_id']}}`,`{{$key+$i}}`)" {{in_array((string) $v['_id'], $childId) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="flexSwitchCheckDefaultS{{$key+$i}}" onclick="childCheckUncheck(`{{$val['_id']}}`,`{{$key+$i}}`)">{{$v['name']}}</label>
                                             </div>
                                          </div>
                                          @php $i++; @endphp
                                          @endforeach
                                          <hr>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script>
    function parentCheckUncheck(id){
        if ($('#flexSwitchCheckDefault' + id).is(':checked')) {
            $('.'+id).prop('checked', true);
        }else{
            $('.'+id).prop('checked', false);
        }
    }
    function childCheckUncheck(id, key){
        if ($('#flexSwitchCheckDefaultS' + key).is(':checked')) {
            $('#flexSwitchCheckDefault'+id).prop('checked', true);
        }
    }
</script>
@endsection
