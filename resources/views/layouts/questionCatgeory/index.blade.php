@extends('layouts.common.dashboard')
@section('content')

  <div class="content-wrapper">
    <div class="content">
      <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
        @if(!empty($successMsg))
          <div class="alert alert-success"> {{ $successMsg }}</div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success">
            {{ session()->get('message') }}
          </div>
        @endif

        <div class="d-flex justify-content-between">
          <h2 class="text-dark font-weight-medium"></h2>
        </div>
        <div class="row pt-5">
          <div class="col-sm-6">
            <h4><a href="{{URL::to('questionCategoryAdd')}}">
                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Question Category</button>
              </a></h4>
          </div>
          <div class="table-responsive">
            <table class="table mt-3">
              <thead>
              <tr>
                <th scope="col">Sr.</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
              </tr>
              </thead>
              <tbody>
                @forelse($QuestionCategories as $key => $QuestionCategory)
                  <tr>
                    <td>{{--{{ $Question->id}}--}} {{ $key+1 }}</td>
                    <td>{{ $QuestionCategory->category_name}}</td>
                    <td>
                      <a class="action_link" href="{{URL::to('questionCategoryEdit')}}?id={{ $QuestionCategory->id}}&amp;action=edit" title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>

                      &nbsp;&nbsp;

                      <a class="action_link" href="{{ request()->route()->uri }}?id={{ $QuestionCategory->id}}&amp;action=delete"
                         onclick="return confirm('Are You Sure You Want To Delete? Because Related Question Also Be Removed With It.')" title="Delete">
                        <i class="fa fa-dumpster"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8">
                      Data Not Found
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
