@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team';@endphp
@endif

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
                    <form method="post" action="{{route($prefix.'.team.saveTeamPermission')}}" method="post">
                        @csrf
                    <input type="hidden" name="departmentId" value="{{Request::get('department')}}">
                    <input type="hidden" name="teamId" value="{{Request::get('team')}}">
                    
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
                             
                                @foreach($List as $key=>$val)
                                    @if(session()->has('team') && session()->get('team')->designation=='6790b9662ef8f2064c61d07e')
                                        <!-- skip add team -->
                                        @if($val['parentData']['_id'] == '67966ba130b53221d12f0eb5')
                                             @continue
                                        @endif
                                    @endif
                                <div class="row">
                                          <div class="form-check form-switch">
                                            <input class="form-check-input" name="parentId[]" value="{{$val['parentData']['_id']}}" type="checkbox" id="flexSwitchCheckDefault{{$val['parentData']['_id']}}" onclick="parentCheckUncheck(`{{$val['parentData']['_id']}}`)" {{in_array((string) $val['parentData']['_id'], $parentId) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault{{$val['parentData']['_id']}}" onclick="parentCheckUncheck(`{{$val['parentData']['_id']}}`)">
                                               <strong> {{$val['parentData']['name']}} </strong>
                                            </label>
                                          </div>
                                      
                                          @foreach ($val['childData'] as $k=>$v)
                                            
                                                <div class="col-xl-4">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input {{$val['parentData']['_id']}}" name="childId[]" value="{{$v['_id']}}" type="checkbox" id="flexSwitchCheckDefaultS{{$key+$i}}" onclick="childCheckUncheck(`{{$val['parentData']['_id']}}`,`{{$key+$i}}`)" {{in_array((string) $v['_id'], $childId) ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="flexSwitchCheckDefaultS{{$key+$i}}" onclick="childCheckUncheck(`{{$val['parentData']['_id']}}`,`{{$key+$i}}`)">{{$v['name']}}</label>
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
